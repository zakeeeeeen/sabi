<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Masuk - SABI</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jua&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen overflow-hidden font-['Jua']">
        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                <div class="w-full h-full flex items-center justify-center p-4 md:p-6">
                    <div class="w-full max-w-[440px] flex flex-col items-center">
                        <img src="{{ asset('assets/sabi.webp') }}" alt="SABI Logo" class="w-28 md:w-36 h-auto mb-2 drop-shadow-md">

                        <h1 class="text-3xl md:text-5xl text-[#2D7BFF] mb-3 text-center leading-tight" style="text-shadow: -2px 0 #ffffff, 2px 0 #ffffff, 0 -2px #ffffff, 0 2px #ffffff, 0 4px 0 rgba(0,0,0,0.12);">
                            Siapa Namamu?
                        </h1>

                        @if ($errors->any())
                            <div class="w-full mb-3 rounded-xl bg-red-50 border-2 border-red-200 px-4 py-2 text-xs font-['Plus_Jakarta_Sans'] font-bold text-red-700">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="w-full">
                            @csrf

                            <div class="w-full rounded-2xl border-4 border-white bg-[#F8E57B] px-5 py-4 shadow-[0_10px_0_rgba(0,0,0,0.08)]">
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs md:text-sm text-[#2D7BFF] mb-1" for="name">Nama Panggilan / Lengkap</label>
                                        <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Tuliskan namamu di sini..." required autofocus
                                            class="w-full h-11 rounded-xl bg-white border-2 border-white/80 px-4 text-slate-800 text-sm md:text-base font-['Plus_Jakarta_Sans'] font-bold outline-none focus:ring-4 focus:ring-[#2D7BFF]/30 placeholder:font-normal placeholder:text-slate-400">
                                    </div>

                                    <div>
                                        <label class="block text-xs md:text-sm text-[#2D7BFF] mb-1.5">Pilih Karakter</label>
                                        <div class="grid grid-cols-2 gap-3 font-['Plus_Jakarta_Sans']">
                                            <label class="relative flex flex-col items-center p-2 rounded-xl bg-white/70 border-2 border-white cursor-pointer transition-all hover:bg-white has-[:checked]:bg-sky-100 has-[:checked]:border-[#2D7BFF] has-[:checked]:ring-2 has-[:checked]:ring-[#2D7BFF]">
                                                <input type="radio" name="avatar" value="co" class="sr-only" checked>
                                                <img src="{{ asset('assets/karakterco.png') }}" alt="Karakter Laki-laki" class="w-14 h-14 md:w-16 md:h-16 object-contain mb-1">
                                                <span class="text-xs font-bold text-slate-700">Laki-Laki</span>
                                            </label>

                                            <label class="relative flex flex-col items-center p-2 rounded-xl bg-white/70 border-2 border-white cursor-pointer transition-all hover:bg-white has-[:checked]:bg-pink-100 has-[:checked]:border-pink-500 has-[:checked]:ring-2 has-[:checked]:ring-pink-500">
                                                <input type="radio" name="avatar" value="ce" class="sr-only">
                                                <img src="{{ asset('assets/karakterce.png') }}" alt="Karakter Perempuan" class="w-14 h-14 md:w-16 md:h-16 object-contain mb-1">
                                                <span class="text-xs font-bold text-slate-700">Perempuan</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-center mt-5">
                                <button type="submit"
                                    class="w-full max-w-[240px] rounded-full border-3 border-white bg-gradient-to-b from-[#2D7BFF] to-[#145cd4] py-3 text-white text-base md:text-lg tracking-wide shadow-[0_6px_0_rgba(0,0,0,0.15)] hover:brightness-110 active:translate-y-[2px] active:shadow-[0_2px_0_rgba(0,0,0,0.15)] transition-all">
                                    Mulai Belajar!
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
