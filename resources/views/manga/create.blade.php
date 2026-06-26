<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Manga - Manga Noted</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .image-container {
            width: 100%;
            min-height: 320px;
            max-height: 450px;
            background-color: #f1f5f9;
            border-radius: 12px;
            overflow: hidden;
        }
        img#image-to-crop {
            display: block;
            max-width: 100%;
        }
    </style>
</head>
<body class="bg-[#f8fafc]">

    <nav class="bg-[#1e293b] text-white px-8 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-2 font-semibold text-xl tracking-wide">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </span> 
            Manga Noted
        </div>
        <a href="{{ route('manga.index') }}" class="text-sm text-slate-300 hover:text-white transition flex items-center gap-1">
            ← Kembali ke Dashboard
        </a>
    </nav>

    <main class="max-w-2xl mx-auto px-6 py-12">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Tambah Manga Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Masukkan detail informasi data komik koleksi barumu.</p>
            </div>

            <form action="{{ route('manga.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Judul Manga</label>
                    <input type="text" name="title" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                           placeholder="Contoh: Chainsaw Man">
                </div>

                <div class="bg-slate-50/50 p-4 rounded-xl border border-slate-100 space-y-3">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Mangaka / Author</label>
                        <select name="author_id"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                            <option value="">-- Pilih Author yang Sudah Ada --</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-center text-[10px] font-bold tracking-wider text-slate-400 uppercase my-1">- ATAU TULIS BARU JIKA BELUM ADA -</div>

                    <div>
                        <input type="text" name="new_author"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                               placeholder="Ketik nama author baru...">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Volume Dimiliki</label>
                        <input type="number" name="volumes_owned" value="0" min="0" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Chapter Terakhir</label>
                        <input type="number" name="last_read_chapter" value="0" min="0" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5 text-blue-600 font-bold">Target Chapter Goal</label>
                        <input type="number" name="target_chapter" value="0" min="0" required
                               class="w-full px-4 py-2.5 rounded-xl border border-blue-200 bg-blue-50/20 text-slate-800 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                               placeholder="Misal: 150">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Status Tracking</label>
                    <select name="status" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-800 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        <option value="Backlog">Backlog (Belum Dibaca)</option>
                        <option value="Reading">Reading (Sedang Dibaca)</option>
                        <option value="Completed">Completed (Tamat)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-1.5">Upload Cover Gambar</label>
                    <input type="file" id="image-input" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100 transition border border-slate-200 p-2 rounded-xl mb-4">
                    
                    <input type="hidden" name="cropped_image" id="cropped-image-data">

                    <div id="crop-wrapper" class="hidden border border-slate-200 p-4 rounded-xl bg-slate-50 mb-4">
                        <div class="text-xs text-slate-500 mb-2 font-medium">Sesuaikan potongan cover manga kamu (Rasio Horizontal):</div>
                        <div class="image-container flex justify-center items-center shadow-xs">
                            <img id="image-to-crop" src="">
                        </div>
                        <div class="mt-3 text-right">
                            <button type="button" id="btn-crop" class="bg-green-600 hover:bg-green-700 text-white rounded-lg px-4 py-1.5 text-xs font-medium shadow-xs transition cursor-pointer">
                                Kunci Potongan
                            </button>
                        </div>
                    </div>

                    <div id="result-wrapper" class="hidden text-center bg-slate-50/70 p-4 border border-slate-100 rounded-xl">
                        <div class="text-xs text-slate-500 mb-2 font-medium">Hasil Potongan Akhir (Horizontal Banner):</div>
                        <div class="w-full max-w-md mx-auto p-1 bg-white border border-slate-200 rounded-xl shadow-xs overflow-hidden">
                            <img id="cropped-preview" class="w-full h-28 object-cover rounded-lg">
                        </div>
                    </div>
                </div>
                
                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="{{ route('manga.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-medium transition">
                        Kembali
                    </a>
                    <button type="submit" class="bg-[#4475b5] hover:bg-[#366199] text-white rounded-xl px-6 py-2.5 text-sm font-medium shadow-sm transition cursor-pointer">
                        Simpan Manga
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
const croppedImageData = document.getElementById('cropped-image-data');
const resultWrapper = document.getElementById('result-wrapper');
const croppedPreview = document.getElementById('cropped-preview');

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
                aspectRatio: 16 / 9, 
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                restore: false
            });
        };
        reader.readAsDataURL(file);
    }
});

btnCrop.addEventListener('click', function() {
    if (cropper) {
        const canvas = cropper.getCroppedCanvas({ width: 600, height: 338 });
        const base64Image = canvas.toDataURL('image/jpeg');
        croppedImageData.value = base64Image;
        croppedPreview.src = base64Image;
        resultWrapper.classList.remove('hidden');
        alert('Gambar horizontal berhasil dipotong dan dikunci!');
    }
});
</script>
</body>
</html>