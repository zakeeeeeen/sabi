<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Register</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen overflow-hidden font-['Paytone_One']">
        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                <div class="w-full h-full flex items-center justify-center p-6">
                <div class="w-full max-w-[420px] flex flex-col items-center">
            <h1 class="text-5xl md:text-6xl text-[#2D7BFF] mb-6" style="text-shadow: -3px 0 #ffffff, 3px 0 #ffffff, 0 -3px #ffffff, 0 3px #ffffff, 0 6px 0 rgba(0,0,0,0.12);">
                Daftar
            </h1>

            @if ($errors->any())
                <div class="w-full mb-4 rounded-xl bg-red-50 border-2 border-red-200 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="w-full">
                @csrf

                <div class="w-full rounded-2xl border-4 border-white bg-[#F8E57B] px-5 py-5 shadow-[0_10px_0_rgba(0,0,0,0.08)]">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs text-[#2D7BFF] mb-1" for="name">Nama</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                class="w-full h-8 rounded-md bg-white/90 border border-white/60 px-3 text-sm outline-none focus:ring-2 focus:ring-[#2D7BFF]/30">
                        </div>

                        <div>
                            <label class="block text-xs text-[#2D7BFF] mb-1" for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                                class="w-full h-8 rounded-md bg-white/90 border border-white/60 px-3 text-sm outline-none focus:ring-2 focus:ring-[#2D7BFF]/30">
                        </div>

                        <div>
                            <label class="block text-xs text-[#2D7BFF] mb-1" for="password">Password</label>
                            <input id="password" name="password" type="password" required
                                class="w-full h-8 rounded-md bg-white/90 border border-white/60 px-3 text-sm outline-none focus:ring-2 focus:ring-[#2D7BFF]/30">
                        </div>

                        <div>
                            <label class="block text-xs text-[#2D7BFF] mb-1" for="password_confirmation">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="w-full h-8 rounded-md bg-white/90 border border-white/60 px-3 text-sm outline-none focus:ring-2 focus:ring-[#2D7BFF]/30">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="rounded-full border-2 border-white bg-gradient-to-b from-sky-300 to-sky-500 px-8 py-1 text-white text-sm shadow-[0_6px_0_rgba(0,0,0,0.12)] hover:brightness-105 active:translate-y-[1px] active:shadow-[0_4px_0_rgba(0,0,0,0.12)]">
                        Daftar
                    </button>
                </div>
            </form>

            <div class="mt-4 text-xs text-slate-800">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#2D7BFF] hover:underline">Login</a>
            </div>
        </div>
        </div>
        </div>
        </div>
    </body>
</html>
