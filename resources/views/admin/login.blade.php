<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Login Administrator - SABI</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-full bg-[#F8FAFC] flex items-center justify-center p-4 font-['Jua'] text-slate-800 antialiased selection:bg-[#0077B6] selection:text-white">
        
        <div class="w-full max-w-md bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/60 border border-slate-200 relative">
            
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-20 h-20 rounded-2xl bg-sky-50 border border-sky-100 p-3 mb-3 shadow-sm flex items-center justify-center">
                    <img src="{{ asset('assets/sabi.webp') }}" alt="SABI" class="w-full h-auto object-contain">
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-slate-900 font-['Jua']">
                    Login Administrator
                </h1>
                <p class="text-xs text-slate-500 mt-1 font-medium">
                    Masukkan kredensial administrator untuk mengelola media SABI.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-2xl bg-red-50 border border-red-200 p-3.5 text-xs font-bold text-red-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1" for="email">Email Administrator</label>
                    <input id="email" name="email" type="email" value="{{ old('email', 'admin@example.com') }}" required autofocus
                        class="w-full h-11 rounded-xl bg-slate-50 border border-slate-200 px-3.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/20 font-medium transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1" for="password">Password</label>
                    <input id="password" name="password" type="password" required placeholder="••••••••"
                        class="w-full h-11 rounded-xl bg-slate-50 border border-slate-200 px-3.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/20 font-medium transition-all">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full h-11 rounded-xl bg-[#0077B6] hover:bg-[#005f92] text-white font-bold text-sm shadow-md shadow-[#0077B6]/25 transition-all active:scale-[0.99] flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        <span>Masuk ke Dashboard</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center pt-4 border-t border-slate-100">
                <a href="{{ url('/') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
                    ← Kembali ke Halaman Utama
                </a>
            </div>

        </div>
    </body>
</html>
