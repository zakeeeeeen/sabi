<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Soal Evaluasi</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Paytone+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-[100dvh] h-[100dvh] overflow-hidden font-['Paytone_One']">
        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                <div class="absolute left-0 right-0 top-5 md:top-12 flex justify-center px-6">
                <div class="rounded-[28px] bg-[#D9D9D9]/70 px-10 md:px-14 py-3 md:py-4 border border-black/10 shadow-[0_10px_0_rgba(0,0,0,0.18)]">
                    <div class="text-[#00A3FF] text-3xl md:text-6xl leading-none tracking-wide"
                        style="text-shadow: -3px 0 #ffffff, 3px 0 #ffffff, 0 -3px #ffffff, 0 3px #ffffff, 0 6px 0 rgba(0,0,0,0.15);">
                        SOAL EVALUASI
                    </div>
                </div>
            </div>

            <div class="absolute top-4 right-4 md:top-6 md:right-6">
                <img src="{{ asset('assets/sabi.webp') }}" alt="SABI" class="w-16 md:w-24 h-auto">
            </div>

            <div class="absolute inset-x-0 top-[30%] md:top-[32%] flex justify-center px-6">
                <div class="w-full max-w-sm md:max-w-md rounded-3xl bg-white/80 border-2 border-slate-300 shadow-[0_10px_0_rgba(0,0,0,0.18)] px-10 md:px-12 py-10 text-center">
                    <div class="text-lime-600 text-2xl md:text-3xl leading-none tracking-wide">
                        POIN
                    </div>
                    <div class="mt-4 text-[#00A3FF] text-6xl md:text-7xl leading-none tracking-wide"
                        style="text-shadow: -3px 0 #ffffff, 3px 0 #ffffff, 0 -3px #ffffff, 0 3px #ffffff, 0 6px 0 rgba(0,0,0,0.15);">
                        {{ $points }}
                    </div>
                    <div class="mt-6 flex items-center justify-center gap-6">
                        <a href="{{ route('quiz.start') }}" class="transition-transform hover:scale-105 active:scale-95">
                            <img src="{{ asset('assets/ulangi.png') }}" alt="Ulangi" class="w-28 md:w-32 h-auto">
                        </a>
                        <a href="{{ route('menu') }}" class="transition-transform hover:scale-105 active:scale-95">
                            <img src="{{ asset('assets/selesai.png') }}" alt="Selesai" class="w-28 md:w-32 h-auto">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
</html>
