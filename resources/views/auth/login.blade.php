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
    </style>
</head>
<body class="bg-[#f8fafc] h-screen overflow-hidden">

    <div class="flex h-full w-full">
        <div class="hidden md:block w-1/2 h-full bg-slate-900 relative">
            <img src="{{ asset('img/manga-shelf-bg.jpg') }}" alt="Manga Shelf" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-black/10"></div>
        </div>

        <div class="w-full md:w-1/2 h-full bg-[#f8fafc] flex flex-col justify-center items-center px-8 sm:px-16 lg:px-24 relative">
            
            <div class="flex flex-col items-center mb-8">
                <img src="{{ asset('img/manga-noted-logo.png') }}" alt="Manga Noted Logo" class="w-50 h-50 object-contain mb-2">
                <h2 class="text-2xl font-serif tracking-wide text-slate-800 font-medium">Manga Noted</h2>
            </div>

            <div class="w-full max-w-md">
                <h1 class="text-3xl font-bold text-black mb-6">Login</h1>

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <input type="email" name="email" required
                               class="w-full px-4 py-3 bg-[#d9d9d9] border-none rounded-sm text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" 
                               placeholder="Email">
                    </div>

                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 bg-[#d9d9d9] border-none rounded-sm text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" 
                               placeholder="Password">
                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
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
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>