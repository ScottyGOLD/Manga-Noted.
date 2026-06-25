<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manga Noted</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc]">

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
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 focus:outline-none cursor-pointer group">
                <div class="w-10 h-10 rounded-full border-2 border-slate-300 bg-white flex items-center justify-center overflow-hidden transition group-hover:border-white">
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
                 class="absolute right-0 mt-3 w-64 bg-white rounded-lg shadow-xl py-4 px-4 z-50 border border-slate-100 text-slate-800"
                 style="display: none;">
                
                <div class="mb-3">
                    <h4 class="font-bold text-base text-[#1e3a8a]">{{ Auth::user()->name ?? 'Username' }}</h4>
                    <p class="text-xs text-slate-500 break-all">{{ Auth::user()->email ?? 'example@gmail.com' }}</p>
                </div>
                
                <hr class="border-slate-100 my-2">

                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-[#851010] hover:bg-[#660c0c] text-white text-center py-2 rounded-md text-sm font-semibold transition cursor-pointer shadow-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-8">
        
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Dashboard</h1>
                <p class="text-slate-500 mt-1">Koleksi manga kamu — <span class="font-medium text-slate-700">{{ $mangas->count() }} judul total</span></p>
            </div>
            
            <a href="{{ route('manga.create') }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-medium px-4 py-2 rounded-lg text-sm shadow-sm transition whitespace-nowrap">
                <span class="text-base font-bold">+</span> Tambah Manga
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
                           class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-white text-slate-800 placeholder-slate-400 shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm transition" 
                           placeholder="Cari judul manga atau nama author...">
                </div>
                
                <button type="submit" class="bg-[#4475b5] hover:bg-[#366199] text-white rounded-lg px-5 py-2 text-sm font-medium shadow-sm transition cursor-pointer">
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('manga.index') }}" class="border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 rounded-lg px-4 py-2 text-sm font-medium shadow-sm flex items-center transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            
            <div>
                <div class="flex items-center gap-2 mb-4 font-semibold text-slate-700">
                    Backlog 
                    <span class="bg-slate-200 text-slate-700 text-xs px-2.5 py-0.5 rounded-full">{{ $mangas->where('status', 'Backlog')->count() }}</span>
                </div>
                <div class="space-y-4">
                    @foreach($mangas->where('status', 'Backlog') as $manga)
                        @include('manga.card', ['manga' => $manga, 'theme' => 'backlog'])
                    @endforeach
                </div>
            </div>

            <div>
                <div class="flex items-center gap-2 mb-4 font-semibold text-slate-700">
                    Reading 
                    <span class="bg-blue-100 text-blue-600 text-xs px-2.5 py-0.5 rounded-full">{{ $mangas->where('status', 'Reading')->count() }}</span>
                </div>
                <div class="space-y-4">
                    @foreach($mangas->where('status', 'Reading') as $manga)
                        @include('manga.card', ['manga' => $manga, 'theme' => 'reading'])
                     @endforeach
                </div>
            </div>

            <div>
                <div class="flex items-center gap-2 mb-4 font-semibold text-slate-700">
                    Completed 
                    <span class="bg-green-100 text-green-600 text-xs px-2.5 py-0.5 rounded-full">{{ $mangas->where('status', 'Completed')->count() }}</span>
                </div>
                <div class="space-y-4">
                    @foreach($mangas->where('status', 'Completed') as $manga)
                        @include('manga.card', ['manga' => $manga, 'theme' => 'completed'])
                    @endforeach
                </div>
            </div>

        </div>
    </main>

</body>
</html>