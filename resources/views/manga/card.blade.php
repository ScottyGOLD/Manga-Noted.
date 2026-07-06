@php
    // Menentukan warna dinamis berdasarkan tema/status manga
    $bgHeader = 'bg-[#334155]'; // Backlog (Slate tua)
    $badgeText = 'Backlog';
    $progressBarColor = 'bg-slate-400';

    if($theme == 'reading' || (isset($manga) && $manga->status == 'Reading')) {
        $bgHeader = 'bg-[#1d4ed8]'; // Reading (Blue)
        $badgeText = 'Reading';
        $progressBarColor = 'bg-blue-500';
    } elseif($theme == 'completed' || (isset($manga) && $manga->status == 'Completed')) {
        $bgHeader = str_contains(strtolower($manga->title), 'titan') ? 'bg-[#7c2d12]' : 'bg-[#065f46]'; 
        $badgeText = 'Done';
        $progressBarColor = 'bg-green-500';
    } elseif($theme == 'wishlist' || (isset($manga) && $manga->status == 'Wishlist')) {
        $bgHeader = 'bg-[#d97706]'; // Wishlist (Amber/Orange)
        $badgeText = 'Wishlist';
        $progressBarColor = 'bg-amber-500';
    }

    // Hitung persentase dinamis berdasarkan target_chapter
    $progressPercent = 0;
    if (isset($manga->target_chapter) && $manga->target_chapter > 0) {
        $progressPercent = min(($manga->last_read_chapter / $manga->target_chapter) * 100, 100);
    } elseif (isset($manga) && $manga->status == 'Completed') {
        $progressPercent = 100;
    }
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col group transition hover:shadow-md">
    
    <div class="relative h-44 {{ $bgHeader }} flex flex-col items-center justify-center text-white px-4 text-center overflow-hidden">
        @if($manga->cover_image)
            <img src="{{ asset('storage/' . $manga->cover_image) }}" class="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:scale-105 transition duration-300" alt="Cover">
            <div class="absolute inset-0 bg-black/15"></div>
        @else
            <span class="text-3xl opacity-40 mb-2">📖</span>
            <span class="text-sm font-medium tracking-wide opacity-80 truncate max-w-full">{{ $manga->title }}</span>
        @endif

        <span class="absolute top-3 right-3 bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full border border-white/10 z-10">
            {{ $badgeText }}
        </span>
    </div>

    <div class="p-4 flex-1 flex flex-col justify-between">
        <div>
            <h3 class="font-bold text-slate-800 text-base leading-tight mb-0.5 truncate" title="{{ $manga->title }}">{{ $manga->title }}</h3>
            <p class="text-xs text-slate-400 font-semibold mb-3">
                By: {{ $manga->author->name ?? 'Unknown Author' }}
            </p>
            
            <hr class="border-slate-100 my-2">

            <div class="text-xs text-slate-500 font-medium flex items-center justify-between mb-2">
                <div class="flex items-center gap-1.5">
                    <span>Ch. <strong class="text-slate-800">{{ $manga->last_read_chapter ?? 0 }}</strong> / {{ ($manga->target_chapter ?? 0) > 0 ? $manga->target_chapter : '∞' }}</span>
                    <span class="text-slate-300">•</span>
                    <span>{{ $manga->volumes_owned ?? 0 }} vol</span>
                </div>
                <span class="text-slate-400 text-[10px]">{{ round($progressPercent) }}%</span>
            </div>

            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mb-4">
                <div class="{{ $progressBarColor }} h-full rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
            </div>
        </div>

        <div class="flex items-center gap-2 mt-2">
            
            @if($theme == 'reading' || (isset($manga) && $manga->status == 'Reading'))
                <form action="{{ route('manga.increment', $manga->id) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" {{ $manga->status == 'Completed' ? 'disabled' : '' }} class="w-full bg-slate-50 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 border border-slate-200 text-slate-600 font-semibold py-2 px-3 rounded-xl text-xs flex items-center justify-center gap-1 transition cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed">
                        <span class="text-sm font-bold">+</span> 1 Chapter
                    </button>
                </form>
            @endif

            <a href="{{ route('manga.edit', $manga->id) }}" class="p-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-500 rounded-xl transition flex items-center justify-center {{ ($theme != 'reading' && $manga->status != 'Reading') ? 'flex-1 text-center text-xs font-semibold py-2' : '' }}">
                @if($theme == 'reading' || (isset($manga) && $manga->status == 'Reading'))
                    <img src="{{ asset('img/icons/edit-pencil.png') }}" alt="Edit" class="w-4 h-4 object-contain">
                @else
                    Edit
                @endif
            </a>

            <form action="{{ route('manga.destroy', $manga->id) }}" method="POST" onsubmit="return confirm('Hapus manga ini?')" class="{{ ($theme != 'reading' && $manga->status != 'Reading') ? 'flex-1' : '' }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full p-2 bg-slate-50 hover:bg-red-50 hover:text-red-500 border border-slate-200 text-slate-400 rounded-xl transition flex items-center justify-center text-xs font-semibold {{ ($theme != 'reading' && $manga->status != 'Reading') ? 'py-2' : '' }} cursor-pointer">
                    @if($theme == 'reading' || (isset($manga) && $manga->status == 'Reading'))
                        <img src="{{ asset('img/icons/delete-trash.png') }}" alt="Hapus" class="w-4 h-4 object-contain">
                    @else
                        Hapus
                    @endif
                </button>
            </form>

        </div>
    </div>

</div>