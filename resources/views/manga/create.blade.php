<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Manga - Manga Noted</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .image-container {
            width: 100%;
            min-height: 320px;
            max-height: 460px;
            background-color: #f1f5f9;
            border-radius: 12px;
            overflow: hidden;
        }
        img#image-to-crop {
            display: block;
            max-width: 100%;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen">

    <!-- Header Navbar -->
    <nav class="bg-[#1e293b] text-white px-4 sm:px-8 py-3.5 sm:py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-2 font-semibold text-lg sm:text-xl tracking-wide">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span>Manga Noted</span>
        </div>
        <a href="{{ route('manga.index') }}" class="text-xs sm:text-sm text-slate-300 hover:text-white transition flex items-center gap-1.5 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Dashboard</span>
        </a>
    </nav>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-6 sm:py-10">

        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Tambah Manga Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Cari manga di library online atau pilih data secara langsung.</p>
        </div>

        <!-- ==================== FITUR PENCARIAN PERPUSTAKAAN MANGA ==================== -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-5 sm:p-6 mb-6 sm:mb-8 relative overflow-hidden">
            <div class="flex items-center justify-between mb-3 gap-2">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-[#2b4c7e] text-white shadow-2xs shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-tight">Cari dari Manga Library</h2>
                        <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Otomatis mengisi Judul, Mangaka / Author, Target Chapter & Full Cover.</p>
                    </div>
                </div>
                <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#2b4c7e] bg-[#f0f4f8] px-2.5 py-1 rounded-full border border-slate-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#2b4c7e]"></span> Auto-Fill
                </span>
            </div>

            <!-- Search Input Box -->
            <div class="relative mt-3">
                <div class="relative flex items-center">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    
                    <input type="text" id="library-search-input" autocomplete="off"
                           class="w-full pl-10 sm:pl-11 pr-20 py-2.5 sm:py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-800 text-xs sm:text-sm placeholder-slate-400 focus:outline-none focus:border-[#2b4c7e] focus:bg-white focus:ring-2 focus:ring-[#2b4c7e]/15 transition shadow-2xs"
                           placeholder="Ketik judul manga (cth: Jujutsu Kaisen, One Piece, Berserk)...">

                    <div class="absolute right-2.5 flex items-center gap-1.5">
                        <button type="button" id="btn-clear-search" class="hidden text-slate-400 hover:text-slate-600 p-1 rounded-md transition" title="Bersihkan pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <div id="search-spinner" class="hidden">
                            <svg class="animate-spin h-4 w-4 text-[#2b4c7e]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Dropdown Hasil Pencarian -->
                <div id="library-results-container" class="hidden mt-2 bg-white rounded-xl border border-slate-200 shadow-xl overflow-hidden z-30 transition-all max-h-96 overflow-y-auto custom-scrollbar">
                    <div id="library-results-list" class="divide-y divide-slate-100"></div>
                </div>

                <div id="library-no-results" class="hidden mt-2 p-4 text-center bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-500 font-medium">
                    Tidak ditemukan manga dengan judul tersebut.
                </div>
            </div>

            <!-- Banner Notifikasi Saat Manga Terpilih -->
            <div id="selected-manga-alert" class="hidden mt-4 p-3 bg-[#f0f4f8] border border-[#cbd5e1] rounded-xl text-slate-800 text-xs flex items-center justify-between transition-all">
                <div class="flex items-center gap-2">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2b4c7e] text-white shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <div class="truncate">
                        <span class="font-bold text-slate-900" id="selected-alert-title"></span> terpilih! Mangaka: <strong class="text-[#2b4c7e]" id="selected-alert-author"></strong>
                    </div>
                </div>
                <button type="button" id="btn-reset-selection" class="text-slate-600 hover:text-slate-900 font-semibold underline text-xs cursor-pointer ml-2 shrink-0">
                    Reset
                </button>
            </div>
        </div>

        <!-- ==================== FORM DATA MANGA ==================== -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 sm:p-8">
            <div class="mb-5 pb-4 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-800">Detail Informasi Manga</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Status tracking akan otomatis menyesuaikan progres yang kamu input.</p>
                </div>
            </div>

            <form action="{{ route('manga.store') }}" method="POST" enctype="multipart/form-data" id="manga-form" class="space-y-4 sm:space-y-5">
                @csrf

                <input type="hidden" name="remote_cover_url" id="remote-cover-url">

                <!-- Judul Manga -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5 flex items-center justify-between">
                        <span>Judul Manga <span class="text-red-500">*</span></span>
                        <span id="title-source-badge" class="hidden text-[10px] font-bold text-[#2b4c7e] bg-[#f0f4f8] px-2 py-0.5 rounded-md border border-slate-200">Dari Library</span>
                    </label>
                    <input type="text" name="title" id="input-title" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm focus:outline-none focus:border-[#2b4c7e] focus:ring-2 focus:ring-[#2b4c7e]/15 transition shadow-2xs font-medium"
                           placeholder="Contoh: Chainsaw Man">
                </div>

                <!-- Mangaka / Author Dropdown (Custom Styled) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Mangaka / Author</label>
                        <span id="author-status-badge" class="hidden text-[10px] font-bold text-[#2b4c7e] bg-[#f0f4f8] px-2 py-0.5 rounded-md border border-slate-200">Otomatis Terpilih</span>
                    </div>
                    <div class="relative">
                        <select name="author_id" id="select-author"
                                class="w-full appearance-none px-4 py-2.5 pr-10 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm focus:outline-none focus:border-[#2b4c7e] focus:ring-2 focus:ring-[#2b4c7e]/15 transition cursor-pointer shadow-2xs hover:border-slate-300">
                            <option value="">-- Pilih Author --</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" data-name="{{ strtolower($author->name) }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Grid Volumes, Chapters & Target Chapter -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Volume Dimiliki</label>
                        <input type="number" name="volumes_owned" id="input-volumes" value="0" min="0" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm focus:outline-none focus:border-[#2b4c7e] focus:ring-2 focus:ring-[#2b4c7e]/15 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Chapter Terakhir</label>
                        <input type="number" name="last_read_chapter" id="input-last-chapter" value="0" min="0" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm focus:outline-none focus:border-[#2b4c7e] focus:ring-2 focus:ring-[#2b4c7e]/15 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider mb-1.5 text-[#2b4c7e] font-bold flex items-center justify-between">
                            <span>Target Chapter Goal</span>
                            <span id="target-badge" class="hidden text-[10px] font-semibold text-[#2b4c7e] bg-[#f0f4f8] px-1.5 rounded border border-slate-200">Total Ch</span>
                        </label>
                        <input type="number" name="target_chapter" id="input-target-chapter" value="0" min="0" required
                               class="w-full px-4 py-2.5 rounded-xl border border-[#cbd5e1] bg-[#f0f4f8]/40 text-slate-800 text-xs sm:text-sm font-semibold focus:outline-none focus:border-[#2b4c7e] focus:ring-2 focus:ring-[#2b4c7e]/15 transition"
                               placeholder="Misal: 150">
                    </div>
                </div>

                <!-- Status Tracking (Automated & Custom Styled Dropdown) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">Status Tracking <span class="text-red-500">*</span></label>
                        <span id="status-auto-badge" class="text-[10px] font-semibold text-[#2b4c7e] bg-[#f0f4f8] px-2 py-0.5 rounded-md border border-slate-200 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Auto-Sync</span>
                        </span>
                    </div>
                    <div class="relative">
                        <select name="status" id="select-status" required
                                class="w-full appearance-none px-4 py-2.5 pr-10 rounded-xl border border-slate-200 bg-white text-slate-800 text-xs sm:text-sm focus:outline-none focus:border-[#2b4c7e] focus:ring-2 focus:ring-[#2b4c7e]/15 transition cursor-pointer shadow-2xs hover:border-slate-300 font-medium">
                            <option value="Backlog">Backlog (Belum Dibaca)</option>
                            <option value="Reading">Reading (Sedang Dibaca)</option>
                            <option value="Completed">Completed (Tamat)</option>
                            <option value="Wishlist">Wishlist (Rencana Beli)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Cover Section (Full Cover 3:4) -->
                <div class="border-t border-slate-100 pt-4">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-2">Cover Gambar Manga (Full Cover)</label>

                    <!-- Preview Cover Resmi dari Library -->
                    <div id="library-cover-box" class="hidden mb-4 p-3.5 sm:p-4 bg-[#f0f4f8]/60 border border-slate-200 rounded-2xl">
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="w-24 h-32 sm:w-28 sm:h-38 rounded-xl overflow-hidden shadow-xs bg-slate-200 shrink-0 border border-slate-200">
                                <img id="library-cover-img" src="" alt="Cover Resmi" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 text-center sm:text-left space-y-1.5">
                                <div class="inline-flex items-center gap-1.5 text-[11px] font-bold text-[#2b4c7e] bg-white px-2.5 py-0.5 rounded-md border border-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#2b4c7e]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Cover Resmi Library Terpilih</span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Cover resmi telah disiapkan dalam format Full Cover 3:4.
                                </p>
                                <div class="pt-2 flex flex-wrap gap-2 justify-center sm:justify-start">
                                    <button type="button" id="btn-crop-remote" class="bg-[#2b4c7e] hover:bg-[#1f375b] text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-2xs transition flex items-center gap-1.5 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Sesuaikan Potongan (3:4)</span>
                                    </button>
                                    <button type="button" id="btn-remove-remote" class="bg-white hover:bg-slate-100 border border-slate-200 text-slate-600 text-xs font-medium px-3 py-1.5 rounded-lg transition cursor-pointer">
                                        Gunakan File Sendiri
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Input File Manual -->
                    <div id="upload-wrapper" class="space-y-3">
                        <input type="file" id="image-input" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#f0f4f8] file:text-[#2b4c7e] hover:file:bg-slate-200 transition border border-slate-200 p-2 rounded-xl">
                    </div>
                    
                    <input type="hidden" name="cropped_image" id="cropped-image-data">

                    <!-- Kotak Editor Cropper -->
                    <div id="crop-wrapper" class="hidden border border-slate-200 p-3 sm:p-4 rounded-xl bg-slate-50 my-4">
                        <div class="text-xs text-slate-600 mb-2 font-semibold flex items-center justify-between">
                            <span>Sesuaikan potongan cover manga kamu (Rasio Full Cover 3:4):</span>
                        </div>
                        <div class="image-container flex justify-center items-center shadow-xs">
                            <img id="image-to-crop" src="" crossorigin="anonymous">
                        </div>
                        <div class="mt-3 flex items-center justify-end gap-2">
                            <button type="button" id="btn-cancel-crop" class="bg-white hover:bg-slate-100 border border-slate-200 text-slate-600 rounded-lg px-3.5 py-1.5 text-xs font-medium transition cursor-pointer">
                                Batal
                            </button>
                            <button type="button" id="btn-crop" class="bg-[#2b4c7e] hover:bg-[#1f375b] text-white rounded-lg px-4 py-1.5 text-xs font-bold shadow-xs transition cursor-pointer flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Kunci Potongan Cover</span>
                            </button>
                        </div>
                    </div>

                    <!-- Hasil Potongan Preview -->
                    <div id="result-wrapper" class="hidden text-center bg-slate-50/70 p-4 border border-slate-100 rounded-xl my-4">
                        <div class="text-xs text-slate-500 mb-2 font-medium">Hasil Potongan Full Cover:</div>
                        <div class="w-32 h-44 sm:w-36 sm:h-48 mx-auto p-1 bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">
                            <img id="cropped-preview" class="w-full h-full object-cover rounded-lg">
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="pt-4 flex items-center justify-end gap-2.5 sm:gap-3 border-t border-slate-100">
                    <a href="{{ route('manga.index') }}" class="px-4 sm:px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs sm:text-sm font-medium transition">
                        Kembali
                    </a>
                    <button type="submit" class="bg-[#2b4c7e] hover:bg-[#1f375b] text-white rounded-xl px-5 sm:px-7 py-2.5 text-xs sm:text-sm font-semibold shadow-xs hover:shadow transition cursor-pointer flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Manga</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

<script>
let cropper;
const imageInput = document.getElementById('image-input');
const imageToCrop = document.getElementById('image-to-crop');
const cropWrapper = document.getElementById('crop-wrapper');
const btnCrop = document.getElementById('btn-crop');
const btnCancelCrop = document.getElementById('btn-cancel-crop');
const croppedImageData = document.getElementById('cropped-image-data');
const resultWrapper = document.getElementById('result-wrapper');
const croppedPreview = document.getElementById('cropped-preview');

// Library elements
const searchInput = document.getElementById('library-search-input');
const btnClearSearch = document.getElementById('btn-clear-search');
const searchSpinner = document.getElementById('search-spinner');
const resultsContainer = document.getElementById('library-results-container');
const resultsList = document.getElementById('library-results-list');
const noResults = document.getElementById('library-no-results');

const selectedAlert = document.getElementById('selected-manga-alert');
const selectedAlertTitle = document.getElementById('selected-alert-title');
const selectedAlertAuthor = document.getElementById('selected-alert-author');
const btnResetSelection = document.getElementById('btn-reset-selection');

const inputTitle = document.getElementById('input-title');
const titleBadge = document.getElementById('title-source-badge');
const selectAuthor = document.getElementById('select-author');
const authorBadge = document.getElementById('author-status-badge');
const inputVolumes = document.getElementById('input-volumes');
const inputLastChapter = document.getElementById('input-last-chapter');
const inputTargetChapter = document.getElementById('input-target-chapter');
const targetBadge = document.getElementById('target-badge');
const selectStatus = document.getElementById('select-status');

const remoteCoverUrlInput = document.getElementById('remote-cover-url');
const libraryCoverBox = document.getElementById('library-cover-box');
const libraryCoverImg = document.getElementById('library-cover-img');
const btnCropRemote = document.getElementById('btn-crop-remote');
const btnRemoveRemote = document.getElementById('btn-remove-remote');

let searchDebounceTimer = null;
let currentRemoteCover = '';

// ==================== AUTOMATISASI STATUS TRACKING ====================
function autoUpdateStatus() {
    const volumes = parseInt(inputVolumes.value) || 0;
    const lastChapter = parseInt(inputLastChapter.value) || 0;
    const targetChapter = parseInt(inputTargetChapter.value) || 0;

    // 1. Jika sesuai/melebihi chapter goal (> 0), status -> Completed
    if (targetChapter > 0 && lastChapter >= targetChapter) {
        selectStatus.value = 'Completed';
    } 
    // 2. Jika ada volume >= 1 atau chapter >= 1, status -> Reading
    else if (volumes >= 1 || lastChapter >= 1) {
        selectStatus.value = 'Reading';
    } 
    // 3. Jika volume masih 0 dan chapter masih 0, status -> Backlog
    else if (volumes === 0 && lastChapter === 0) {
        if (selectStatus.value !== 'Wishlist') {
            selectStatus.value = 'Backlog';
        }
    }
}

// Pasang listener otomatisasi ke input volume & chapter
inputVolumes.addEventListener('input', autoUpdateStatus);
inputLastChapter.addEventListener('input', autoUpdateStatus);
inputTargetChapter.addEventListener('input', autoUpdateStatus);

// ==================== SEARCH LIBRARY LOGIC ====================
searchInput.addEventListener('input', function() {
    const query = this.value.trim();

    if (query.length > 0) {
        btnClearSearch.classList.remove('hidden');
    } else {
        btnClearSearch.classList.add('hidden');
    }

    if (searchDebounceTimer) {
        clearTimeout(searchDebounceTimer);
    }

    if (query.length < 2) {
        resultsContainer.classList.add('hidden');
        noResults.classList.add('hidden');
        searchSpinner.classList.add('hidden');
        return;
    }

    searchSpinner.classList.remove('hidden');

    searchDebounceTimer = setTimeout(() => {
        fetchMangaLibrary(query);
    }, 350);
});

btnClearSearch.addEventListener('click', function() {
    searchInput.value = '';
    btnClearSearch.classList.add('hidden');
    resultsContainer.classList.add('hidden');
    noResults.classList.add('hidden');
    searchInput.focus();
});

async function fetchMangaLibrary(query) {
    try {
        const response = await fetch(`{{ route('manga.search.library') }}?q=${encodeURIComponent(query)}`);
        const items = await response.json();

        searchSpinner.classList.add('hidden');

        if (!Array.isArray(items) || items.length === 0) {
            resultsContainer.classList.add('hidden');
            noResults.classList.remove('hidden');
            return;
        }

        noResults.classList.add('hidden');
        resultsList.innerHTML = '';

        items.forEach(item => {
            const card = document.createElement('div');
            card.className = 'p-3 hover:bg-slate-50 transition cursor-pointer flex gap-3.5 items-start group';
            
            const coverSrc = item.cover || '';
            const authorText = item.author || 'Unknown Author';
            const chaptersText = item.chapters ? `${item.chapters} Ch` : 'Ongoing';
            const volumesText = item.volumes ? `${item.volumes} Vol` : '';
            const scoreText = item.score ? `${item.score}` : '';
            const yearText = item.year ? `${item.year}` : '';

            card.innerHTML = `
                <div class="w-12 h-16 sm:w-14 sm:h-20 bg-slate-100 rounded-lg overflow-hidden shrink-0 border border-slate-200 shadow-2xs">
                    ${coverSrc ? `<img src="${coverSrc}" class="w-full h-full object-cover group-hover:scale-105 transition" alt="${item.title}">` : '<div class="w-full h-full flex items-center justify-center text-slate-300 text-xs"><svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>'}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h4 class="font-bold text-slate-900 text-xs sm:text-sm leading-tight group-hover:text-[#2b4c7e] transition truncate" title="${item.title}">
                                ${item.title}
                            </h4>
                            ${item.alt_title ? `<p class="text-[10px] sm:text-[11px] text-slate-400 truncate">${item.alt_title}</p>` : ''}
                        </div>
                        <span class="text-[10px] sm:text-[11px] font-bold text-[#2b4c7e] bg-[#f0f4f8] px-2 py-0.5 rounded group-hover:bg-[#2b4c7e] group-hover:text-white transition shrink-0">
                            Pilih
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5 mt-1.5 flex-wrap text-[10px] sm:text-[11px]">
                        <span class="font-semibold text-slate-700 bg-slate-100 px-2 py-0.5 rounded flex items-center gap-1">
                            <svg class="w-3 h-3 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            ${authorText}
                        </span>
                        ${chaptersText ? `<span class="text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded font-medium">${chaptersText}</span>` : ''}
                        ${volumesText ? `<span class="text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded font-medium">${volumesText}</span>` : ''}
                        ${scoreText ? `<span class="text-amber-800 bg-amber-50 px-1.5 py-0.5 rounded font-bold flex items-center gap-0.5"><svg class="w-3 h-3 text-amber-500 fill-amber-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>${scoreText}</span>` : ''}
                        ${yearText ? `<span class="text-slate-400">${yearText}</span>` : ''}
                    </div>

                    ${item.description ? `<p class="text-[10px] sm:text-[11px] text-slate-400 mt-1 line-clamp-1">${item.description}</p>` : ''}
                </div>
            `;

            card.addEventListener('click', () => {
                selectMangaFromLibrary(item);
            });

            resultsList.appendChild(card);
        });

        resultsContainer.classList.remove('hidden');

    } catch (e) {
        searchSpinner.classList.add('hidden');
        console.error('Error fetching manga library:', e);
    }
}

// ==================== AUTO FILL SELECTION LOGIC ====================
function selectMangaFromLibrary(manga) {
    // 1. Set Title
    inputTitle.value = manga.title || manga.romaji_title;
    titleBadge.classList.remove('hidden');

    // 2. Set Author
    const rawAuthor = (manga.author && manga.author !== 'Unknown Author') ? manga.author.trim() : '';
    let foundOption = false;

    if (rawAuthor) {
        const lowerAuthor = rawAuthor.toLowerCase();
        for (let i = 0; i < selectAuthor.options.length; i++) {
            const opt = selectAuthor.options[i];
            const optName = opt.getAttribute('data-name');
            if (optName && (optName === lowerAuthor || lowerAuthor.includes(optName) || optName.includes(lowerAuthor))) {
                selectAuthor.selectedIndex = i;
                foundOption = true;
                break;
            }
        }

        if (!foundOption) {
            const newOpt = document.createElement('option');
            newOpt.value = `new:${rawAuthor}`;
            newOpt.textContent = rawAuthor;
            newOpt.setAttribute('data-name', lowerAuthor);
            newOpt.selected = true;
            selectAuthor.appendChild(newOpt);
        }

        authorBadge.classList.remove('hidden');
    }

    // 3. Set Target Chapter Goal & Volumes
    if (manga.chapters && manga.chapters > 0) {
        inputTargetChapter.value = manga.chapters;
        targetBadge.classList.remove('hidden');
    }
    if (manga.volumes && manga.volumes > 0) {
        inputVolumes.value = manga.volumes;
    }

    // 4. Update status secara otomatis
    autoUpdateStatus();

    // 5. Set Remote Cover Image
    if (manga.cover) {
        currentRemoteCover = manga.cover;
        remoteCoverUrlInput.value = manga.cover;
        libraryCoverImg.src = manga.cover;
        libraryCoverBox.classList.remove('hidden');

        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        cropWrapper.classList.add('hidden');
        resultWrapper.classList.add('hidden');
        croppedImageData.value = '';
    }

    // 6. Notifikasi Sukses
    selectedAlertTitle.innerText = manga.title;
    selectedAlertAuthor.innerText = rawAuthor || 'Unknown';
    selectedAlert.classList.remove('hidden');

    resultsContainer.classList.add('hidden');
    inputTitle.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

// Reset Selection
btnResetSelection.addEventListener('click', function() {
    selectedAlert.classList.add('hidden');
    titleBadge.classList.add('hidden');
    authorBadge.classList.add('hidden');
    targetBadge.classList.add('hidden');
    libraryCoverBox.classList.add('hidden');
    remoteCoverUrlInput.value = '';
});

// Remove remote cover
btnRemoveRemote.addEventListener('click', function() {
    libraryCoverBox.classList.add('hidden');
    remoteCoverUrlInput.value = '';
});

// Crop remote cover (Rasio Full Cover 3:4)
btnCropRemote.addEventListener('click', function() {
    if (!currentRemoteCover) return;
    const proxyUrl = `{{ route('manga.proxy.cover') }}?url=${encodeURIComponent(currentRemoteCover)}`;
    
    imageToCrop.src = proxyUrl;
    cropWrapper.classList.remove('hidden');
    cropWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });

    if (cropper) {
        cropper.destroy();
    }

    imageToCrop.onload = function() {
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 3 / 4,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            restore: false
        });
    };
});

// Manual File Upload & Cropper
imageInput.addEventListener('change', function(e) {
    const files = e.target.files;
    if (files && files.length > 0) {
        const file = files[0];
        const reader = new FileReader();
        
        reader.onload = function(event) {
            imageToCrop.src = event.target.result;
            cropWrapper.classList.remove('hidden');
            
            if (cropper) { cropper.destroy(); }
            
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 3 / 4, 
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                restore: false
            });
        };
        reader.readAsDataURL(file);
    }
});

btnCancelCrop.addEventListener('click', function() {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
    cropWrapper.classList.add('hidden');
});

btnCrop.addEventListener('click', function() {
    if (cropper) {
        const canvas = cropper.getCroppedCanvas({ width: 450, height: 600 });
        const base64Image = canvas.toDataURL('image/jpeg');
        croppedImageData.value = base64Image;
        croppedPreview.src = base64Image;
        resultWrapper.classList.remove('hidden');
        cropWrapper.classList.add('hidden');
        
        remoteCoverUrlInput.value = '';
        libraryCoverBox.classList.add('hidden');
    }
});
</script>
</body>
</html>