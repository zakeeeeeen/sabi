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

            <div class="absolute top-4 left-4 md:top-6 md:left-6 flex items-center gap-2">
                <button type="button" data-font-decrease class="rounded-xl bg-white/90 border border-black/10 px-3 py-2 text-slate-900 text-sm md:text-base shadow hover:bg-white active:translate-y-[1px]">
                    A-
                </button>
                <div data-font-indicator class="rounded-xl bg-white/90 border border-black/10 px-3 py-2 text-slate-900 text-sm md:text-base shadow">
                    100%
                </div>
                <button type="button" data-font-increase class="rounded-xl bg-white/90 border border-black/10 px-3 py-2 text-slate-900 text-sm md:text-base shadow hover:bg-white active:translate-y-[1px]">
                    A+
                </button>
                <button type="button" data-font-bold class="rounded-xl bg-white/90 border border-black/10 px-3 py-2 text-slate-900 text-sm md:text-base shadow hover:bg-white active:translate-y-[1px] font-bold">
                    B
                </button>
            </div>

            @if (! $question)
                <div class="absolute inset-x-0 top-[35%] flex justify-center px-6">
                    <div class="w-full max-w-2xl text-center text-slate-900 text-base md:text-xl">
                        Soal belum tersedia.
                    </div>
                </div>
                <div class="absolute left-0 right-0 bottom-6 md:bottom-8 flex justify-center">
                    <a href="{{ route('menu') }}" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/left_button.webp') }}" alt="Kembali" class="w-12 sm:w-14 md:w-16 h-auto drop-shadow-md">
                    </a>
                </div>
            @else
                <form method="POST" action="{{ route('quiz.answer') }}">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">

                    <div class="absolute inset-x-0 top-[26%] md:top-[28%] flex justify-center px-6">
                        <div class="w-full max-w-4xl">
                            <div class="font-['Jua'] text-slate-900 text-base md:text-xl leading-relaxed" data-font-target data-font-base="1.25">
                                <span>{{ $number }}.</span>
                                <span>{{ $question->question }}</span>
                            </div>

                            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-x-24 gap-y-5 md:gap-y-7">
                                @php
                                    $options = [
                                        'a' => $question->option_a,
                                        'b' => $question->option_b,
                                        'c' => $question->option_c,
                                        'd' => $question->option_d,
                                    ];
                                @endphp

                                @foreach ($options as $key => $label)
                                    <label class="flex items-center gap-3 md:gap-4 cursor-pointer select-none">
                                        <input type="radio" name="answer" value="{{ $key }}" class="sr-only peer" @checked($selected === $key) required>
                                        <span class="w-5 h-5 md:w-6 md:h-6 rounded-full border-2 border-slate-900 bg-white relative after:content-[''] after:absolute after:inset-[3px] md:after:inset-[4px] after:rounded-full after:bg-lime-400 after:opacity-0 after:transition-opacity peer-checked:after:opacity-100 peer-checked:border-lime-700"></span>
                                        <span class="font-['Jua'] text-slate-900 text-base md:text-xl" data-font-target data-font-base="1.25">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="absolute bottom-6 right-6 md:bottom-8 md:right-10 transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/right_button.webp') }}" alt="Lanjut" class="w-14 sm:w-16 md:w-20 h-auto drop-shadow-md">
                    </button>
                </form>
            @endif
        </div>
        </div>
    </body>
</html>
