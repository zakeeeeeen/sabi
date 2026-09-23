<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Ide Bisnisku - SABI</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Preload Important Assets for Instant Switching -->
        <link rel="preload" as="image" href="{{ asset('assets/c_kerang.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_ide.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_menyapa.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_berpikir.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_jempol.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/left_button.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/right_button.webp') }}">

        <!-- Fonts -->
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
            

            /* ============================================================
               SMOOTH 60FPS HARDWARE-ACCELERATED ANIMATIONS (NO MAIN-THREAD JANK)
               ============================================================ */
            @keyframes shipSail {
                0% {
                    transform: translate3d(100vw, 0, 0);
                }
                100% {
                    transform: translate3d(-450px, 0, 0);
                }
            }

            @keyframes shipBob {
                0%, 100% {
                    transform: translate3d(0, 0, 0) rotate(0deg);
                }
                50% {
                    transform: translate3d(0, -6px, 0) rotate(-1.5deg);
                }
            }

            @keyframes treeSwaySmooth {
                0%, 100% {
                    transform: translate3d(0, 0, 0) rotate(0deg);
                }
                50% {
                    transform: translate3d(0, 0, 0) rotate(1.8deg);
                }
            }

            @keyframes charIdleSmooth {
                0%, 100% {
                    transform: translate3d(0, 0, 0);
                }
                50% {
                    transform: translate3d(0, -6px, 0);
                }
            }

            @keyframes bubbleFloatSmooth {
                0%, 100% {
                    transform: translate3d(0, 0, 0);
                }
                50% {
                    transform: translate3d(0, -5px, 0);
                }
            }

            @keyframes bannerBobSmooth {
                0%, 100% {
                    transform: translate3d(0, 0, 0);
                }
                50% {
                    transform: translate3d(0, 6px, 0);
                }
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
                transform-origin: bottom center;
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

        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                
                <!-- ============================================================
                     1. KAPAL LAUT DI CAKRAWALA (SMOOTH ANIMATED)
                     ============================================================ -->
                <div class="animate-ship-sail z-5 pointer-events-none" style="top: 37%;">
                    <div class="animate-ship-bob pointer-events-none">
                        <img src="{{ asset('assets/kapal.webp') }}" 
                             alt="Kapal Laut" 
                             class="w-[140px] sm:w-[190px] md:w-[240px] lg:w-[270px] h-auto drop-shadow-md select-none pointer-events-none">
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
                        <span>/ 4</span>
                    </div>
                </div>

                <!-- Header Title (Tengah Atas) -->
                <div class="absolute left-0 right-0 -top-2 sm:-top-3 md:-top-4 flex justify-center px-4 z-20 pointer-events-none">
                    <img src="{{ asset('assets/idebisnisku.webp') }}" 
                         alt="Ide Bisnisku" 
                         class="h-20 sm:h-24 md:h-32 lg:h-36 xl:h-40 w-auto drop-shadow-xl animate-banner-float select-none pointer-events-none">
                </div>

                <!-- Tombol & Modal Pengaturan Suara di Pojok Kanan Atas -->
                <x-sound-settings />

                <!-- ============================================================
                     4. KARAKTER DI SISI KIRI BAWAH
                     ============================================================ -->
                <div class="absolute z-20 pointer-events-none -bottom-[75px] sm:-bottom-[85px] md:-bottom-[100px] left-[-35px] sm:left-[-20px] md:left-[10px] lg:left-[25px]">
                    <div class="animate-char-idle pointer-events-none">
                        <img id="charDisplay" 
                             src="{{ asset('assets/c_kerang.webp') }}" 
                             alt="Karakter" 
                             class="h-[52vh] sm:h-[60vh] md:h-[70vh] w-auto drop-shadow-[0_14px_20px_rgba(0,0,0,0.3)] select-none pointer-events-none transition-transform duration-200">
                    </div>
                </div>

                <!-- ============================================================
                     5. PANEL BUBBLE CHAT BESAR DI TENGAH - KANAN
                     ============================================================ -->
                <div class="absolute z-30 left-[165px] sm:left-[225px] md:left-[300px] lg:left-[360px] right-3 sm:right-6 md:right-12 top-[48%] -translate-y-1/2 flex items-center justify-center pointer-events-auto">
                    
                    <div class="relative w-full max-w-3xl animate-bubble-float select-none">
                        
                        <!-- White Large Speech Bubble Card -->
                        <div class="bg-white rounded-[28px] sm:rounded-[36px] md:rounded-[42px] border-4 border-white p-5 sm:p-7 md:p-9 max-h-[58vh] md:max-h-[62vh] overflow-y-auto bubble-card-shadow">
                            
                            <!-- STEP 1: Pembukaan (Karakter: c_kerang) -->
                            <div id="step1" class="step-panel active flex-col items-center justify-center text-center py-6 px-2 sm:px-6">
                                <p class="text-base sm:text-xl md:text-2xl lg:text-3xl text-[#785135] font-bold leading-relaxed max-w-2xl">
                                    Pada kegiatan ini kamu akan mencari tahu bagaimana industri kerajinan kulit kerang dapat menjadi sumber pendapatan yang hebat bagi masyarakat pesisir!
                                </p>
                            </div>

                            <!-- STEP 2: Aktivitas Ekonomi Pesisir & Kerajinan Kulit Kerang (Karakter: c_ide) -->
                            <div id="step2" class="step-panel flex-col space-y-3 sm:space-y-4 py-1 sm:py-2 px-1 sm:px-3 text-left text-[#785135]">
                                <p class="text-xs sm:text-sm md:text-base lg:text-lg font-medium leading-relaxed">
                                    Saat berwisata ke pantai, kita bisa melihat berbagai jenis aktivitas ekonomi pesisir. Ada yang menjual ikan, memanen rumput laut, membuka olahan kuliner dan wisata bahari. Selain itu, banyak juga warga yang menjual cenderamata dari hasil laut untuk oleh-oleh.
                                </p>
                                <p class="text-xs sm:text-sm md:text-base lg:text-lg font-medium leading-relaxed">
                                    Salah satu oleh-oleh yang paling diminati wisatawan adalah kerajinan dari kulit kerang. Melihat peluang ini, masyarakat pesisir mendirikan industri kerajinan kulit kerang. Mereka mengolah kulit kerang menjadi berbagai benda pajangan yang indah untuk dijual. Melalui usaha kreatif ini, warga pesisir bisa mendapatkan penghasilan untuk memenuhi kebutuhan hidup mereka.
                                </p>

                                <!-- Contoh Produk Kerajinan Kulit Kerang -->
                                <div class="pt-2">
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-3 md:gap-4">
                                        
                                        <!-- 1. Gelang Kerang -->
                                        <div class="bg-gradient-to-b from-[#FFFDF8] to-[#FFF4E0] border-2 border-[#D4A373]/70 rounded-2xl p-2 sm:p-2.5 flex flex-col items-center justify-between shadow-[0_4px_10px_rgba(0,0,0,0.08)] hover:scale-105 transition-transform duration-200">
                                            <div class="w-full h-20 sm:h-24 md:h-28 rounded-xl bg-white flex items-center justify-center p-1.5 border border-amber-200/50 shadow-inner overflow-hidden">
                                                <img src="{{ asset('assets/gelang.webp') }}" alt="Gelang Kerang" class="w-full h-full object-contain select-none pointer-events-none">
                                            </div>
                                            <span class="mt-2 text-xs sm:text-sm font-bold text-[#6D360B] font-['Jua'] tracking-wide text-center leading-tight">
                                                Gelang Kerang
                                            </span>
                                        </div>

                                        <!-- 2. Kalung Kerang -->
                                        <div class="bg-gradient-to-b from-[#FFFDF8] to-[#FFF4E0] border-2 border-[#D4A373]/70 rounded-2xl p-2 sm:p-2.5 flex flex-col items-center justify-between shadow-[0_4px_10px_rgba(0,0,0,0.08)] hover:scale-105 transition-transform duration-200">
                                            <div class="w-full h-20 sm:h-24 md:h-28 rounded-xl bg-white flex items-center justify-center p-1.5 border border-amber-200/50 shadow-inner overflow-hidden">
                                                <img src="{{ asset('assets/kalung.webp') }}" alt="Kalung Kerang" class="w-full h-full object-contain select-none pointer-events-none">
                                            </div>
                                            <span class="mt-2 text-xs sm:text-sm font-bold text-[#6D360B] font-['Jua'] tracking-wide text-center leading-tight">
                                                Kalung Kerang
                                            </span>
                                        </div>

                                        <!-- 3. Gantungan Kunci Kerang -->
                                        <div class="bg-gradient-to-b from-[#FFFDF8] to-[#FFF4E0] border-2 border-[#D4A373]/70 rounded-2xl p-2 sm:p-2.5 flex flex-col items-center justify-between shadow-[0_4px_10px_rgba(0,0,0,0.08)] hover:scale-105 transition-transform duration-200">
                                            <div class="w-full h-20 sm:h-24 md:h-28 rounded-xl bg-white flex items-center justify-center p-1.5 border border-amber-200/50 shadow-inner overflow-hidden">
                                                <img src="{{ asset('assets/ganci.webp') }}" alt="Gantungan Kunci Kerang" class="w-full h-full object-contain select-none pointer-events-none">
                                            </div>
                                            <span class="mt-2 text-xs sm:text-sm font-bold text-[#6D360B] font-['Jua'] tracking-wide text-center leading-tight">
                                                Gantungan Kunci Kerang
                                            </span>
                                        </div>

                                        <!-- 4. Hiasan Kerang -->
                                        <div class="bg-gradient-to-b from-[#FFFDF8] to-[#FFF4E0] border-2 border-[#D4A373]/70 rounded-2xl p-2 sm:p-2.5 flex flex-col items-center justify-between shadow-[0_4px_10px_rgba(0,0,0,0.08)] hover:scale-105 transition-transform duration-200">
                                            <div class="w-full h-20 sm:h-24 md:h-28 rounded-xl bg-white flex items-center justify-center p-1.5 border border-amber-200/50 shadow-inner overflow-hidden">
                                                <img src="{{ asset('assets/hiasan.webp') }}" alt="Hiasan Kerang" class="w-full h-full object-contain select-none pointer-events-none">
                                            </div>
                                            <span class="mt-2 text-xs sm:text-sm font-bold text-[#6D360B] font-['Jua'] tracking-wide text-center leading-tight">
                                                Hiasan Kerang
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- STEP 3: Yuk Kenali Pantai Kenjeran (Karakter: c_menyapa) -->
                            <div id="step3" class="step-panel flex-col space-y-4 py-2 px-1 sm:px-3 text-left text-[#785135]">
                                <h2 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-[#6D360B] leading-snug border-b-2 border-amber-100 pb-2">
                                    Yuk, Kenali Pantai Kenjeran
                                </h2>
                                <p class="text-xs sm:text-sm md:text-base lg:text-lg font-medium leading-relaxed">
                                    Di Surabaya, tepatnya di Pantai Kenjeran, terdapat banyak hasil laut lho! Seperti berbagai jenis cangkang kulit kerang.
                                </p>
                                <p class="text-xs sm:text-sm md:text-base lg:text-lg font-medium leading-relaxed">
                                    Di daerah ini juga terdapat banyak pemasok kulit kerang dengan kualitas yang bagus
                                </p>
                            </div>

                            <!-- STEP 4: Saatnya Berpikir (Karakter: c_berpikir flip mirror) -->
                            <div id="step4" class="step-panel flex-col space-y-3 py-1 text-left">
                                <div class="border-b-2 border-amber-100 pb-2">
                                    <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-[#6D360B] leading-none">
                                        Saatnya Berpikir!
                                    </h2>
                                    <p class="text-xs sm:text-sm text-[#8A4416] font-semibold mt-1">
                                        Bayangkan kamu menjadi pengusaha. Bagaimana memanfaatkan kulit kerang agar menghasilkan uang?
                                    </p>
                                </div>

                                <form id="ideBisnisForm" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-xs sm:text-sm font-bold text-[#6D360B] mb-1" for="ideInput">
                                             1. Ide Produk / Karyamu:
                                        </label>
                                        <textarea id="ideInput" name="ide" rows="2" required 
                                                  placeholder="Contoh: Gantungan kunci kerang, bingkai foto hias, lampu tidur estetik..."
                                                  class="w-full rounded-xl bg-amber-50/40 border-2 border-[#A85D25] p-3 text-xs sm:text-sm text-amber-950 outline-none focus:bg-white focus:border-[#00A3FF] focus:ring-2 focus:ring-sky-200 resize-none font-['Jua'] shadow-inner">{{ $submission->payload['ide'] ?? '' }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block text-xs sm:text-sm font-bold text-[#6D360B] mb-1" for="alasanInput">
                                            2. Alasan Pemilihan Ide:
                                        </label>
                                        <textarea id="alasanInput" name="alasan" rows="2" required 
                                                  placeholder="Jelaskan kenapa produk ini menarik, disukai pembeli, dan bisa menghasilkan keuntungan..."
                                                  class="w-full rounded-xl bg-amber-50/40 border-2 border-[#A85D25] p-3 text-xs sm:text-sm text-amber-950 outline-none focus:bg-white focus:border-[#00A3FF] focus:ring-2 focus:ring-sky-200 resize-none font-['Jua'] shadow-inner">{{ $submission->payload['alasan'] ?? '' }}</textarea>
                                    </div>

                                    <div class="flex justify-end pt-1">
                                        <button type="submit" id="btnSubmitIde"
                                                class="rounded-full border-3 border-white bg-gradient-to-b from-[#4ADE80] via-[#22C55E] to-[#15803D] px-6 py-2 text-white text-sm sm:text-base font-bold shadow-[0_5px_0_#0F5128] hover:brightness-110 active:translate-y-[2px] transition-all flex items-center gap-2 cursor-pointer font-['Jua']">
                                            <span>Kirim Jawaban</span>
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
                     7. SUCCESS MODAL (KAMU HEBAT!) - DIDALAM LANDSCAPE-FORCE
                     ============================================================ -->
                <div id="hebatModal" class="hidden fixed inset-0 z-[10001] flex items-center justify-center p-4 bg-black/65 backdrop-blur-sm select-none font-['Jua']">
                    <div class="relative w-full max-w-md rounded-3xl border-4 border-[#3D1804] p-6 text-center shadow-2xl flex flex-col items-center animate-pop-in"
                         style="background: linear-gradient(180deg, #9E531F 0%, #7E3E11 25%, #9E531F 30%, #6E330C 65%, #8A4416 70%, #522204 100%);">
                        
                        <!-- Karakter C_Jempol -->
                        <div class="mb-1 -mt-2">
                            <img src="{{ asset('assets/c_jempol.webp') }}" alt="Hebat" class="h-32 sm:h-36 md:h-40 w-auto drop-shadow select-none">
                        </div>

                        <h3 class="text-2xl md:text-3xl font-bold text-[#FFF2A6] wood-text-shadow mb-2">
                            Kamu Hebat!
                        </h3>

                        <div class="rounded-2xl border-2 border-[#612A07] bg-[#FFFDF0] p-4 mb-4 text-sm sm:text-base text-[#785135] font-semibold leading-relaxed shadow-inner w-full">
                            Lanjutkan belajar Rencana Keuangan.
                        </div>

                        <div class="flex justify-center w-full">
                            <a href="{{ route('bisnisku', ['unlocked' => 'rencana_keuangan']) }}"
                               onclick="document.getElementById('hebatModal')?.classList.add('hidden')"
                               class="w-full sm:w-auto text-center rounded-full border-2 border-white bg-gradient-to-b from-[#4ADE80] to-[#15803D] px-8 py-2.5 text-sm sm:text-base font-bold text-white shadow hover:brightness-110 active:translate-y-[2px] transition-all">
                                Kembali ke Menu Bisnisku
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ============================================================
                     8. SCRIPT NAVIGASI STEP & GANTI KARAKTER
                     ============================================================ -->
                <script>
            (() => {
                window.currentStep = 1;
                window.totalSteps = 4;

                window.stepCharacters = {
                    1: { src: "{{ asset('assets/c_kerang.webp') }}", flip: false },
                    2: { src: "{{ asset('assets/c_aksesoris.webp') }}", flip: false },
                    3: { src: "{{ asset('assets/c_menyapa.webp') }}", flip: false },
                    4: { src: "{{ asset('assets/c_berpikir.webp') }}", flip: true }
                };

                window.updateStepUI = function() {
                    // Update Step Number
                    const stepNumEl = document.getElementById('currentStepNum');
                    if (stepNumEl) stepNumEl.textContent = window.currentStep;

                    // Update Active Panel
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

                    // Update Character Image & Flip Mirror
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

                    // Update Button Visibility: btnNext hidden on Step 4
                    const btnNext = document.getElementById('btnNext');
                    if (btnNext) {
                        if (window.currentStep === window.totalSteps) {
                            btnNext.style.display = 'none';
                        } else {
                            btnNext.style.display = 'block';
                        }
                    }

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

                    const next = window.currentStep + direction;
                    if (next >= 1 && next <= window.totalSteps) {
                        window.currentStep = next;
                        window.updateStepUI();
                    }
                };

                function initIdeBisnis() {
                    window.updateStepUI();

                    const formIde = document.getElementById('ideBisnisForm');
                    if (formIde && !formIde.dataset.bound) {
                        formIde.dataset.bound = "true";
                        formIde.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const btn = document.getElementById('btnSubmitIde');
                            btn.disabled = true;
                            btn.innerHTML = "<span>Menyimpan...</span>";

                            const ide = document.getElementById('ideInput').value;
                            const alasan = document.getElementById('alasanInput').value;
                            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

                            try {
                                const res = await fetch("{{ route('bisnisku.ide-bisnis.submit') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ ide, alasan })
                                });

                                const data = await res.json();
                                if (data.status === 'success') {
                                    document.getElementById('hebatModal')?.classList.remove('hidden');
                                } else {
                                    alert(data.message || 'Terjadi kesalahan');
                                }
                            } catch (err) {
                                alert('Gagal mengirim data. Periksa koneksi internetmu.');
                            } finally {
                                btn.disabled = false;
                                btn.innerHTML = `<span>Kirim Jawaban</span>`;
                            }
                        });
                    }
                }

                // Run immediately and also on DOMContentLoaded
                initIdeBisnis();
                document.addEventListener('DOMContentLoaded', initIdeBisnis);
            })();
        </script>
            </div>
        </div>
    </body>
</html>
