<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manga;
use App\Models\Author;
use App\Models\User; 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MangaController extends Controller
{
    // INDEX: Menampilkan dashboard manga khusus milik user yang login
    public function index(Request $request)
    {
        // Mengamankan halaman, jika tidak login langsung lempar ke form login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Mengambil data langsung dari model Manga berdasarkan user_id 
        $query = Manga::where('user_id', Auth::id())->with('author');

        // LOGIKA PENCARIAN
        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhereHas('author', function($queryAuthor) use ($search) {
                    $queryAuthor->where('name', 'LIKE', '%' . $search . '%');
                });
            });
        }

        // Ambil data hasil query yang diurutkan dari yang terbaru
        $mangas = $query->latest()->get();

                // Kelompokkan data berdasarkan status untuk kebutuhan view kamu
                $wishlist  = $mangas->where('status', 'Wishlist'); 
                $backlog   = $mangas->where('status', 'Backlog');
                $reading   = $mangas->where('status', 'Reading');
                $completed = $mangas->where('status', 'Completed');

                // Kirim semua data ke view
                return view('manga.index', compact('wishlist', 'backlog', 'reading', 'completed', 'mangas'));
    }

    // CREATE: Menampilkan halaman form tambah
    public function create()
    {
        // 1. Ambil semua data author dari database untuk dropdown pilihan
        $authors = Author::orderBy('name', 'asc')->get();

        // 2. Kirim variabel $authors ke halaman create
        return view('manga.create', compact('authors'));
    }

// STORE: Menyimpan data manga baru ke database terikat ke user yang login
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'volumes_owned' => 'required|integer|min:0',
            'last_read_chapter' => 'nullable|integer|min:0', 
            'target_chapter' => 'nullable|integer|min:0',   
            'status' => 'required|in:Backlog,Reading,Completed,Wishlist',
        ]);

        // Menyusun data untuk disimpan ke database
        $data = [
            'title'             => $request->title,
            'volumes_owned'     => $request->volumes_owned ?? 0,
            'last_read_chapter' => $request->last_read_chapter ?? 0, // Jika kosong otomatis 0
            'target_chapter'    => $request->target_chapter ?? 0,    // Jika kosong otomatis 0
            'status'            => $request->status,
        ];

        // Logika Pengisian Author
        if ($request->filled('new_author')) {
            $author = Author::firstOrCreate(['name' => $request->new_author]); 
            $data['author_id'] = $author->id;  
        } elseif ($request->filled('author_id')) { 
            $data['author_id'] = $request->author_id;
        }

        // Logika Proses Gambar dari Cropper
        if ($request->filled('cropped_image')) { 
            $image_parts = explode(";base64,", $request->cropped_image); 
            $image_type_aux = explode("image/", $image_parts[0]); 
            $image_type = $image_type_aux[1]; 
            $image_base64 = base64_decode($image_parts[1]); 
            
            $fileName = 'covers/' . uniqid() . '.' . $image_type; 
            
            Storage::disk('public')->put($fileName, $image_base64);
            
            $data['cover_image'] = $fileName; 
        }

        // Trik jitu: Memasukkan ID User yang sedang aktif langsung ke dalam array data
        $data['user_id'] = Auth::id();
        
        Manga::create($data); 

        return redirect()->route('manga.index')->with('success', 'Manga berhasil disimpan dengan cover proporsional!');
    }
        
    // EDIT: Menampilkan halaman form edit
    public function edit(Manga $manga)
    {
        // 1. Ambil semua data author dari database dan urutkan sesuai abjad A-Z
        $authors = Author::orderBy('name', 'asc')->get();

        // 2. Kirim data $manga DAN $authors sekaligus ke halaman edit
        return view('manga.edit', compact('manga', 'authors')); 
    }

// UPDATE: Memperbarui data manga
    public function update(Request $request, Manga $manga)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|max:255',
            'volumes_owned' => 'required|integer|min:0',
            'last_read_chapter' => 'nullable|integer|min:0', 
            'target_chapter' => 'nullable|integer|min:0',   
            'status' => 'required|in:Backlog,Reading,Completed,Wishlist',
        ]);

        // Menyusun data untuk diperbarui ke database
        $data = [
            'title'             => $request->title,
            'volumes_owned'     => $request->volumes_owned ?? 0,
            'last_read_chapter' => $request->last_read_chapter ?? 0,
            'target_chapter'    => $request->target_chapter ?? 0, 
            'status'            => $request->status,
        ];

        // Logika Author saat Edit
        if ($request->filled('new_author')) {
            $author = Author::firstOrCreate(['name' => $request->new_author]);
            $data['author_id'] = $author->id;
        } else {
            $data['author_id'] = $request->author_id;
        }

        // LOGIKA PROSES UPDATE GAMBAR CROP:
        if ($request->filled('cropped_image')) {
            if ($manga->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($manga->cover_image);
            }

            $image_parts = explode(";base64,", $request->cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            
            $fileName = 'covers/' . uniqid() . '.' . $image_type;
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $image_base64);
            
            $data['cover_image'] = $fileName;
        } else {
            $data['cover_image'] = $manga->cover_image;
        }

        // Eksekusi update ke database
        $manga->update($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('manga.index')->with('success', 'Manga berhasil diperbarui dengan cover proporsional!');
    }

    // DELETE: Menghapus data manga
    public function destroy(Manga $manga)
    {
        // Hapus file cover image dari storage jika ada
        if ($manga->cover_image) {
            Storage::disk('public')->delete($manga->cover_image);
        }
        
        // Hapus data manga dari database
        $manga->delete();
        return redirect()->route('manga.index')->with('success', 'Manga berhasil dihapus!');
    }

    // PATCH: Menambahkan 1 ke last_read_chapter
    public function incrementChapter($id)
    {
        // Temukan manga berdasarkan ID, jika tidak ditemukan akan menampilkan 404
        $manga = Manga::findOrFail($id);

        // Tambahkan 1 ke last_read_chapter
        $manga->last_read_chapter += 1;

        // Jika target_chapter sudah diatur (> 0) 
        // dan bab yang dibaca sudah menyamai atau melebihi target
        if ($manga->target_chapter > 0 && $manga->last_read_chapter >= $manga->target_chapter) {  
            $manga->status = 'Completed';
        } else {
            // Jika awalnya Backlog lalu mulai dibaca, otomatis pindah ke Reading
            if ($manga->status == 'Backlog') {
                $manga->status = 'Reading';
            }
        }

        // Simpan perubahan ke database
        $manga->save();

        return back()->with('success', 'Progres bacaan berhasil ditingkatkan!');
    }
}