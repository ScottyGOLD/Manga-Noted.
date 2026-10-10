@php
    // Menentukan warna dinamis matte berdasarkan tema/status manga
    $bgHeader = 'bg-[#334155]'; // Backlog (Matte Slate tua)
    $badgeText = 'Backlog';
    $badgeBg = 'bg-slate-800/80 text-slate-200 border-slate-600/30';
    $progressBarColor = 'bg-slate-500';

    if($theme == 'reading' || (isset($manga) && $manga->status == 'Reading')) {
        $bgHeader = 'bg-[#2b4c7e]'; // Reading (Matte Blue)
        $badgeText = 'Reading';
        $badgeBg = 'bg-[#2b4c7e]/90 text-slate-100 border-[#476a9f]/40';
        $progressBarColor = 'bg-[#335384]';
    } elseif($theme == 'completed' || (isset($manga) && $manga->status == 'Completed')) {
        $bgHeader = str_contains(strtolower($manga->title), 'titan') ? 'bg-[#7c2d12]' : 'bg-[#1b4d3e]'; // Matte Forest
        $badgeText = 'Done';
        $badgeBg = 'bg-[#1b4d3e]/90 text-emerald-100 border-emerald-500/30';
        $progressBarColor = 'bg-[#236350]';
    } elseif($theme == 'wishlist' || (isset($manga) && $manga->status == 'Wishlist')) {
        $bgHeader = 'bg-[#b45309]'; // Wishlist (Matte Amber/Warm Brown)
        $badgeText = 'Wishlist';
        $badgeBg = 'bg-[#b45309]/90 text-amber-100 border-amber-500/30';
        $progressBarColor = 'bg-[#b45309]';
    }

    // Hitung persentase dinamis berdasarkan target_chapter
    $progressPercent = 0;
    if (isset($manga->target_chapter) && $manga->target_chapter > 0) {
        $progressPercent = min(($manga->last_read_chapter / $manga->target_chapter) * 100, 100);
    } elseif (isset($manga) && $manga->status == 'Completed') {
        $progressPercent = 100;
    }
@endphp

<div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden flex flex-col group transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
    
    <!-- FULL COVER MANGA (Rasio Buku Vertikal 3:4) -->
    <div class="relative aspect-[3/4] w-full {{ $bgHeader }} flex flex-col items-center justify-center text-white overflow-hidden">
        @if($manga->cover_image)
            <img src="{{ asset('storage/' . $manga->cover_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" alt="{{ $manga->title }}">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/20"></div>
        @else
            <div class="flex flex-col items-center justify-center p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-slate-400/60 mb-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="text-xs font-semibold tracking-wide opacity-90 line-clamp-2 px-2 text-slate-200">{{ $manga->title }}</span>
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
        @endif

        <!-- Badge Status Floating di Pojok Kanan Atas -->
        <span class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 backdrop-blur-md text-[10px] font-bold uppercase tracking-wider px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-full border shadow-xs z-10 {{ $badgeBg }}">
            {{ $badgeText }}
        </span>

        <!-- Info Volume Overlay di Pojok Kiri Bawah Cover -->
        <div class="absolute bottom-2.5 left-2.5 sm:bottom-3 sm:left-3 z-10 flex items-center">
            <span class="bg-black/65 backdrop-blur-md text-slate-100 text-[10px] sm:text-[11px] font-semibold px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-lg border border-white/15 shadow-xs flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>{{ $manga->volumes_owned ?? 0 }} Vol</span>
            </span>
        </div>
    </div>

    <!-- Informasi Manga & Tracking -->
    <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between bg-white">
        <div>
            <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug mb-0.5 truncate group-hover:text-[#2b4c7e] transition" title="{{ $manga->title }}">
                {{ $manga->title }}
            </h3>
            <p class="text-[11px] sm:text-xs text-slate-500 font-medium mb-2.5 truncate flex items-center gap-1">
                <span class="text-slate-400">By:</span> {{ $manga->author->name ?? 'Unknown Author' }}
            </p>
            
            <hr class="border-slate-100 my-2">

            <!-- Progress Tracker -->
            <div class="text-[11px] sm:text-xs text-slate-500 font-medium flex items-center justify-between mb-1">
                <div class="flex items-center gap-1 truncate">
                    <span>Ch. <strong class="text-slate-800 font-bold">{{ $manga->last_read_chapter ?? 0 }}</strong> / {{ ($manga->target_chapter ?? 0) > 0 ? $manga->target_chapter : '∞' }}</span>
                </div>
                <span class="text-slate-600 font-bold text-[10px] sm:text-[11px] shrink-0">{{ round($progressPercent) }}%</span>
            </div>

            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mb-3">
                <div class="{{ $progressBarColor }} h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center gap-1.5 sm:gap-2 pt-1.5 border-t border-slate-100">
            @if($theme == 'reading' || (isset($manga) && $manga->status == 'Reading'))
                <form action="{{ route('manga.increment', $manga->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" {{ $manga->status == 'Completed' ? 'disabled' : '' }} class="w-full bg-[#f0f4f8] hover:bg-[#2b4c7e] hover:text-white border border-[#cbd5e1] hover:border-[#2b4c7e] text-[#2b4c7e] font-bold py-1.5 px-2 rounded-xl text-[11px] sm:text-xs flex items-center justify-center gap-1 transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed shadow-2xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>1 Ch</span>
                    </button>
                </form>
            @endif

            <a href="{{ route('manga.edit', $manga->id) }}" class="p-1.5 sm:p-2 bg-slate-50 hover:bg-slate-100 hover:text-slate-800 border border-slate-200 text-slate-600 rounded-xl transition flex items-center justify-center {{ ($theme != 'reading' && $manga->status != 'Reading') ? 'flex-1 text-center text-xs font-semibold py-1.5 sm:py-2' : '' }}" title="Edit Manga">
                @if($theme == 'reading' || (isset($manga) && $manga->status == 'Reading'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                @else
                    Edit
                @endif
            </a>

            <!-- Tombol Hapus dengan Trigger Modal Konfirmasi -->
            <button type="button" onclick="openDeleteModal('{{ route('manga.destroy', $manga->id) }}', '{{ addslashes($manga->title) }}')" class="p-1.5 sm:p-2 bg-slate-50 hover:bg-red-50 hover:text-red-600 hover:border-red-200 border border-slate-200 text-slate-500 rounded-xl transition flex items-center justify-center text-xs font-semibold {{ ($theme != 'reading' && $manga->status != 'Reading') ? 'flex-1 py-1.5 sm:py-2' : '' }} cursor-pointer" title="Hapus Manga">
                @if($theme == 'reading' || (isset($manga) && $manga->status == 'Reading'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                @else
                    Hapus
                @endif
            </button>
        </div>
    </div>

</div>