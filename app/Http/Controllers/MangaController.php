<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Author;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MangaController extends Controller
{
   public function index(Request $request)
    {
        // 1. Ambil query dasar model Manga beserta relasi author-nya
        $query = Manga::with('author');

        // 2. LOGIKA PENCARIAN (PENTING):
        // Jika user mengetik sesuatu di kolom search
        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                // Cari berdasarkan judul manga yang mirip
                $q->where('title', 'LIKE', '%' . $search . '%')
                // ATAU cari berdasarkan nama author di tabel relasinya
                ->orWhereHas('author', function($queryAuthor) use ($search) {
                    $queryAuthor->where('name', 'LIKE', '%' . $search . '%');
                });
            });
        }

        // 3. Ambil data hasil query (urutkan berdasarkan yang terbaru jika mau)
        $mangas = $query->latest()->get();


        // 4. Kelompokkan berdasarkan status untuk tampilan papan Kanban kamu
        $backlog   = $mangas->where('status', 'Backlog');
        $reading   = $mangas->where('status', 'Reading');
        $completed = $mangas->where('status', 'Completed');

        // 5. Lempar semua data (TERMASUK $mangas) ke halaman index
        // TAMBAHKAN 'mangas' DI DALAM COMPACT SEPERTI DI BAWAH INI:
        return view('manga.index', compact('backlog', 'reading', 'completed', 'mangas'));
    }

    // CREATE: Menampilkan halaman form tambah
    public function create()
    {
        // 1. Ambil semua data author dari database untuk dropdown pilihan
        $authors = Author::orderBy('name', 'asc')->get();

        // 2. Kirim variabel $authors ke halaman create
        return view('manga.create', compact('authors'));
    }

    // STORE: Menyimpan data manga baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'status' => 'required',
        ]);

        $data = [
            'title'             => $request->title,
            'volumes_owned'     => $request->volumes_owned ?? 0,
            'last_read_chapter' => $request->last_read_chapter ?? 0,
            'status'            => $request->status,
        ];

        // Logika Author
        if ($request->filled('new_author')) {
            $author = Author::firstOrCreate(['name' => $request->new_author]);
            $data['author_id'] = $author->id;
        } elseif ($request->filled('author_id')) {
            $data['author_id'] = $request->author_id;
        }

        // LOGIKA PROSES GAMBAR YANG DI-CROP (PENTING):
        if ($request->filled('cropped_image')) {
            $image_parts = explode(";base64,", $request->cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            
            // Buat nama file unik
            $fileName = 'covers/' . uniqid() . '.' . $image_type;
            
            // Simpan langsung ke disk public rahasia laravel
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $image_base64);
            
            $data['cover_image'] = $fileName;
        }

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
        $request->validate([
            'title' => 'required|max:255',
            'status' => 'required',
        ]);

        $data = [
            'title'             => $request->title,
            'volumes_owned'     => $request->volumes_owned ?? 0,
            'last_read_chapter' => $request->last_read_chapter ?? 0,
            'status'            => $request->status,
        ];

        // Logika Author saat Edit
        if ($request->filled('new_author')) {
            $author = Author::firstOrCreate(['name' => $request->new_author]);
            $data['author_id'] = $author->id;
        } else {
            $data['author_id'] = $request->author_id;
        }

        // LOGIKA PROSES PROSES UPDATE GAMBAR CROP (PENTING):
        if ($request->filled('cropped_image')) {
            // 1. Jika komik ini punya file cover lama, hapus dari folder storage
            if ($manga->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($manga->cover_image);
            }

            // 2. Dekode teks Base64 gambar baru menjadi file gambar mentah
            $image_parts = explode(";base64,", $request->cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            
            // 3. Buat nama file cover acak yang unik
            $fileName = 'covers/' . uniqid() . '.' . $image_type;
            
            // 4. Masukkan file ke dalam disk public laravel
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $image_base64);
            
            // Masukkan data nama file baru ke array update
            $data['cover_image'] = $fileName;
        } else {
            // Jika user tidak memilih file gambar baru, tetap pertahankan nama file cover yang lama
            $data['cover_image'] = $manga->cover_image;
        }

        // Eksekusi update ke database
        $manga->update($data);

        return redirect()->route('manga.index')->with('success', 'Manga berhasil diperbarui dengan cover proporsional!');
    }

    // DELETE: Menghapus data manga
    public function destroy(Manga $manga)
    {
        if ($manga->cover_image) {
            Storage::disk('public')->delete($manga->cover_image);
        }
        
        $manga->delete();
        return redirect()->route('manga.index')->with('success', 'Manga berhasil dihapus!');
    }

    // PATCH: Menambahkan 1 ke last_read_chapter
    public function incrementChapter(Manga $manga)
    {
        // Tambahkan angka chapter lama dengan 1
        $manga->increment('last_read_chapter');

        // Jika ingin otomatis mengubah status ke 'Completed' saat mencapai chapter tertentu,
        // kamu bisa tambahkan logika pengondisian di sini nanti.

        return redirect()->route('manga.index')->with('success', "Chapter {$manga->title} berhasil dinaikkan!");
    }
}