<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Pengembangan Bisnis - SABI</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Preload Important Assets for Instant Smooth Switching -->
        <link rel="preload" as="image" href="{{ asset('assets/c_menyapa.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_aksesoris.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_berpikir.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_ide.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_jempol.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/left_button.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/right_button.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Jua&display=swap" rel="stylesheet">

        <script>
            try {
                if (sessionStorage.getItem('app.booted') === '1') {
                    document.documentElement.classList.add('app-booted');
                }
            } catch {
            }
        </script>
        <style>
            

            @keyframes shipSail {
                0% { transform: translateX(105vw); }
                100% { transform: translateX(-35vw); }
            }
            @keyframes shipBob {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-7px) rotate(-1.5deg); }
            }
            @keyframes treeSwaySmooth {
                0%, 100% { transform: rotate(0deg); }
                50% { transform: rotate(2deg); }
            }
            @keyframes charIdleSmooth {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }
            @keyframes bubbleFloatSmooth {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-5px); }
            }
            @keyframes bannerBobSmooth {
                0%, 100% { transform: translateY(0) scale(1); }
                50% { transform: translateY(-6px) scale(1.01); }
            }

            .animate-ship-sail {
                position: absolute;
                left: 0;
                animation: shipSail 38s linear infinite;
                will-change: transform;
                contain: layout style paint;
            }

            .animate-ship-bob {
                animation: shipBob 3.5s ease-in-out infinite;
                will-change: transform;
            }

            .animate-tree-sway {
                transform-origin: top center;
                animation: treeSwaySmooth 6s ease-in-out infinite;
                will-change: transform;
                contain: layout style paint;
            }

            .animate-char-idle {
                animation: charIdleSmooth 3.5s ease-in-out infinite;
                will-change: transform;
            }

            .animate-bubble-float {
                animation: bubbleFloatSmooth 3.8s ease-in-out infinite;
                will-change: transform;
            }

            .animate-banner-float {
                animation: bannerBobSmooth 3.5s ease-in-out infinite;
                will-change: transform;
            }

            .wood-text-shadow {
                text-shadow: 2px 2px 0 #3D1804, -2px -2px 0 #3D1804, 2px -2px 0 #3D1804, -2px 2px 0 #3D1804, 0 3px 5px rgba(0,0,0,0.4);
            }

            .step-panel {
                display: none !important;
            }
            .step-panel.active {
                display: flex !important;
            }

            .bubble-card-shadow {
                box-shadow: -10px 10px 0 #7FBFC9, 0 10px 25px rgba(0,0,0,0.15);
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-[100dvh] h-[100dvh] overflow-hidden font-['Jua'] select-none">
        <!-- Loader -->
        
        </div>

        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                
                <!-- ============================================================
                     1. KAPAL LAUT DI CAKRAWALA (SMOOTH ANIMATED)
                     ============================================================ -->
                <div class="animate-ship-sail z-5 pointer-events-none" style="top: 34%;">
                    <div class="animate-ship-bob pointer-events-none">
                        <img src="{{ asset('assets/kapal.webp') }}" 
                             alt="Kapal Laut" 
                             class="w-[95px] sm:w-[140px] md:w-[200px] lg:w-[260px] h-auto drop-shadow-md select-none pointer-events-none">
                    </div>
                </div>

                <!-- ============================================================
                     2. DEKORASI POHON KIRI & KANAN (SMOOTH ANIMATED)
                     ============================================================ -->
                <div class="absolute z-10 pointer-events-none -top-4 sm:-top-8 md:-top-10 -left-24 sm:-left-36 md:-left-48">
                    <div class="animate-tree-sway pointer-events-none">
                        <img src="{{ asset('assets/pohon.webp') }}" 
                             alt="Pohon Kiri" 
                             class="h-[58vh] sm:h-[75vh] md:h-[88vh] w-auto drop-shadow-md select-none opacity-85 sm:opacity-100 pointer-events-none">
                    </div>
                </div>

                <div class="absolute z-10 pointer-events-none -top-4 sm:-top-8 md:-top-10 -right-24 sm:-right-36 md:-right-48 scale-x-[-1]">
                    <div class="animate-tree-sway pointer-events-none" style="animation-delay: -3s;">
                        <img src="{{ asset('assets/pohon.webp') }}" 
                             alt="Pohon Kanan" 
                             class="h-[58vh] sm:h-[75vh] md:h-[88vh] w-auto drop-shadow-md select-none opacity-85 sm:opacity-100 pointer-events-none">
                    </div>
                </div>

                <!-- ============================================================
                     3. TOP BAR: TOMBOL HOME, STEP BADGE & JUDUL
                     ============================================================ -->
                <!-- Top Left: Tombol Home & Step Indicator Badge -->
                <div class="absolute top-3 left-3 sm:top-4 sm:left-5 md:top-5 md:left-6 z-30 flex items-center gap-2 sm:gap-3">
                    <!-- Tombol Home (Kembali ke Menu Utama) -->
                    <a href="{{ route('menu') }}" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95 cursor-pointer block" title="Kembali ke Menu Utama">
                        <img src="{{ asset('assets/home_button.webp') }}" alt="Menu Utama" class="w-10 sm:w-12 md:w-14 lg:w-16 h-auto drop-shadow-md select-none pointer-events-none">
                    </a>

                    <!-- Step Indicator Badge -->
                    <div class="flex items-center gap-1.5 sm:gap-2 rounded-full bg-white/95 border-2 sm:border-3 border-[#FFB800] px-3 sm:px-4 py-1 sm:py-1.5 shadow-[0_4px_10px_rgba(0,0,0,0.15)] text-[#785135] text-xs sm:text-sm md:text-base font-bold font-['Plus_Jakarta_Sans'] pointer-events-none">
                        <span>Halaman</span>
                        <span id="currentStepNum" class="text-[#00A3FF] font-black text-sm sm:text-base md:text-lg">1</span>
                        <span>/ 5</span>
                    </div>
                </div>

                <!-- Header Title (Tengah Atas) -->
                <div class="absolute left-0 right-0 -top-2 sm:-top-3 md:-top-4 flex justify-center px-4 z-20 pointer-events-none">
                    <img src="{{ asset('assets/pengembanganbisnis.webp') }}" 
                         alt="Pengembangan Bisnis" 
                         class="h-20 sm:h-24 md:h-32 lg:h-36 xl:h-40 w-auto drop-shadow-xl animate-banner-float select-none pointer-events-none">
                </div>

                <!-- Tombol & Modal Pengaturan Suara di Pojok Kanan Atas -->
                <x-sound-settings />

                <!-- ============================================================
                     4. KARAKTER DI SISI KIRI BAWAH (Dinamis berganti tiap step)
                     ============================================================ -->
                <div class="absolute z-20 pointer-events-none -bottom-[75px] sm:-bottom-[85px] md:-bottom-[100px] left-[-35px] sm:left-[-20px] md:left-[10px] lg:left-[25px]">
                    <div class="animate-char-idle pointer-events-none">
                        <img id="charDisplay" 
                             src="{{ asset('assets/c_menyapa.webp') }}" 
                             alt="Karakter" 
                             class="h-[52vh] sm:h-[60vh] md:h-[70vh] w-auto drop-shadow-[0_14px_20px_rgba(0,0,0,0.3)] select-none pointer-events-none transition-transform duration-200">
                    </div>
                </div>

                <!-- ============================================================
                     5. PANEL BUBBLE CHAT BESAR DI TENGAH - KANAN
                     ============================================================ -->
                <div class="absolute z-30 left-[150px] sm:left-[210px] md:left-[280px] lg:left-[340px] right-3 sm:right-6 md:right-10 top-[48%] -translate-y-1/2 flex items-center justify-center pointer-events-auto">
                    
                    <div class="relative w-full max-w-5xl xl:max-w-6xl animate-bubble-float select-none">
                        
                        <!-- White Large Speech Bubble Card -->
                        <div class="bg-white rounded-[24px] sm:rounded-[30px] md:rounded-[36px] border-4 border-white p-3 sm:p-3.5 md:p-4 bubble-card-shadow max-h-[62vh] sm:max-h-[66vh] overflow-y-auto">
                            
                            <!-- STEP 1: Pembukaan Kegiatan (Langsung dialog teks tanpa icon & label) -->
                            <div id="step1" class="step-panel active flex-col items-center justify-center text-center py-8 px-2 sm:px-6">
                                <p class="text-base sm:text-xl md:text-2xl lg:text-3xl text-[#785135] font-bold leading-relaxed max-w-2xl">
                                    Pada bagian ini kamu akan belajar mengapa pengusaha perlu menyimpan sebagian keuntungan dan berinvestasi agar usahanya semakin berkembang di masa depan.
                                </p>
                            </div>

                            <!-- STEP 2: Simulasi Perkembangan Uang Usaha (Format Mockup + Hitung Sendiri) -->
                            <div id="step2" class="step-panel flex-col space-y-2.5 sm:space-y-3 text-left w-full py-0.5">
                                
                                <!-- Header Box Ucapan & Penjualan -->
                                <div class="flex items-start gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-2xl bg-[#F4FAF0] border border-[#CDE5B8]">
                                    <!-- Party Popper Icon SVG (Vektor) -->
                                    <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-white shadow-sm flex items-center justify-center shrink-0 border border-[#D5EAC3]">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-[#0284C7]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5.8 11.3 2 22l10.7-3.8Z" fill="#0284C7" fill-opacity="0.2"/>
                                            <path d="M4 14.8 14.8 4"/>
                                            <path d="m15 9 2-2"/>
                                            <path d="m17 11 3-3"/>
                                            <path d="m13 15 3-3"/>
                                            <circle cx="17" cy="5" r="1.5" fill="#EAB308" stroke="none"/>
                                            <circle cx="11" cy="4" r="1" fill="#EC4899" stroke="none"/>
                                            <circle cx="20" cy="11" r="1" fill="#10B981" stroke="none"/>
                                            <circle cx="8" cy="8" r="1" fill="#F97316" stroke="none"/>
                                        </svg>
                                    </div>

                                    <p class="text-xs sm:text-[13px] md:text-sm font-extrabold text-slate-800 leading-snug">
                                        Selamat! Kerajinan kerang kamu sangat diminati wisatawan sebagai oleh-oleh. Pada penjualan pertama, <span class="text-[#65A30D] font-black text-sm sm:text-base">250</span> kerajinan berhasil terjual habis.
                                    </p>
                                </div>

                                <!-- Baris 1: Pendapatan Sekarang -->
                                <div class="flex items-center justify-between gap-2 py-1 px-1">
                                    <div class="flex items-center gap-2 sm:gap-2.5">
                                        <!-- Gold Coins Stack Icon SVG -->
                                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-amber-50 flex items-center justify-center shrink-0 border border-amber-200">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-amber-600" viewBox="0 0 24 24" fill="currentColor">
                                                <ellipse cx="12" cy="6" rx="8" ry="3" fill="#FACC15" stroke="#CA8A04" stroke-width="1.5"/>
                                                <path d="M4 6v6c0 1.66 3.58 3 8 3s8-1.34 8-3V6" fill="none" stroke="#CA8A04" stroke-width="1.5"/>
                                                <path d="M4 12v6c0 1.66 3.58 3 8 3s8-1.34 8-3v-6" fill="none" stroke="#CA8A04" stroke-width="1.5"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs sm:text-sm md:text-base font-extrabold text-[#65A30D]">
                                            Pendapatanmu sekarang:
                                        </span>
                                    </div>
                                    <span class="px-3 sm:px-4 py-1 rounded-xl bg-[#65A30D] text-white text-xs sm:text-sm md:text-base font-black shadow-sm shrink-0">
                                        Rp1.500.000
                                    </span>
                                </div>

                                <div class="border-t-2 border-slate-200"></div>

                                <!-- Baris 2: Ditambah Sisa Modal Sebelumnya -->
                                <div class="flex items-center justify-between gap-2 py-1 px-1">
                                    <div class="flex items-center gap-2 sm:gap-2.5">
                                        <!-- Wallet Icon SVG -->
                                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 border border-emerald-200">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#854D0E]" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M21 7H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1Z" fill="#A16207"/>
                                                <path d="M16 4H5a4 4 0 0 0-4 4v1" stroke="#854D0E" stroke-width="1.5" stroke-linecap="round"/>
                                                <circle cx="17" cy="14" r="1.5" fill="#FEF08A"/>
                                            </svg>
                                        </div>
                                        <span class="text-xs sm:text-sm md:text-base font-extrabold text-[#65A30D]">
                                            Ditambah sisa modal sebelumnya:
                                        </span>
                                    </div>
                                    <span class="px-3 sm:px-4 py-1 rounded-xl bg-[#65A30D] text-white text-xs sm:text-sm md:text-base font-black shadow-sm shrink-0">
                                        Rp300.000
                                    </span>
                                </div>

                                <div class="border-t-2 border-slate-200"></div>

                                <!-- Form Hitung Total Uang Usaha Sendiri (Tanpa Foreshadowing) -->
                                <form id="hitungTotalUsahaForm" onsubmit="event.preventDefault(); window.submitHitungTotal();" class="pt-0.5 space-y-1.5 flex flex-col items-center">
                                    @csrf
                                    <h4 class="text-xs sm:text-sm md:text-base font-black text-[#65A30D] text-center">
                                        Total uang usahamu sekarang menjadi
                                    </h4>

                                    <div class="flex items-center gap-2 w-full max-w-md">
                                        <!-- Box Input Total Uang Usaha Hijau (Tanpa Foreshadowing) -->
                                        <div class="flex-1 flex items-center gap-2 px-3 py-1.5 sm:py-2 rounded-2xl bg-[#65A30D] text-white shadow-md border-2 border-[#4D7C0F]">
                                            <!-- Coin Icon -->
                                            <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-amber-400 border border-amber-600 flex items-center justify-center shrink-0 shadow-inner">
                                                <span class="text-amber-900 font-black text-xs sm:text-sm">$</span>
                                            </div>
                                            
                                            <span class="font-black text-sm sm:text-lg">Rp</span>
                                            <input id="inputTotalUsaha" type="text" required placeholder=""
                                                class="w-full bg-transparent border-none outline-none font-['Jua'] text-sm sm:text-lg md:text-xl font-black text-white placeholder-white/50 tracking-wider">
                                        </div>

                                        <!-- Tombol Periksa -->
                                        <button type="button" onclick="window.submitHitungTotal()" id="btnPeriksaTotal"
                                            class="rounded-2xl border-2 border-white bg-gradient-to-b from-[#208DEB] to-[#0D6EFD] py-2 px-4 text-white text-xs sm:text-sm font-bold shadow-[0_3px_0_#0B5ED7] hover:brightness-110 active:translate-y-[2px] transition-all flex items-center justify-center gap-1 cursor-pointer shrink-0 font-['Jua']">
                                            <span>Periksa</span>
                                        </button>
                                    </div>
                                </form>

                            </div>

                            <!-- STEP 3: Studi Kasus Mesin Rusak (Pentingnya Tabungan) -->
                            <div id="step3" class="step-panel flex-col space-y-2 text-left w-full py-0.5">
                                <div class="flex items-center gap-2 pb-1 border-b-2 border-rose-100">
                                    <div class="w-7 h-7 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm sm:text-base md:text-lg font-black text-[#6D360B] tracking-tight">
                                        Studi Kasus: Mesin Rusak
                                    </h3>
                                </div>

                                <div class="p-2 sm:p-2.5 rounded-xl bg-rose-50 border-2 border-rose-200">
                                    <p class="text-xs sm:text-[13px] md:text-sm text-slate-800 leading-snug font-medium">
                                        Saat kamu akan memulai produksi kedua, mesin baru untuk melubangi kerang tiba-tiba rusak. Biaya perbaikan mencapai <strong>Rp500.000</strong>. Untungnya kamu masih memiliki dana simpanan dari produksi sebelumnya sehingga masalah itu dapat terselesaikan.
                                    </p>
                                </div>

                                <form id="studiKasusTabunganForm" onsubmit="event.preventDefault(); window.submitTabunganJawaban();" class="space-y-2">
                                    @csrf
                                    <div>
                                        <label class="block text-xs sm:text-sm font-bold text-[#6D360B] mb-1" for="jawabanTabungan">
                                            Menurut kamu, mengapa seorang pengusaha perlu menyimpan sebagian uangnya?
                                        </label>
                                        <textarea id="jawabanTabungan" name="jawaban" rows="3" required placeholder="Tuliskan pendapatmu di sini..."
                                            class="w-full rounded-xl border-2 border-amber-200 p-2 text-xs sm:text-sm text-[#6D360B] outline-none focus:border-[#00A3FF] focus:ring-2 focus:ring-sky-200 resize-none font-bold font-['Plus_Jakarta_Sans']">{{ $tabunganSubmission->payload['jawaban'] ?? '' }}</textarea>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="button" onclick="window.submitTabunganJawaban()" id="btnSubmitTabungan"
                                            class="rounded-full bg-gradient-to-b from-[#00A3FF] to-[#0077B6] px-5 py-1.5 text-white text-xs sm:text-sm font-bold shadow-[0_3px_0_#005B8C] hover:brightness-110 active:translate-y-[2px] transition-all flex items-center gap-1.5 cursor-pointer font-['Jua']">
                                            <span>Simpan Jawaban</span>
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- STEP 4: Mengenal Investasi (Video Pembelajaran) -->
                            <div id="step4" class="step-panel flex-col items-center space-y-2 py-0.5 text-center w-full">
                                <div class="flex items-center gap-2 pb-1 border-b border-purple-100 w-full justify-center">
                                    <div class="w-7 h-7 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base sm:text-lg md:text-xl font-black text-[#6D360B] tracking-tight">
                                        Mengenal Investasi
                                    </h3>
                                </div>

                                <div class="w-full max-w-lg aspect-video rounded-2xl overflow-hidden bg-slate-900 border-2 border-slate-300 shadow-md flex items-center justify-center relative mx-auto">
                                    <iframe id="investasiVideo" 
                                        class="w-full h-full rounded-2xl" 
                                        src="https://www.youtube-nocookie.com/embed/QUPX1R8rVEs?rel=0&modestbranding=1&enablejsapi=1" 
                                        title="Video Pembelajaran Pengembangan Bisnis" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                        allowfullscreen>
                                    </iframe>
                                </div>

                                <p class="text-xs sm:text-[13px] md:text-sm text-[#785135] font-medium leading-snug max-w-xl mx-auto">
                                    Investasi adalah langkah menggunakan sebagian dana untuk membeli alat, mesin, atau teknologi baru yang membuat proses produksi lebih cepat, hemat, dan menghasilkan keuntungan berlipat ganda di masa depan.
                                </p>
                            </div>

                            <!-- STEP 5: Studi Kasus Investasi -->
                            <div id="step5" class="step-panel flex-col space-y-2 text-left w-full py-0.5">
                                <div class="flex items-center gap-2 pb-1 border-b-2 border-emerald-100">
                                    <div class="w-7 h-7 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm sm:text-base md:text-lg font-black text-[#6D360B] tracking-tight">
                                        Studi Kasus: Keputusan Investasi
                                    </h3>
                                </div>

                                <div class="p-2 sm:p-2.5 rounded-xl bg-emerald-50 border-2 border-emerald-200">
                                    <p class="text-xs sm:text-[13px] md:text-sm text-slate-800 leading-snug font-medium">
                                        Permintaan kerajinan kerangmu meningkat pesat. Kamu memiliki opsi untuk membeli mesin otomatis pemoles kerang seharga <strong>Rp1.000.000</strong> yang bisa melipatgandakan produksi harian hingga 4 kali lipat.
                                    </p>
                                </div>

                                <form id="studiKasusInvestasiForm" onsubmit="event.preventDefault(); window.submitInvestasiJawaban();" class="space-y-2">
                                    @csrf
                                    <div>
                                        <label class="block text-xs sm:text-sm font-bold text-[#6D360B] mb-1" for="jawabanInvestasi">
                                            Bagaimana keputusan investasi yang tepat dapat membantu usahamu mendapatkan keuntungan yang lebih besar di masa depan?
                                        </label>
                                        <textarea id="jawabanInvestasi" name="jawaban" rows="3" required placeholder="Tuliskan analisis keputusan investasimu di sini..."
                                            class="w-full rounded-xl border-2 border-emerald-200 p-2 text-xs sm:text-sm text-[#6D360B] outline-none focus:border-[#00A3FF] focus:ring-2 focus:ring-sky-200 resize-none font-bold font-['Plus_Jakarta_Sans']">{{ $investasiSubmission->payload['jawaban'] ?? '' }}</textarea>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="button" onclick="window.submitInvestasiJawaban()" id="btnSubmitInvestasi"
                                            class="rounded-full bg-gradient-to-b from-[#4ADE80] to-[#15803D] px-6 py-2 text-white text-xs sm:text-sm font-bold shadow-[0_3px_0_#0F5128] hover:brightness-110 active:translate-y-[2px] transition-all flex items-center gap-1.5 cursor-pointer font-['Jua']">
                                            <span>Kirim & Selesaikan Modul</span>
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <!-- Ekor Bubble Chat di Kiri mengarah ke Karakter -->
                        <div class="absolute top-1/2 -left-4 -translate-y-1/2 w-5 h-8 overflow-visible pointer-events-none">
                            <svg viewBox="0 0 20 28" class="w-full h-full fill-white overflow-visible">
                                <path d="M20 0 C 14 10, 6 12, 0 14 C 6 16, 14 18, 20 28 Z"/>
                            </svg>
                        </div>

                    </div>

                </div>

                <!-- ============================================================
                     6. BOTTOM NAVIGATION BAR (TOMBOL BACK & NEXT DI BAWAH)
                     ============================================================ -->
                <div class="fixed md:absolute inset-x-0 bottom-3 sm:bottom-4 md:bottom-6 flex items-center justify-between px-6 sm:px-10 md:px-16 z-[10000] pointer-events-auto">
                    <!-- Tombol Kembali / Back (Pojok Kiri Bawah) -->
                    <button type="button" id="btnPrev" onclick="window.navigateStep(-1)"
                            data-sfx="hover"
                            class="transition-transform hover:scale-105 active:scale-95 cursor-pointer bg-transparent border-none p-0 focus:outline-none select-none touch-manipulation relative z-50 pointer-events-auto"
                            title="Kembali">
                        <img src="{{ asset('assets/left_button.webp') }}" alt="Kembali" class="w-14 sm:w-16 md:w-20 lg:w-24 h-auto drop-shadow-xl pointer-events-none select-none">
                    </button>

                    <!-- Tombol Lanjut / Next (Pojok Kanan Bawah) -->
                    <button type="button" id="btnNext" onclick="window.navigateStep(1)"
                            data-sfx="hover"
                            class="transition-transform hover:scale-105 active:scale-95 cursor-pointer bg-transparent border-none p-0 focus:outline-none select-none touch-manipulation relative z-50 pointer-events-auto"
                            title="Lanjut">
                        <img src="{{ asset('assets/right_button.webp') }}" alt="Lanjut" class="w-14 sm:w-16 md:w-20 lg:w-24 h-auto drop-shadow-xl pointer-events-none select-none">
                    </button>
                </div>

                <!-- ============================================================
                     7. UNIVERSAL POPUP FEEDBACK MODAL
                     ============================================================ -->
                <div id="feedbackModal" class="hidden fixed inset-0 z-[10001] flex items-center justify-center p-4 bg-black/65 backdrop-blur-sm select-none font-['Jua']">
            <div class="relative w-full max-w-md rounded-3xl border-4 border-[#3D1804] p-6 text-center shadow-2xl flex flex-col items-center"
                 style="background: linear-gradient(180deg, #9E531F 0%, #7E3E11 25%, #9E531F 30%, #6E330C 65%, #8A4416 70%, #522204 100%);">
                
                <div id="feedbackIconContainer" class="mb-1 -mt-2"></div>

                <h3 id="feedbackTitle" class="text-2xl md:text-3xl font-bold text-[#FFF2A6] wood-text-shadow mb-2"></h3>
                <p id="feedbackMessage" class="rounded-2xl border-2 border-[#612A07] bg-[#FFFDF0] p-4 mb-4 text-xs sm:text-sm text-[#785135] font-semibold leading-relaxed shadow-inner w-full"></p>

                <div id="feedbackButtons" class="flex justify-center w-full"></div>
            </div>
        </div>

        <!-- ============================================================
             8. JAVASCRIPT NAVIGASI & FORM LOGIC
             ============================================================ -->
        <script>
            (() => {
                window.currentStep = 1;
                window.totalSteps = 5;

                // Status kelulusan per step
                window.isStep2Passed = {{ $hitungTotalSubmission ? 'true' : 'false' }};
                window.isStep3Passed = {{ $tabunganSubmission ? 'true' : 'false' }};
                window.isStep5Passed = {{ $investasiSubmission ? 'true' : 'false' }};

                window.stepCharacters = {
                    1: { src: "{{ asset('assets/c_menyapa.webp') }}", flip: false },
                    2: { src: "{{ asset('assets/c_aksesoris.webp') }}", flip: false },
                    3: { src: "{{ asset('assets/c_berpikir.webp') }}", flip: true },
                    4: { src: "{{ asset('assets/c_ide.webp') }}", flip: false },
                    5: { src: "{{ asset('assets/c_berpikir.webp') }}", flip: true }
                };

                window.updateStepUI = function() {
                    // Update Step Badge
                    const stepNumEl = document.getElementById('currentStepNum');
                    if (stepNumEl) stepNumEl.textContent = window.currentStep;

                    // Update Active Step Panel
                    for (let i = 1; i <= window.totalSteps; i++) {
                        const el = document.getElementById(`step${i}`);
                        if (el) {
                            if (i === window.currentStep) {
                                el.classList.add('active');
                            } else {
                                el.classList.remove('active');
                            }
                        }
                    }

                    // Pause video when leaving Step 4
                    const vid = document.getElementById('investasiVideo');
                    if (vid && window.currentStep !== 4) {
                        if (typeof vid.pause === 'function') {
                            vid.pause();
                        } else if (vid.contentWindow) {
                            vid.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                        }
                    }

                    // Update Character Image & Flip
                    const charImg = document.getElementById('charDisplay');
                    const charData = window.stepCharacters[window.currentStep];
                    if (charImg && charData) {
                        charImg.src = charData.src;
                        if (charData.flip) {
                            charImg.style.transform = 'scaleX(-1)';
                        } else {
                            charImg.style.transform = 'scaleX(1)';
                        }
                    }

                    // Update Next Button: Sembunyikan di step 5
                    const btnNext = document.getElementById('btnNext');
                    if (btnNext) {
                        if (window.currentStep === window.totalSteps) {
                            btnNext.style.display = 'none';
                        } else {
                            btnNext.style.display = 'block';
                        }
                    }

                    // Prev Button selalu tampil
                    const btnPrev = document.getElementById('btnPrev');
                    if (btnPrev) {
                        btnPrev.style.display = 'block';
                    }
                };

                let isNavigating = false;
                window.navigateStep = function(direction) {
                    if (isNavigating) return;
                    isNavigating = true;
                    setTimeout(() => { isNavigating = false; }, 250);

                    if (direction === -1 && window.currentStep === 1) {
                        if (window.sabiRouter) {
                            window.sabiRouter.navigateTo("{{ route('bisnisku') }}");
                        } else {
                            window.location.href = "{{ route('bisnisku') }}";
                        }
                        return;
                    }

                    // Validasi Step 2: Harus dihitung benar sebelum lanjut ke Step 3
                    if (direction === 1 && window.currentStep === 2 && !window.isStep2Passed) {
                        window.showFeedbackModal(false, 'Maaf, Jawaban Kurang Tepat!', 'Coba hitung dan periksa total uang usahamu terlebih dahulu (Pendapatan + Sisa Modal Sebelumnya).');
                        return;
                    }

                    // Validasi Step 3: Harus diisi & disimpan sebelum lanjut ke Step 4
                    if (direction === 1 && window.currentStep === 3 && !window.isStep3Passed) {
                        window.showFeedbackModal(false, 'Jawaban Belum Diisi!', 'Silakan tuliskan dan simpan pendapatmu mengenai studi kasus tabungan terlebih dahulu.');
                        return;
                    }

                    const next = window.currentStep + direction;
                    if (next >= 1 && next <= window.totalSteps) {
                        window.currentStep = next;
                        window.updateStepUI();
                    }
                };

                window.showFeedbackModal = function(isSuccess, title, message, onConfirm = null, isFinal = false) {
                    const modal = document.getElementById('feedbackModal');
                    const iconContainer = document.getElementById('feedbackIconContainer');
                    const titleEl = document.getElementById('feedbackTitle');
                    const msgEl = document.getElementById('feedbackMessage');
                    const btnContainer = document.getElementById('feedbackButtons');

                    if (isSuccess) {
                        iconContainer.innerHTML = `<img src="{{ asset('assets/c_jempol.webp') }}" alt="Hebat" class="h-32 sm:h-36 w-auto drop-shadow select-none">`;
                        titleEl.textContent = title || "Kamu Hebat!";
                    } else {
                        iconContainer.innerHTML = `<img src="{{ asset('assets/c_berpikir.webp') }}" alt="Coba Lagi" class="h-32 sm:h-36 w-auto drop-shadow select-none transform scale-x-[-1]">`;
                        titleEl.textContent = title || "Maaf, Jawaban Kurang Tepat!";
                    }

                    msgEl.textContent = message;
                    btnContainer.innerHTML = '';

                    if (isFinal) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = "rounded-full border-2 border-white bg-gradient-to-b from-[#00A3FF] to-[#0077B6] px-8 py-2.5 text-sm sm:text-base font-bold text-white shadow-[0_3px_0_#005B8C] hover:brightness-110 active:translate-y-[2px] transition-all cursor-pointer font-['Jua']";
                        btn.textContent = "Kembali ke Menu Utama";
                        btn.onclick = function() {
                            modal.classList.add('hidden');
                            modal.style.display = 'none';
                            if (window.sabiRouter) {
                                window.sabiRouter.navigateTo("{{ route('menu') }}");
                            } else {
                                window.location.href = "{{ route('menu') }}";
                            }
                        };
                        btnContainer.appendChild(btn);
                    } else if (isSuccess) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = "rounded-full border-2 border-white bg-gradient-to-b from-[#4ADE80] to-[#15803D] px-8 py-2.5 text-sm sm:text-base font-bold text-white shadow-[0_3px_0_#0F5128] hover:brightness-110 active:translate-y-[2px] transition-all cursor-pointer font-['Jua']";
                        btn.textContent = "Lanjut";
                        btn.onclick = function() {
                            modal.classList.add('hidden');
                            if (typeof onConfirm === 'function') {
                                onConfirm();
                            }
                        };
                        btnContainer.appendChild(btn);
                    } else {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = "rounded-full border-2 border-white bg-gradient-to-b from-[#FFA726] to-[#E65100] px-8 py-2.5 text-sm sm:text-base font-bold text-white shadow-[0_3px_0_#BF360C] hover:brightness-110 active:translate-y-[2px] transition-all cursor-pointer font-['Jua']";
                        btn.textContent = "Coba Lagi";
                        btn.onclick = function() {
                            modal.classList.add('hidden');
                        };
                        btnContainer.appendChild(btn);
                    }

                    modal.classList.remove('hidden');
                };

                // Step 2 Action
                window.submitHitungTotal = async function() {
                    const btn = document.getElementById('btnPeriksaTotal');
                    const inputEl = document.getElementById('inputTotalUsaha');
                    const jawaban = inputEl ? inputEl.value.trim() : '';

                    if (!jawaban) {
                        window.showFeedbackModal(false, 'Jawaban Masih Kosong', 'Silakan hitung dan masukkan total uang usahamu terlebih dahulu.');
                        return;
                    }

                    btn.disabled = true;
                    btn.innerText = "Memeriksa...";
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

                    try {
                        const res = await fetch("{{ route('bisnisku.pengembangan-bisnis.hitung-total') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ jawaban })
                        });

                        const data = await res.json();
                        if (data.is_correct) {
                            window.isStep2Passed = true;
                            window.showFeedbackModal(true, data.title, data.message, () => {
                                window.navigateStep(1); // Lanjut ke step 3
                            });
                        } else {
                            window.isStep2Passed = false;
                            window.showFeedbackModal(false, data.title, data.message);
                        }
                    } catch (err) {
                        window.showFeedbackModal(false, 'Terjadi Kesalahan', 'Gagal memeriksa jawaban. Silakan coba lagi.');
                    } finally {
                        btn.disabled = false;
                        btn.innerText = "Periksa";
                    }
                };

                // Step 3 Action
                window.submitTabunganJawaban = async function() {
                    const inputEl = document.getElementById('jawabanTabungan');
                    const jawaban = inputEl ? inputEl.value.trim() : '';

                    if (!jawaban) {
                        window.showFeedbackModal(false, 'Jawaban Belum Diisi!', 'Silakan tuliskan pendapatmu mengenai studi kasus tabungan terlebih dahulu.');
                        return;
                    }

                    const btn = document.getElementById('btnSubmitTabungan');
                    btn.disabled = true;
                    btn.innerText = "Menyimpan...";
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

                    try {
                        const res = await fetch("{{ route('bisnisku.pengembangan-bisnis.tabungan') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ jawaban })
                        });

                        const data = await res.json();
                        if (data.status === 'success') {
                            window.isStep3Passed = true;
                            window.showFeedbackModal(true, data.title || "Kamu Hebat!", data.message || "Hebat! Jawabanmu telah tersimpan.", () => {
                                window.navigateStep(1); // Lanjut ke step 4 (video)
                            });
                        }
                    } catch (err) {
                        window.showFeedbackModal(false, 'Terjadi Kesalahan', 'Gagal menyimpan jawaban. Silakan coba lagi.');
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = `<span>Simpan Jawaban</span><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>`;
                    }
                };

                // Step 5 Action
                window.submitInvestasiJawaban = async function() {
                    const inputEl = document.getElementById('jawabanInvestasi');
                    const jawaban = inputEl ? inputEl.value.trim() : '';

                    if (!jawaban) {
                        window.showFeedbackModal(false, 'Jawaban Belum Diisi!', 'Silakan tuliskan analisis keputusan investasimu terlebih dahulu.');
                        return;
                    }

                    const btn = document.getElementById('btnSubmitInvestasi');
                    btn.disabled = true;
                    btn.innerText = "Menyimpan...";
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

                    try {
                        const res = await fetch("{{ route('bisnisku.pengembangan-bisnis.investasi') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ jawaban })
                        });

                        const data = await res.json();
                        if (data.status === 'success') {
                            window.isStep5Passed = true;
                            window.showFeedbackModal(true, data.title || "Kamu Hebat!", "Selamat, Pengusaha Hebat! Kamu telah menyelesaikan seluruh tahapan materi pembelajaran Bisnisku dengan luar biasa!", null, true);
                        }
                    } catch (err) {
                        window.showFeedbackModal(false, 'Terjadi Kesalahan', 'Gagal menyimpan jawaban. Silakan coba lagi.');
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = `<span>Kirim & Selesaikan Modul</span><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>`;
                    }
                };

                window.updateStepUI();
                document.addEventListener('DOMContentLoaded', () => {
                    window.updateStepUI();
                });
            })();
        </script>
            </div>
        </div>
    </body>
</html>
