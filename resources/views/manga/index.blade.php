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
        /* Menambahkan efek scroll halus saat link kategori diklik */
        html {
            scroll-behavior: smooth;
        }

        body { font-family: 'Inter', sans-serif; }
        
        /* Kustomisasi Navigasi Panah Swiper agar Presisi & Elegan */
        .swiper-button-next, .swiper-button-prev {
            color: #1e293b;
            background: rgba(255, 255, 255, 0.95);
            width: 38px;
            height: 38px;
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
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800">

    <nav class="bg-[#1e293b] text-white px-8 py-4 flex justify-between items-center shadow-md relative" x-data="{ open: false }">
        <div class="flex items-center gap-2 font-semibold text-xl tracking-wide">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </span> 
            Manga Noted
        </div>

        <div class="relative">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2.5 focus:outline-none cursor-pointer group hover:bg-slate-800/60 p-1.5 rounded-xl transition">
                <div class="w-10 h-10 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center overflow-hidden transition group-hover:border-white select-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-300 transition group-hover:text-white" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                    <h4 class="font-bold text-base text-slate-900 truncate">{{ Auth::user()->name ?? 'Username' }}</h4>
                    <p class="text-xs text-slate-500 break-all truncate">{{ Auth::user()->email ?? 'example@gmail.com' }}</p>
                </div>
                
                <hr class="border-slate-100 my-2">

                <div class="space-y-1 mb-2">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-2 mb-1">Daftar Bacaan</p>
                    
                    <a href="#wishlist" @click="open = false" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span> Wishlist
                        </span>
                        <span class="bg-amber-50 text-amber-600 text-xs px-2 py-0.5 rounded-md font-bold">{{ $wishlist->count() }}</span>
                    </a>

                    <a href="#backlog" @click="open = false" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span> Backlog
                        </span>
                        <span class="bg-slate-100 text-slate-700 text-xs px-2 py-0.5 rounded-md font-bold">{{ $backlog->count() }}</span>
                    </a>

                    <a href="#reading" @click="open = false" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span> Reading
                        </span>
                        <span class="bg-blue-50 text-blue-600 text-xs px-2 py-0.5 rounded-md font-bold">{{ $reading->count() }}</span>
                    </a>

                    <a href="#completed" @click="open = false" class="flex items-center justify-between px-2 py-1.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Completed
                        </span>
                        <span class="bg-green-50 text-green-600 text-xs px-2 py-0.5 rounded-md font-bold">{{ $completed->count() }}</span>
                    </a>
                </div>

                <hr class="border-slate-100 my-2">

                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-[#851010] hover:bg-[#660c0c] text-white text-center py-2 rounded-lg text-sm font-semibold transition cursor-pointer shadow-sm flex items-center justify-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 md:px-12 py-8">
        
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard</h1>
                <p class="text-sm text-slate-500 mt-0.5">Koleksi manga kamu — <span class="font-semibold text-slate-700">{{ $mangas->count() }} judul total</span></p>
            </div>
            
            <a href="{{ route('manga.create') }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold px-4 py-2.5 rounded-xl text-sm shadow-xs transition whitespace-nowrap cursor-pointer">
                <span class="text-base font-bold text-slate-500">+</span> Tambah Manga
            </a>
        </div>

        <div class="mb-8 max-w-md">
            <form action="{{ route('manga.index') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 shadow-2xs focus:outline-none focus:border-blue-500 text-sm transition" 
                           placeholder="Cari judul manga atau nama author...">
                </div>
                
                <button type="submit" class="bg-[#4475b5] hover:bg-[#366199] text-white rounded-xl px-5 py-2 text-sm font-medium shadow-xs transition cursor-pointer">
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('manga.index') }}" class="border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 rounded-xl px-4 py-2 text-sm font-medium shadow-xs flex items-center transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- ==================== DYNAMIC CATEGORIES LOOP (Wishlist, Backlog, Reading, Completed) ==================== --}}
        @php
            $categories = [
                ['slug' => 'wishlist', 'label' => 'Wishlist', 'badgeBg' => 'bg-amber-100 text-amber-700'],
                ['slug' => 'backlog', 'label' => 'Backlog', 'badgeBg' => 'bg-slate-200 text-slate-700'],
                ['slug' => 'reading', 'label' => 'Reading', 'badgeBg' => 'bg-blue-100 text-blue-700'],
                ['slug' => 'completed', 'label' => 'Completed', 'badgeBg' => 'bg-green-100 text-green-700']
            ];
        @endphp

        @foreach($categories as $cat)
            @php
                $filteredManga = $mangas->where('status', ucfirst($cat['slug']));
            @endphp

            <div class="mb-10 scroll-mt-12" id="{{ $cat['slug'] }}">
                
                <div class="flex items-center gap-2 mb-4 border-b border-slate-100 pb-1.5">
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">{{ $cat['label'] }}</h2>
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full {{ $cat['badgeBg'] }}">
                        {{ $filteredManga->count() }}
                    </span>
                </div>

                @if($filteredManga->count() > 3)
                    <div class="swiper mySwiper-{{ $cat['slug'] }} relative px-1">
                        <div class="swiper-wrapper py-1.5">
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($filteredManga as $manga)
                            @include('manga.card', ['manga' => $manga, 'theme' => $cat['slug']])
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-xs text-slate-400 font-medium">
                        Belum ada komik di daftar {{ $cat['label'] }}.
                    </div>
                @endif
            </div>
        @endforeach

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sliderOptions = {
                slidesPerView: 1,
                spaceBetween: 24,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            };

            if(document.querySelector('.mySwiper-backlog')) {
                new Swiper('.mySwiper-backlog', sliderOptions);
            }
            if(document.querySelector('.mySwiper-reading')) {
                new Swiper('.mySwiper-reading', sliderOptions);
            }
            if(document.querySelector('.mySwiper-completed')) {
                new Swiper('.mySwiper-completed', sliderOptions);
            }
        });
    </script>
</body>
</html>