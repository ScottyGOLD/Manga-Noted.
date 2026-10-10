<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manga Noted</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }
        
        .swiper-button-next, .swiper-button-prev {
            color: #1e293b;
            background: rgba(255, 255, 255, 0.95);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.2s ease;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: #ffffff;
            scale: 1.05;
        }
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 13px;
            font-weight: bold;
        }
        @media (max-width: 640px) {
            .swiper-button-next, .swiper-button-prev {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen">

    <!-- Top Navigation Bar -->
    <nav class="bg-[#1e293b] text-white px-4 sm:px-8 py-3.5 sm:py-4 flex justify-between items-center shadow-md relative" x-data="{ open: false }">
        <div class="flex items-center gap-2 font-semibold text-lg sm:text-xl tracking-wide">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span>Manga Noted</span>
        </div>

        <div class="relative">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none cursor-pointer group hover:bg-slate-800/60 p-1 rounded-xl transition">
                <div class="w-9 h-9 rounded-full border border-slate-300 bg-white flex items-center justify-center overflow-hidden transition group-hover:border-white select-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 transition group-hover:text-white" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-3 w-64 bg-white rounded-xl shadow-xl py-3 px-3 z-50 border border-slate-100 text-slate-800"
                 style="display: none;"> 
                
                <div class="px-2 mb-2">
                    <h4 class="font-bold text-sm text-slate-900 truncate">{{ Auth::user()->name ?? 'Username' }}</h4>
                    <p class="text-xs text-slate-500 break-all truncate">{{ Auth::user()->email ?? 'example@gmail.com' }}</p>
                </div>
                
                <hr class="border-slate-100 my-2">

                <div class="space-y-1 mb-2">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-2 mb-1">Daftar Bacaan</p>
                    
                    <a href="#wishlist" @click="open = false" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-xs sm:text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span> Wishlist
                        </span>
                        <span class="bg-amber-50 text-amber-700 text-xs px-2 py-0.5 rounded-md font-bold">{{ $wishlist->count() }}</span>
                    </a>

                    <a href="#backlog" @click="open = false" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-xs sm:text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span> Backlog
                        </span>
                        <span class="bg-slate-100 text-slate-700 text-xs px-2 py-0.5 rounded-md font-bold">{{ $backlog->count() }}</span>
                    </a>

                    <a href="#reading" @click="open = false" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-xs sm:text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#2b4c7e]"></span> Reading
                        </span>
                        <span class="bg-[#f0f4f8] text-[#2b4c7e] text-xs px-2 py-0.5 rounded-md font-bold">{{ $reading->count() }}</span>
                    </a>

                    <a href="#completed" @click="open = false" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-xs sm:text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span> Completed
                        </span>
                        <span class="bg-emerald-50 text-emerald-700 text-xs px-2 py-0.5 rounded-md font-bold">{{ $completed->count() }}</span>
                    </a>
                </div>

                <hr class="border-slate-100 my-2">

                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-[#851010] hover:bg-[#660c0c] text-white text-center py-2 rounded-lg text-xs font-semibold transition cursor-pointer shadow-xs flex items-center justify-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 md:px-12 py-6 sm:py-8">
        
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Koleksi manga kamu — <span class="font-semibold text-slate-700">{{ $mangas->count() }} judul total</span></p>
            </div>
            
            <a href="{{ route('manga.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#2b4c7e] hover:bg-[#1f375b] text-white font-semibold px-4 py-2.5 rounded-xl text-xs sm:text-sm shadow-xs hover:shadow transition whitespace-nowrap cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Manga</span>
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mb-8 w-full max-w-md">
            <form action="{{ route('manga.index') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full pl-9 sm:pl-10 pr-4 py-2 sm:py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 shadow-2xs focus:outline-none focus:border-[#2b4c7e] focus:ring-1 focus:ring-[#2b4c7e]/20 text-xs sm:text-sm transition" 
                           placeholder="Cari judul manga atau nama author...">
                </div>
                
                <button type="submit" class="bg-[#2b4c7e] hover:bg-[#1f375b] text-white rounded-xl px-4 sm:px-5 py-2 text-xs sm:text-sm font-semibold shadow-xs transition cursor-pointer shrink-0">
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('manga.index') }}" class="border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 rounded-xl px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium shadow-xs flex items-center transition shrink-0">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Dynamic Categories Loop (Wishlist, Backlog, Reading, Completed) -->
        @php
            $categories = [
                ['slug' => 'wishlist', 'label' => 'Wishlist', 'badgeBg' => 'bg-amber-100 text-amber-800'],
                ['slug' => 'backlog', 'label' => 'Backlog', 'badgeBg' => 'bg-slate-200 text-slate-700'],
                ['slug' => 'reading', 'label' => 'Reading', 'badgeBg' => 'bg-[#edf2f7] text-[#2b4c7e]'],
                ['slug' => 'completed', 'label' => 'Completed', 'badgeBg' => 'bg-emerald-100 text-emerald-800']
            ];
        @endphp

        @foreach($categories as $cat)
            @php
                $filteredManga = $mangas->where('status', ucfirst($cat['slug']));
            @endphp

            <div class="mb-10 scroll-mt-12" id="{{ $cat['slug'] }}">
                
                <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">{{ $cat['label'] }}</h2>
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full {{ $cat['badgeBg'] }}">
                        {{ $filteredManga->count() }}
                    </span>
                </div>

                @if($filteredManga->count() > 4)
                    <div class="swiper mySwiper-{{ $cat['slug'] }} relative px-0.5">
                        <div class="swiper-wrapper py-2">
                            @foreach($filteredManga as $manga)
                                <div class="swiper-slide h-auto">
                                    @include('manga.card', ['manga' => $manga, 'theme' => $cat['slug']])
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                @elseif($filteredManga->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3.5 sm:gap-6">
                        @foreach($filteredManga as $manga)
                            @include('manga.card', ['manga' => $manga, 'theme' => $cat['slug']])
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-xs text-slate-400 font-medium flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Belum ada komik di daftar {{ $cat['label'] }}.</span>
                    </div>
                @endif
            </div>
        @endforeach

    </main>

    <!-- ==================== MODAL KONFIRMASI HAPUS MANGA ==================== -->
    <div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs hidden transition-all duration-200">
        <div id="delete-modal-content" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200/90 transform transition-all duration-200 scale-95 opacity-0">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-bold text-slate-900">Hapus Manga dari Koleksi?</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Apakah kamu yakin ingin menghapus <strong class="text-slate-800 break-words" id="delete-modal-title"></strong>? Data tracking dan cover komik ini akan dihapus permanen.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-xs transition cursor-pointer">
                    Batal
                </button>
                <form id="delete-form-action" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#851010] hover:bg-[#660c0c] text-white font-semibold text-xs shadow-xs hover:shadow transition cursor-pointer flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Ya, Hapus Manga</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sliderOptions = {
                slidesPerView: 2,
                spaceBetween: 14,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 3, spaceBetween: 18 },
                    1024: { slidesPerView: 4, spaceBetween: 20 },
                    1280: { slidesPerView: 5, spaceBetween: 24 }
                }
            };

            ['wishlist', 'backlog', 'reading', 'completed'].forEach(slug => {
                const el = document.querySelector('.mySwiper-' + slug);
                if (el) {
                    new Swiper(el, sliderOptions);
                }
            });
        });

        // ==================== DELETE MODAL HANDLER ====================
        const deleteModal = document.getElementById('delete-modal');
        const deleteModalContent = document.getElementById('delete-modal-content');
        const deleteModalTitle = document.getElementById('delete-modal-title');
        const deleteFormAction = document.getElementById('delete-form-action');

        function openDeleteModal(actionUrl, mangaTitle) {
            deleteFormAction.action = actionUrl;
            deleteModalTitle.textContent = mangaTitle;
            deleteModal.classList.remove('hidden');

            setTimeout(() => {
                deleteModalContent.classList.remove('scale-95', 'opacity-0');
                deleteModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            deleteModalContent.classList.remove('scale-100', 'opacity-100');
            deleteModalContent.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                deleteModal.classList.add('hidden');
            }, 150);
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        });

        // Close modal when clicking on backdrop
        deleteModal.addEventListener('click', function (e) {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>