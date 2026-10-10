<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create An Account - Manga Noted</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        input::-ms-reveal,
        input::-ms-clear {
            display: none !important;
        }
        input::-webkit-credentials-reveal {
            display: none !important;
        }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen overflow-y-auto">

    <div class="flex min-h-screen w-full">
        <div class="hidden md:block w-1/2 min-h-screen bg-slate-900 relative">
            <img src="{{ asset('img/manga-shelf-bg.jpg') }}" alt="Manga Shelf" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-black/20"></div>
        </div>

        <div class="w-full md:w-1/2 min-h-screen bg-[#f8fafc] flex flex-col justify-center items-center px-6 sm:px-12 lg:px-20 py-10">
            
            <div class="w-full max-w-md">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-6">Create An Account</h1>

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm shadow-xs flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <span class="font-bold block mb-0.5">Registrasi Gagal</span>
                            <ul class="list-disc list-inside space-y-0.5 text-xs text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 bg-[#e2e8f0]/80 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#2b4c7e]/20 focus:border-[#2b4c7e] text-sm transition-all
                               {{ $errors->has('name') ? 'border-red-400 focus:ring-red-500' : '' }}" 
                               placeholder="Username">
                    </div>

                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 bg-[#e2e8f0]/80 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#2b4c7e]/20 focus:border-[#2b4c7e] text-sm transition-all
                               {{ $errors->has('email') ? 'border-red-400 focus:ring-red-500' : '' }}" 
                               placeholder="Email">
                    </div>

                    <div class="relative flex items-center">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 bg-[#e2e8f0]/80 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#2b4c7e]/20 focus:border-[#2b4c7e] text-sm transition-all pr-12
                               {{ $errors->has('password') ? 'border-red-400 focus:ring-red-500' : '' }}" 
                               placeholder="Password">
                        
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 cursor-pointer select-none z-10 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path class="eye-path" stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    <div class="relative flex items-center">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-4 py-3 bg-[#e2e8f0]/80 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-[#2b4c7e]/20 focus:border-[#2b4c7e] text-sm transition-all pr-12
                               {{ $errors->has('password_confirmation') ? 'border-red-400 focus:ring-red-500' : '' }}" 
                               placeholder="Confirm Password">
                        
                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 cursor-pointer select-none z-10 p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path class="eye-path" stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#2b4c7e] hover:bg-[#1f375b] text-white font-semibold text-sm rounded-xl transition shadow-xs hover:shadow mt-2 cursor-pointer">
                        Create Account
                    </button>
                </form>

                <div class="text-center mt-10">
                    <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-slate-800 transition inline-flex items-center gap-1.5 font-medium">
                        <span>Login</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
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
                svgPath.setAttribute('d', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z');
            } else {
                input.type = 'password';
                svgPath.setAttribute('d', 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18');
            }
        }
    </script>
</body>
</html>