<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manga;
use App\Models\Author;
use App\Models\User; 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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

    // SEARCH LIBRARY: Mencari manga di perpustakaan online (AniList API)
    public function searchLibrary(Request $request)
    {
        $query = trim($request->input('q', ''));
        if (mb_strlen($query) < 2) {
            return response()->json([]);
        }

        $cacheKey = 'manga_lib_search_' . md5(strtolower($query));
        $results = Cache::remember($cacheKey, 3600, function () use ($query) {
            return $this->fetchFromAniList($query);
        });

        return response()->json($results);
    }

    // PROXY COVER: Memberikan proxy gambar agar Cropper.js bebas dari hambatan CORS di browser
    public function proxyCover(Request $request)
    {
        $imageUrl = $request->input('url');
        if (!$imageUrl || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return response('Invalid URL', 400);
        }

        try {
            $response = Http::withoutVerifying()->timeout(8)->get($imageUrl);
            if ($response->successful()) {
                $contentType = $response->header('Content-Type') ?: 'image/jpeg';
                return response($response->body(), 200, [
                    'Content-Type' => $contentType,
                    'Access-Control-Allow-Origin' => '*',
                    'Cache-Control' => 'public, max-age=86400'
                ]);
            }
        } catch (\Exception $e) {
            // Fallback
        }

        return response('Failed to load image', 500);
    }

    // FETCH ANILIST HELPER
    private function fetchFromAniList($search)
    {
        $gql = '
        query ($search: String) {
          Page(page: 1, perPage: 8) {
            media(search: $search, type: MANGA, sort: POPULARITY_DESC) {
              id
              title {
                romaji
                english
                native
              }
              staff {
                edges {
                  role
                  node {
                    name {
                      full
                    }
                  }
                }
              }
              coverImage {
                extraLarge
                large
                medium
              }
              chapters
              volumes
              status
              description(asHtml: false)
              averageScore
              genres
              startDate {
                year
              }
            }
          }
        }
        ';

        try {
            $response = Http::withoutVerifying()
                ->timeout(8)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post('https://graphql.anilist.co', [
                    'query' => $gql,
                    'variables' => ['search' => $search]
                ]);

            if (!$response->successful()) {
                return [];
            }

            $json = $response->json();
            $mediaList = $json['data']['Page']['media'] ?? [];
            $results = [];

            foreach ($mediaList as $item) {
                // Parse mangaka / author
                $authors = [];
                if (!empty($item['staff']['edges'])) {
                    foreach ($item['staff']['edges'] as $edge) {
                        $role = strtolower($edge['role'] ?? '');
                        $name = $edge['node']['name']['full'] ?? null;
                        if ($name && (
                            str_contains($role, 'story & art') ||
                            str_contains($role, 'story') ||
                            str_contains($role, 'art') ||
                            str_contains($role, 'original story') ||
                            str_contains($role, 'author') ||
                            str_contains($role, 'mangaka') ||
                            str_contains($role, 'creator')
                        )) {
                            if (!in_array($name, $authors)) {
                                $authors[] = $name;
                            }
                        }
                    }
                    if (empty($authors) && !empty($item['staff']['edges'][0]['node']['name']['full'])) {
                        $authors[] = $item['staff']['edges'][0]['node']['name']['full'];
                    }
                }

                $authorName = !empty($authors) ? implode(', ', array_slice($authors, 0, 2)) : '';

                // Judul utama: English jika ada, jika tidak gunakan Romaji
                $title = $item['title']['english'] ?: $item['title']['romaji'];
                $altTitle = ($item['title']['romaji'] !== $title) ? $item['title']['romaji'] : ($item['title']['native'] ?? '');

                $rawStatus = $item['status'] ?? '';
                $appStatus = 'Backlog';
                if ($rawStatus === 'FINISHED') {
                    $appStatus = 'Completed';
                }

                $desc = strip_tags($item['description'] ?? '');
                $desc = preg_replace('/\s+/', ' ', $desc);
                if (mb_strlen($desc) > 160) {
                    $desc = mb_substr($desc, 0, 160) . '...';
                }

                $coverUrl = $item['coverImage']['extraLarge'] ?? $item['coverImage']['large'] ?? $item['coverImage']['medium'] ?? '';

                $results[] = [
                    'id' => $item['id'],
                    'title' => $title,
                    'romaji_title' => $item['title']['romaji'] ?? '',
                    'native_title' => $item['title']['native'] ?? '',
                    'alt_title' => $altTitle,
                    'author' => $authorName ?: 'Unknown Author',
                    'cover' => $coverUrl,
                    'chapters' => $item['chapters'] ?? null,
                    'volumes' => $item['volumes'] ?? null,
                    'year' => $item['startDate']['year'] ?? null,
                    'score' => $item['averageScore'] ? ($item['averageScore'] / 10) : null,
                    'status' => $appStatus,
                    'raw_status' => $rawStatus,
                    'description' => $desc,
                    'genres' => array_slice($item['genres'] ?? [], 0, 3)
                ];
            }

            return $results;
        } catch (\Exception $e) {
            return [];
        }
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
            'last_read_chapter' => $request->last_read_chapter ?? 0,
            'target_chapter'    => $request->target_chapter ?? 0,
            'status'            => $request->status,
        ];

        // Logika Pengisian Author
        if ($request->filled('author_id')) {
            if (str_starts_with($request->author_id, 'new:')) {
                $authorName = trim(substr($request->author_id, 4));
                $author = Author::firstOrCreate(['name' => $authorName]);
                $data['author_id'] = $author->id;
            } else {
                $data['author_id'] = $request->author_id;
            }
        } elseif ($request->filled('new_author')) {
            $author = Author::firstOrCreate(['name' => trim($request->new_author)]); 
            $data['author_id'] = $author->id;  
        }

        // Logika Proses Gambar dari Cropper atau Remote URL
        if ($request->filled('cropped_image')) { 
            $image_parts = explode(";base64,", $request->cropped_image); 
            $image_type_aux = explode("image/", $image_parts[0]); 
            $image_type = $image_type_aux[1] ?? 'jpeg'; 
            $image_base64 = base64_decode($image_parts[1]); 
            
            $fileName = 'covers/' . uniqid() . '.' . $image_type; 
            Storage::disk('public')->put($fileName, $image_base64);
            
            $data['cover_image'] = $fileName; 
        } elseif ($request->filled('remote_cover_url')) {
            try {
                $imgResponse = Http::withoutVerifying()->timeout(10)->get($request->remote_cover_url);
                if ($imgResponse->successful()) {
                    $ext = 'jpg';
                    $contentType = $imgResponse->header('Content-Type');
                    if (str_contains($contentType, 'png')) {
                        $ext = 'png';
                    } elseif (str_contains($contentType, 'webp')) {
                        $ext = 'webp';
                    }

                    $fileName = 'covers/' . uniqid() . '.' . $ext;
                    Storage::disk('public')->put($fileName, $imgResponse->body());
                    $data['cover_image'] = $fileName;
                }
            } catch (\Exception $e) {
                // Ignore failure
            }
        }

        // Memasukkan ID User yang sedang aktif
        $data['user_id'] = Auth::id();
        
        Manga::create($data); 

        return redirect()->route('manga.index')->with('success', 'Manga berhasil disimpan ke koleksimu!');
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
        if ($request->filled('author_id')) {
            if (str_starts_with($request->author_id, 'new:')) {
                $authorName = trim(substr($request->author_id, 4));
                $author = Author::firstOrCreate(['name' => $authorName]);
                $data['author_id'] = $author->id;
            } else {
                $data['author_id'] = $request->author_id;
            }
        } elseif ($request->filled('new_author')) {
            $author = Author::firstOrCreate(['name' => trim($request->new_author)]);
            $data['author_id'] = $author->id;
        }

        // LOGIKA PROSES UPDATE GAMBAR:
        if ($request->filled('cropped_image')) {
            if ($manga->cover_image) {
                Storage::disk('public')->delete($manga->cover_image);
            }

            $image_parts = explode(";base64,", $request->cropped_image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1] ?? 'jpeg';
            $image_base64 = base64_decode($image_parts[1]);
            
            $fileName = 'covers/' . uniqid() . '.' . $image_type;
            Storage::disk('public')->put($fileName, $image_base64);
            
            $data['cover_image'] = $fileName;
        } elseif ($request->filled('remote_cover_url')) {
            try {
                $imgResponse = Http::withoutVerifying()->timeout(10)->get($request->remote_cover_url);
                if ($imgResponse->successful()) {
                    if ($manga->cover_image) {
                        Storage::disk('public')->delete($manga->cover_image);
                    }
                    $ext = 'jpg';
                    $contentType = $imgResponse->header('Content-Type');
                    if (str_contains($contentType, 'png')) {
                        $ext = 'png';
                    } elseif (str_contains($contentType, 'webp')) {
                        $ext = 'webp';
                    }

                    $fileName = 'covers/' . uniqid() . '.' . $ext;
                    Storage::disk('public')->put($fileName, $imgResponse->body());
                    $data['cover_image'] = $fileName;
                }
            } catch (\Exception $e) {
                // Ignore
            }
        } else {
            $data['cover_image'] = $manga->cover_image;
        }

        // Eksekusi update ke database
        $manga->update($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('manga.index')->with('success', 'Manga berhasil diperbarui!');
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