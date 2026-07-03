<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manga Noted</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Menyembunyikan ikon mata bawaan browser (Edge, Chrome, Safari) agar tidak double */
        input::-ms-reveal,
        input::-ms-clear {
            display: none !important;
        }
        input::-webkit-credentials-reveal {
            display: none !important;
        }
    </style>
</head>
<body class="bg-[#f8fafc] h-screen overflow-hidden">

    <div class="flex h-full w-full">
        <div class="hidden md:block w-1/2 h-full bg-slate-900 relative">
            <img src="{{ asset('img/manga-shelf-bg.jpg') }}" alt="Manga Shelf" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-black/10"></div>
        </div>

        <div class="w-full md:w-1/2 h-full bg-[#f8fafc] flex flex-col justify-center items-center px-8 sm:px-16 lg:px-24 relative">
            
 
            <div class="w-full max-w-md">

            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('img/manga-noted-logo.png') }}" alt="Manga Noted Logo" class="w-50 h-50 object-contain mb-2">
                <h2 class="text-2xl font-serif tracking-wide text-slate-800 font-medium">Manga Noted</h2>
            </div>
            
                <h1 class="text-3xl font-bold text-black mb-6">Login</h1>

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm shadow-xs flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <span class="font-bold block mb-0.5">Login Gagal</span>
                            <ul class="list-disc list-inside space-y-0.5 text-xs text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 bg-[#d9d9d9] border-2 rounded-sm text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm transition-all
                               {{ $errors->has('email') ? 'border-red-400 focus:ring-red-500' : 'border-transparent' }}" 
                               placeholder="Email">
                    </div>

                    <div class="relative flex items-center">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 bg-[#d9d9d9] border-2 rounded-sm text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm transition-all pr-12
                               {{ $errors->has('email') || $errors->has('password') ? 'border-red-400 focus:ring-red-500' : 'border-transparent' }}" 
                               placeholder="Password">
                        
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 cursor-pointer select-none z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path class="eye-path" stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#4475b5] hover:bg-[#366199] text-white font-medium text-sm rounded-sm transition shadow-sm mt-2 cursor-pointer">
                        Login
                    </button>
                </form>

                <div class="text-center mt-12">
                    <a href="{{ route('register') }}" class="text-sm text-slate-500 hover:text-slate-800 transition inline-flex items-center gap-1">
                        Create Account <span class="text-base">→</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const svgPath = button.querySelector('.eye-path');
            
            if (input.type === 'password') {
                input.type = 'text';
                // Mengubah ke ikon mata terbuka
                svgPath.setAttribute('d', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z');
            } else {
                input.type = 'password';
                // Mengembalikan ke ikon mata dicoret
                svgPath.setAttribute('d', 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18');
            }
        }
    </script>
</body>
</html>