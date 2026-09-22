<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Petunjuk - SABI</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jua&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

        <script>
            try {
                if (sessionStorage.getItem('app.booted') === '1') {
                    document.documentElement.classList.add('app-booted');
                }
            } catch {
            }
        </script>
        <style>
            
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-[100dvh] h-[100dvh] overflow-hidden font-['Jua']">
        
        </div>

        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                
                <!-- Header Title -->
                <div class="absolute left-0 right-0 -top-2 sm:-top-3 md:-top-4 flex justify-center px-4 z-20 pointer-events-none">
                    <img src="{{ asset('assets/menupanduan.webp') }}" alt="Panduan" class="h-20 sm:h-24 md:h-32 lg:h-36 xl:h-40 w-auto drop-shadow-xl animate-banner-float select-none">
                </div>

                <!-- Top Left Back Button -->
                <div class="absolute top-3 left-3 sm:top-4 sm:left-5 md:top-5 md:left-6 z-30">
                    <a href="{{ route('menu') }}" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95 cursor-pointer block">
                        <img src="{{ asset('assets/left_button.webp') }}" alt="Kembali" class="w-11 sm:w-13 md:w-16 h-auto drop-shadow-md">
                    </a>
                </div>

                <!-- Top Right Logo -->
                <div class="absolute top-3 right-3 md:top-5 md:right-6 z-20">
                    <img src="{{ asset('assets/sabi.webp') }}" alt="SABI" class="w-24 md:w-36 h-auto drop-shadow">
                </div>

        <!-- Main Content: 4 Steps with Wood Accent Panel -->
        <div class="absolute inset-x-0 top-[16%] md:top-[19%] bottom-4 md:bottom-6 flex items-center justify-center px-4 md:px-10 overflow-y-auto">
            <!-- Wooden Outer Frame -->
            <div class="w-full max-w-4xl rounded-[32px] bg-gradient-to-b from-[#8C5831] via-[#734220] to-[#542F16] p-2.5 sm:p-3.5 shadow-[0_14px_28px_rgba(0,0,0,0.4),0_6px_0_#3A1F0D] border-4 border-[#A36E43]">
                <!-- Inner Parchment Container -->
                <div class="rounded-[24px] bg-[#FFFBF0]/95 border-2 border-[#D4A373] p-4 sm:p-6 md:p-7 font-['Jua'] shadow-inner">
                    
                    <div class="flex items-center gap-2.5 mb-3.5 pb-2.5 border-b-2 border-[#D4A373]/50 text-[#5C351B]">
                        <div class="w-8 h-8 rounded-xl bg-[#8C5831] text-[#FFE8B6] flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.3" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <h2 class="text-base sm:text-lg md:text-xl font-bold text-[#5C351B] font-['Jua'] tracking-wide">
                            Petunjuk Cara Menggunakan Media
                        </h2>
                    </div>

                    <div class="space-y-2.5 sm:space-y-3 font-['Jua']">
                        
                        <!-- Point 1 -->
                        <div class="flex items-center gap-3 p-2.5 sm:p-3 rounded-2xl bg-white/90 border-2 border-amber-200/80 shadow-sm hover:bg-white transition-colors">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#E08A00] text-white flex items-center justify-center font-bold text-sm sm:text-base shrink-0 shadow-sm">
                                1
                            </div>
                            <p class="text-sm sm:text-base md:text-lg text-slate-800 tracking-wide">
                                <strong class="text-[#E08A00]">Pilihlah menu</strong> yang tersedia pada beranda.
                            </p>
                        </div>

                        <!-- Point 2 -->
                        <div class="flex items-center gap-3 p-2.5 sm:p-3 rounded-2xl bg-white/90 border-2 border-sky-200/80 shadow-sm hover:bg-white transition-colors">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#0094E0] text-white flex items-center justify-center font-bold text-sm sm:text-base shrink-0 shadow-sm">
                                2
                            </div>
                            <p class="text-sm sm:text-base md:text-lg text-slate-800 tracking-wide">
                                <strong class="text-[#0094E0]">Ikuti kegiatan pembelajaran</strong> dalam menu Bisnisku.
                            </p>
                        </div>

                        <!-- Point 3 (With left_button logo) -->
                        <div class="flex items-center gap-3 p-2.5 sm:p-3 rounded-2xl bg-white/90 border-2 border-indigo-200/80 shadow-sm hover:bg-white transition-colors">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#4F46E5] text-white flex items-center justify-center font-bold text-sm sm:text-base shrink-0 shadow-sm">
                                3
                            </div>
                            <div class="flex items-center gap-2 flex-1 flex-wrap">
                                <p class="text-sm sm:text-base md:text-lg text-slate-800 tracking-wide">
                                    Gunakan <strong class="text-[#4F46E5]">tombol kembali</strong> untuk menuju pembelajaran sebelumnya.
                                </p>
                                <img src="{{ asset('assets/left_button.webp') }}" alt="Tombol Kembali" class="w-7 h-7 sm:w-8 sm:h-8 object-contain shrink-0 drop-shadow select-none">
                            </div>
                        </div>

                        <!-- Point 4 (With right_button logo) -->
                        <div class="flex items-center gap-3 p-2.5 sm:p-3 rounded-2xl bg-white/90 border-2 border-emerald-200/80 shadow-sm hover:bg-white transition-colors">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#059669] text-white flex items-center justify-center font-bold text-sm sm:text-base shrink-0 shadow-sm">
                                4
                            </div>
                            <div class="flex items-center gap-2 flex-1 flex-wrap">
                                <p class="text-sm sm:text-base md:text-lg text-slate-800 tracking-wide">
                                    Gunakan <strong class="text-[#059669]">tombol lanjut</strong> untuk menuju pembelajaran berikutnya.
                                </p>
                                <img src="{{ asset('assets/right_button.webp') }}" alt="Tombol Lanjut" class="w-7 h-7 sm:w-8 sm:h-8 object-contain shrink-0 drop-shadow select-none">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

            </div>
        </div>
    </body>
</html>
