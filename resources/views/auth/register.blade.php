<!DOCTYPE html>
<html lang="en">
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
    </style>
</head>
<body class="bg-[#f8fafc] h-screen overflow-hidden">

    <div class="flex h-full w-full">
        <div class="hidden md:block w-1/2 h-full bg-slate-900 relative">
            <img src="{{ asset('img/manga-shelf-bg.jpg') }}" alt="Manga Shelf" class="w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-black/10"></div>
        </div>

        <div class="w-full md:w-1/2 h-full bg-[#f8fafc] flex flex-col justify-center items-center px-8 sm:px-16 lg:px-24">
            
            <div class="w-full max-w-md">
                <h1 class="text-3xl font-bold text-black mb-6">Create An Account</h1>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 bg-[#d9d9d9] border-none rounded-sm text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" 
                               placeholder="Username">
                    </div>

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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-4 py-3 bg-[#d9d9d9] border-none rounded-sm text-slate-800 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" 
                               placeholder="Confirm Password">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#4475b5] hover:bg-[#366199] text-white font-medium text-sm rounded-sm transition shadow-sm mt-2 cursor-pointer">
                        Create Account
                    </button>
                </form>

                <div class="text-center mt-12">
                    <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-slate-800 transition inline-flex items-center gap-1">
                        Login <span class="text-base">→</span>
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