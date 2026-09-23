<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Rencana Keuangan - SABI</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Preload Important Assets for Instant Switching -->
        <link rel="preload" as="image" href="{{ asset('assets/c_ide.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_menyapa.webp') }}">
        <link rel="preload" as="image" href="{{ asset('assets/c_kerang.webp') }}">
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

            .drop-slot.drag-over {
                border-color: #2D7BFF;
                background-color: #EFF6FF;
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
                    <img src="{{ asset('assets/rencanakeuangan.webp') }}" 
                         alt="Rencana Keuangan" 
                         class="h-20 sm:h-24 md:h-32 lg:h-36 xl:h-40 w-auto drop-shadow-xl animate-banner-float select-none pointer-events-none">
                </div>

                <!-- Tombol & Modal Pengaturan Suara di Pojok Kanan Atas -->
                <x-sound-settings />

                <!-- ============================================================
                     4. KARAKTER DI SISI KIRI BAWAH (Step 1 = c_ide.png)
                     ============================================================ -->
                <div class="absolute z-20 pointer-events-none -bottom-[75px] sm:-bottom-[85px] md:-bottom-[100px] left-[-35px] sm:left-[-20px] md:left-[10px] lg:left-[25px]">
                    <div class="animate-char-idle pointer-events-none">
                        <img id="charDisplay" 
                             src="{{ asset('assets/c_ide.webp') }}" 
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
                        <div class="bg-white rounded-[24px] sm:rounded-[30px] md:rounded-[36px] border-4 border-white p-2.5 sm:p-3.5 md:p-4 bubble-card-shadow max-h-[62vh] sm:max-h-[66vh] overflow-y-auto">
                            
                            <!-- STEP 1: Pembukaan (Karakter: c_ide) -->
                            <div id="step1" class="step-panel active flex-col items-center justify-center text-center py-6 px-2 sm:px-6">
                                <p class="text-base sm:text-xl md:text-2xl lg:text-3xl text-[#785135] font-bold leading-relaxed max-w-2xl">
                                    Pada kegiatan ini kamu akan belajar mengatur pengelolaan uang sesuai kebutuhan agar usahamu bisa memperoleh keuntungan.
                                </p>
                            </div>

                            <!-- STEP 2: Video Pembelajaran (Karakter: c_menyapa) -->
                            <div id="step2" class="step-panel flex-col items-center space-y-3 py-1 px-1 sm:px-3 text-center">
                                <div class="w-full max-w-xl aspect-video rounded-2xl overflow-hidden bg-slate-900 border-2 border-slate-300 shadow-md flex items-center justify-center relative mx-auto">
                                    <iframe id="learningVideo" 
                                        class="w-full h-full rounded-2xl" 
                                        src="https://www.youtube-nocookie.com/embed/uvLOiqN2Geo?rel=0&modestbranding=1&enablejsapi=1" 
                                        title="Video Pembelajaran Rencana Keuangan" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <p class="text-xs sm:text-sm md:text-base text-[#785135] font-medium leading-relaxed max-w-xl mx-auto">
                                    Sebagai seorang pengusaha kamu harus menggunakan uang dengan bijak. Belanjakan sesuai kebutuhan agar usahamu bisa lancar dan mendapatkan untung.
                                </p>
                            </div>

                            <!-- STEP 3: Game Atur Belanjamu (Karakter: c_kerang) -->
                            <div id="step3" class="step-panel flex-col space-y-2 text-left w-full">
                                <!-- Top Row: 2 Header Boxes (Compact & Wide) -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 sm:gap-2.5 items-stretch">
                                    
                                    <!-- Top Left Box -->
                                    <div class="flex flex-col space-y-1">
                                        <div class="flex items-center gap-1.5 sm:gap-2">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#D97706] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                                <path d="M9 12h6"></path>
                                                <path d="M9 16h6"></path>
                                                <path d="M9 8h6"></path>
                                            </svg>
                                            <h2 class="text-base sm:text-lg md:text-xl font-extrabold text-[#6D360B] tracking-tight">
                                                Atur Belanjamu!
                                            </h2>
                                        </div>
                                        <div class="rounded-xl border-2 border-[#F6C343] bg-[#FFF8EB] px-2.5 py-1.5 text-xs sm:text-[13px] font-bold text-[#785135] leading-snug shadow-sm">
                                            Ayo tariklah 3 kartu kebutuhan utama dan <span class="text-[#E65100] font-black">pendukung</span> untuk melakukan satu kali produksi kerajinan kulit kerangmu pada tempat yang tersedia!
                                        </div>
                                    </div>

                                    <!-- Top Right Box -->
                                    <div class="rounded-xl border-2 border-[#F6C343] bg-[#FFF8EB] px-2.5 py-1.5 flex flex-col justify-between shadow-sm">
                                        <div class="flex items-center gap-2 pb-1 border-b border-[#F6C343]">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                                                <circle cx="12" cy="12" r="2"></circle>
                                                <path d="M6 12h.01M18 12h.01"></path>
                                            </svg>
                                            <span class="text-xs sm:text-[13px] font-black text-[#6D360B]">Modal Awal = Rp1.000.000</span>
                                        </div>
                                        <div class="flex items-center gap-2 pt-1">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#EAB308] fill-[#FACC15] shrink-0 drop-shadow-sm" viewBox="0 0 24 24">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-black text-[#65A30D]">Kabar baik!</span>
                                                <span class="text-[11px] sm:text-xs font-bold text-[#785135]">
                                                    Uang modalmu Rp1.000.000 & sudah memiliki alat utama kerajinan.
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Bottom Row: 2 Main Interactive Columns (Wide & No Scroll) -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5 sm:gap-3.5 items-stretch pt-0.5">
                                    
                                    <!-- Left Column: Pilihan -->
                                    <div class="relative rounded-2xl border-2 border-[#208DEB] p-2 sm:p-2.5 pt-3.5 bg-white shadow-sm flex flex-col justify-between"
                                         id="pilihanZone" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDropToPilihan(event)">
                                        <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 px-4 py-0.5 rounded-full bg-[#208DEB] text-white text-[11px] sm:text-xs font-black shadow">
                                            Pilihan
                                        </div>
                                        <div id="availableContainer" class="space-y-1 sm:space-y-1.5 flex-1">
                                            @foreach($items as $item)
                                                <div id="item-{{ $item->id }}" draggable="true" ondragstart="dragStart(event, {{ $item->id }}, 'pilihan')" onclick="toggleSelectItem({{ $item->id }})"
                                                    data-id="{{ $item->id }}" data-price="{{ $item->price }}" data-name="{{ $item->name }}"
                                                    class="spending-item cursor-pointer py-1 px-2 sm:py-1.5 sm:px-2.5 rounded-xl bg-white border border-slate-200 hover:border-[#208DEB] hover:shadow-md active:scale-[0.98] transition-all flex items-center justify-between gap-2 select-none">
                                                    
                                                    <!-- Item Icon Container -->
                                                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 border border-slate-200">
                                                        @if(str_contains(strtolower($item->name), 'mesin'))
                                                            <svg class="w-4 h-4 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <rect x="2" y="6" width="20" height="14" rx="2"></rect>
                                                                <path d="M6 10h4v6H6z"></path>
                                                                <circle cx="16" cy="13" r="2"></circle>
                                                                <path d="M12 2v4"></path>
                                                            </svg>
                                                        @elseif(str_contains(strtolower($item->name), 'artis'))
                                                            <svg class="w-4 h-4 text-pink-600 fill-pink-100" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                            </svg>
                                                        @elseif(str_contains(strtolower($item->name), 'kerang'))
                                                            <svg class="w-4 h-4 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                                            </svg>
                                                        @elseif(str_contains(strtolower($item->name), 'pegawai'))
                                                            <svg class="w-4 h-4 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                                <circle cx="9" cy="7" r="4"></circle>
                                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-4 h-4 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                                                <path d="M9 7h6"></path>
                                                                <path d="M9 11h6"></path>
                                                            </svg>
                                                        @endif
                                                    </div>

                                                    <span class="text-[11px] sm:text-xs md:text-[13px] font-bold text-slate-800 leading-snug flex-1">{{ $item->name }}</span>
                                                    <span class="px-2 py-0.5 sm:px-2.5 sm:py-0.5 rounded-lg bg-[#208DEB] text-white text-[11px] sm:text-xs md:text-[13px] font-black shrink-0 shadow-sm">
                                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Right Column: Tempat -->
                                    <div class="relative rounded-2xl border-2 border-[#70B31E] p-2 sm:p-2.5 pt-3.5 bg-white shadow-sm flex flex-col justify-between">
                                        <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 px-4 py-0.5 rounded-full bg-[#70B31E] text-white text-[11px] sm:text-xs font-black shadow">
                                            Tempat
                                        </div>
                                        <div id="targetDropZone" ondragover="allowDrop(event)" ondragleave="dragLeave(event)" ondrop="handleDrop(event)"
                                             class="drop-slot rounded-xl border-2 border-dashed border-[#70B31E] p-1.5 sm:p-2 min-h-[160px] sm:min-h-[175px] flex flex-col justify-between bg-[#F8FCF3]/40">
                                            
                                            <div id="selectedSlotsContainer" class="space-y-1 sm:space-y-1.5 flex-1">
                                                <p id="emptySlotsHint" class="text-xs text-slate-400 text-center py-6 font-medium">
                                                    Tarik atau klik 3 kartu pilihan ke sini
                                                </p>
                                            </div>

                                            <div class="pt-1 border-t border-[#D9ECC2] flex items-center justify-between text-xs mt-0.5">
                                                <span class="font-bold text-slate-600">Total Pengeluaran:</span>
                                                <span id="totalSelectedCost" class="font-black text-[#6D360B] text-xs sm:text-sm">Rp 0</span>
                                            </div>
                                        </div>

                                        <button type="button" id="btnCheckGame" onclick="submitGameCheck()"
                                            class="w-full mt-1.5 rounded-full border-2 border-white bg-gradient-to-b from-[#208DEB] to-[#0D6EFD] py-1.5 sm:py-2 px-4 text-white text-xs sm:text-sm font-bold shadow-[0_3px_0_#0B5ED7] hover:brightness-110 active:translate-y-[2px] transition-all flex items-center justify-center gap-1.5 cursor-pointer font-['Jua']">
                                            <span>Periksa Pilihan Belanja</span>
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <!-- STEP 4: Menghitung Sisa Modal (Karakter: c_berpikir) -->
                            <div id="step4" class="step-panel flex-col space-y-3.5 py-1 text-left">
                                <div class="border-b-2 border-amber-100 pb-2">
                                    <h3 class="text-lg sm:text-2xl font-bold text-[#6D360B] leading-snug">
                                        Tahap Perhitungan Modal
                                    </h3>
                                    <p class="text-xs sm:text-sm md:text-base text-[#8A4416] font-semibold mt-0.5">
                                        Yuk, hitung berapa sisa modal usahamu setelah belanja kebutuhan produksi yang telah dipilih!
                                    </p>
                                </div>

                                <div class="max-w-xl mx-auto w-full space-y-3.5">
                                    <div class="grid grid-cols-2 gap-3.5">
                                        <div class="p-3 sm:p-3.5 rounded-2xl bg-amber-50 border-2 border-amber-200 text-center">
                                            <span class="text-xs sm:text-sm text-slate-600 font-bold block">Modal Awal:</span>
                                            <span class="text-sm sm:text-lg font-black text-[#6D360B]">Rp1.000.000</span>
                                        </div>
                                        <div class="p-3 sm:p-3.5 rounded-2xl bg-sky-50 border-2 border-sky-200 text-center">
                                            <span class="text-xs sm:text-sm text-slate-600 font-bold block">Total Pengeluaran:</span>
                                            <span class="text-sm sm:text-lg font-black text-[#0077B6]">Rp700.000</span>
                                        </div>
                                    </div>

                                    <form id="hitungModalForm" class="p-4 rounded-2xl bg-amber-50/40 border-2 border-[#A85D25] space-y-3.5 shadow-inner">
                                        @csrf
                                        <label class="block text-xs sm:text-sm md:text-base font-bold text-[#6D360B]" for="inputSisaModal">
                                            Berapa sisa modal usahamu? (Modal Awal - Total Pengeluaran)
                                        </label>

                                        <div class="relative">
                                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-black text-slate-500 text-sm sm:text-base">Rp</span>
                                            <input id="inputSisaModal" type="text" required placeholder=""
                                                class="w-full h-11 rounded-xl bg-white border-2 border-[#A85D25] pl-11 pr-4 text-sm sm:text-base font-bold text-[#6D360B] outline-none focus:border-[#00A3FF] focus:ring-2 focus:ring-sky-200 font-['Jua']">
                                        </div>

                                        <button type="submit" id="btnSubmitModal"
                                            class="w-full rounded-full border-2 border-white bg-gradient-to-b from-[#4ADE80] to-[#15803D] py-2.5 text-white text-xs sm:text-sm md:text-base font-bold shadow-[0_3px_0_#0F5128] hover:brightness-110 active:translate-y-[2px] transition-all flex items-center justify-center gap-2 cursor-pointer font-['Jua']">
                                            <span>Kirim Jawaban</span>
                                        </button>
                                    </form>
                                </div>

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
                     7. SUCCESS / FEEDBACK MODAL
                     ============================================================ -->
                <div id="gameModal" class="hidden fixed inset-0 z-[10001] flex items-center justify-center p-4 bg-black/65 backdrop-blur-sm select-none font-['Jua']">
            <div class="relative w-full max-w-md rounded-3xl border-4 border-[#3D1804] p-6 text-center shadow-2xl flex flex-col items-center"
                 style="background: linear-gradient(180deg, #9E531F 0%, #7E3E11 25%, #9E531F 30%, #6E330C 65%, #8A4416 70%, #522204 100%);">
                
                <div id="modalIconContainer" class="mb-1 -mt-2"></div>

                <h3 id="modalTitle" class="text-2xl md:text-3xl font-bold text-[#FFF2A6] wood-text-shadow mb-2"></h3>
                <p id="modalMessage" class="rounded-2xl border-2 border-[#612A07] bg-[#FFFDF0] p-4 mb-4 text-sm sm:text-base text-[#785135] font-semibold leading-relaxed shadow-inner w-full"></p>

                <div id="modalButtons" class="flex justify-center w-full"></div>
            </div>
        </div>

        <!-- ============================================================
             8. SCRIPT NAVIGASI STEP, GAME & PERHITUNGAN
             ============================================================ -->
        <script>
            (() => {
                window.currentStep = 1;
                window.totalSteps = 4;
                window.selectedItems = [];
                window.isGamePassed = {{ ($gameSubmission && !empty($gameSubmission->payload['total_spending'])) ? 'true' : 'false' }};

                window.stepCharacters = {
                    1: { src: "{{ asset('assets/c_ide.webp') }}", flip: false },
                    2: { src: "{{ asset('assets/c_menyapa.webp') }}", flip: false },
                    3: { src: "{{ asset('assets/c_berpikir.webp') }}", flip: true },
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

                    // Pause video if not on step 2
                    const vid = document.getElementById('learningVideo');
                    if (vid && window.currentStep !== 2) {
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

                    // Update Next Button Visibility: Hidden on Step 4
                    const btnNext = document.getElementById('btnNext');
                    if (btnNext) {
                        if (window.currentStep === window.totalSteps) {
                            btnNext.style.display = 'none';
                        } else {
                            btnNext.style.display = 'block';
                        }
                    }

                    // Prev Button is always displayed
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

                    // Cegah lanjut ke Step 4 jika Game di Step 3 belum dijawab benar
                    if (direction === 1 && window.currentStep === 3 && !window.isGamePassed) {
                        window.showGameFeedbackModal(false, 'Maaf, jawaban kurang tepat atau belum selesai! Pilihlah 3 kebutuhan produksi yang tepat dan klik "Periksa Pilihan Belanja" terlebih dahulu.');
                        return;
                    }

                    const next = window.currentStep + direction;
                    if (next >= 1 && next <= window.totalSteps) {
                        window.currentStep = next;
                        window.updateStepUI();
                    }
                };

                window.getItemIconHtml = function(name) {
                    const n = (name || '').toLowerCase();
                    if (n.includes('mesin')) {
                        return `<svg class="w-5 h-5 text-slate-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="14" rx="2"></rect>
                            <path d="M6 10h4v6H6z"></path>
                            <circle cx="16" cy="13" r="2"></circle>
                            <path d="M12 2v4"></path>
                        </svg>`;
                    }
                    if (n.includes('artis')) {
                        return `<svg class="w-5 h-5 text-pink-600 fill-pink-100" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>`;
                    }
                    if (n.includes('kerang')) {
                        return `<svg class="w-5 h-5 text-amber-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>`;
                    }
                    if (n.includes('pegawai')) {
                        return `<svg class="w-5 h-5 text-sky-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>`;
                    }
                    return `<svg class="w-5 h-5 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="5" y="2" width="14" height="20" rx="2"></rect>
                        <line x1="12" y1="18" x2="12.01" y2="18"></line>
                        <path d="M9 7h6"></path>
                        <path d="M9 11h6"></path>
                    </svg>`;
                };

                // Global Drag & Touch State
                window.currentDraggedId = null;
                window.currentDraggedSource = 'pilihan';

                // HTML5 Native Drag & Drop Handling
                window.dragStart = function(e, id, source = 'pilihan') {
                    window.currentDraggedId = id;
                    window.currentDraggedSource = source;
                    if (e.dataTransfer) {
                        e.dataTransfer.effectAllowed = 'copyMove';
                        e.dataTransfer.setData('text/plain', String(id));
                        try {
                            e.dataTransfer.setData('application/json', JSON.stringify({ id: id, source: source }));
                        } catch (err) {}
                    }
                };

                window.allowDrop = function(e) {
                    e.preventDefault();
                    if (e.dataTransfer) {
                        e.dataTransfer.dropEffect = 'copy';
                    }
                    const dropZone = document.getElementById('targetDropZone');
                    if (dropZone) dropZone.classList.add('bg-lime-100/70', 'border-lime-500');
                };

                window.dragLeave = function(e) {
                    const dropZone = document.getElementById('targetDropZone');
                    if (dropZone) dropZone.classList.remove('bg-lime-100/70', 'border-lime-500');
                };

                window.handleDrop = function(e) {
                    e.preventDefault();
                    const dropZone = document.getElementById('targetDropZone');
                    if (dropZone) dropZone.classList.remove('bg-lime-100/70', 'border-lime-500');

                    let id = window.currentDraggedId;
                    if (!id && e.dataTransfer) {
                        const raw = e.dataTransfer.getData('text/plain');
                        if (raw) {
                            try {
                                const parsed = JSON.parse(raw);
                                id = parsed.id || parsed;
                            } catch {
                                id = parseInt(raw, 10);
                            }
                        }
                    }
                    if (id) {
                        window.addItemToSlots(parseInt(id, 10));
                    }
                    window.currentDraggedId = null;
                };

                window.handleDropToPilihan = function(e) {
                    e.preventDefault();
                    let id = window.currentDraggedId;
                    if (!id && e.dataTransfer) {
                        const raw = e.dataTransfer.getData('text/plain');
                        if (raw) {
                            try {
                                const parsed = JSON.parse(raw);
                                id = parsed.id || parsed;
                            } catch {
                                id = parseInt(raw, 10);
                            }
                        }
                    }
                    if (id && window.selectedItems.includes(parseInt(id, 10))) {
                        window.removeItemFromSlots(parseInt(id, 10));
                    }
                    window.currentDraggedId = null;
                };

                // Touch Drag Support for Mobile & Tablets
                let touchDragClone = null;
                let touchDraggedId = null;
                let touchDraggedSource = null;

                function initTouchDrag() {
                    const itemsContainer = document.getElementById('step3');
                    if (!itemsContainer || itemsContainer.dataset.touchInit) return;
                    itemsContainer.dataset.touchInit = "true";

                    document.addEventListener('touchstart', function(e) {
                        const itemEl = e.target.closest('.spending-item');
                        if (!itemEl) return;

                        const id = parseInt(itemEl.dataset.id || itemEl.id?.replace('item-', ''), 10);
                        if (!id || isNaN(id)) return;

                        touchDraggedId = id;
                        touchDraggedSource = itemEl.closest('#selectedSlotsContainer') ? 'tempat' : 'pilihan';

                        const touch = e.touches[0];
                        touchDragClone = itemEl.cloneNode(true);
                        touchDragClone.style.position = 'fixed';
                        touchDragClone.style.zIndex = '99999';
                        touchDragClone.style.pointerEvents = 'none';
                        touchDragClone.style.opacity = '0.85';
                        touchDragClone.style.transform = 'scale(1.05)';
                        touchDragClone.style.width = itemEl.offsetWidth + 'px';
                        touchDragClone.style.left = (touch.clientX - itemEl.offsetWidth / 2) + 'px';
                        touchDragClone.style.top = (touch.clientY - 25) + 'px';
                        document.body.appendChild(touchDragClone);
                    }, { passive: true });

                    document.addEventListener('touchmove', function(e) {
                        if (!touchDragClone) return;
                        const touch = e.touches[0];
                        touchDragClone.style.left = (touch.clientX - touchDragClone.offsetWidth / 2) + 'px';
                        touchDragClone.style.top = (touch.clientY - 25) + 'px';

                        const targetZone = document.getElementById('targetDropZone');
                        if (targetZone) {
                            const rect = targetZone.getBoundingClientRect();
                            const isOver = (touch.clientX >= rect.left && touch.clientX <= rect.right &&
                                            touch.clientY >= rect.top && touch.clientY <= rect.bottom);
                            if (isOver) {
                                targetZone.classList.add('bg-lime-100/70', 'border-lime-500');
                            } else {
                                targetZone.classList.remove('bg-lime-100/70', 'border-lime-500');
                            }
                        }
                    }, { passive: true });

                    document.addEventListener('touchend', function(e) {
                        if (touchDragClone) {
                            touchDragClone.remove();
                            touchDragClone = null;
                        }

                        const targetZone = document.getElementById('targetDropZone');
                        if (targetZone) targetZone.classList.remove('bg-lime-100/70', 'border-lime-500');

                        if (!touchDraggedId) return;

                        const touch = e.changedTouches[0];
                        const dropTarget = document.elementFromPoint(touch.clientX, touch.clientY);
                        
                        if (dropTarget) {
                            const isOverTempat = dropTarget.closest('#targetDropZone') || dropTarget.closest('#selectedSlotsContainer');
                            const isOverPilihan = dropTarget.closest('#pilihanZone') || dropTarget.closest('#availableContainer');

                            if (isOverTempat && touchDraggedSource === 'pilihan') {
                                window.addItemToSlots(touchDraggedId);
                            } else if (isOverPilihan && touchDraggedSource === 'tempat') {
                                window.removeItemFromSlots(touchDraggedId);
                            }
                        }

                        touchDraggedId = null;
                        touchDraggedSource = null;
                    }, { passive: true });
                }

                window.toggleSelectItem = function(id) {
                    if (window.selectedItems.includes(id)) {
                        window.removeItemFromSlots(id);
                    } else {
                        window.addItemToSlots(id);
                    }
                };

                window.addItemToSlots = function(id) {
                    if (window.selectedItems.includes(id)) return;
                    if (window.selectedItems.length >= 3) {
                        window.showGameFeedbackModal(false, 'Maksimal 3 pilihan kebutuhan pengeluaran! Klik kartu di Tempat untuk membatalkan pilihan.');
                        return;
                    }
                    window.selectedItems.push(id);
                    window.renderSelectedSlots();
                };

                window.removeItemFromSlots = function(id) {
                    window.selectedItems = window.selectedItems.filter(item => item !== id);
                    window.renderSelectedSlots();
                };

                window.resetGameSlots = function() {
                    window.selectedItems = [];
                    window.renderSelectedSlots();
                };

                window.renderSelectedSlots = function() {
                    const container = document.getElementById('selectedSlotsContainer');
                    let total = 0;

                    if (!container) return;
                    container.innerHTML = '';

                    // Update visual styles of available items: hide when selected in Tempat
                    document.querySelectorAll('#availableContainer .spending-item').forEach(el => {
                        const id = parseInt(el.dataset.id, 10);
                        if (window.selectedItems.includes(id)) {
                            el.classList.add('hidden');
                        } else {
                            el.classList.remove('hidden');
                        }
                    });

                    if (window.selectedItems.length === 0) {
                        container.innerHTML = `
                            <p id="emptySlotsHint" class="text-xs sm:text-sm text-slate-400 text-center py-8 sm:py-10 font-medium">
                                Tarik atau klik 3 kartu pilihan ke sini
                            </p>
                        `;
                        const costEl = document.getElementById('totalSelectedCost');
                        if (costEl) costEl.textContent = 'Rp 0';
                        return;
                    }

                    window.selectedItems.forEach(id => {
                        const el = document.getElementById(`item-${id}`);
                        if (!el) return;

                        const price = parseInt(el.dataset.price, 10) || 0;
                        const name = el.dataset.name || '';
                        total += price;

                        const slotCard = document.createElement('div');
                        slotCard.className = 'spending-item cursor-pointer py-1 px-2 sm:py-1.5 sm:px-2.5 rounded-xl bg-white border-2 border-[#70B31E] shadow-sm hover:border-rose-400 hover:bg-rose-50/30 active:scale-[0.98] transition-all flex items-center justify-between gap-2 select-none';
                        slotCard.setAttribute('draggable', 'true');
                        slotCard.dataset.id = String(id);
                        slotCard.dataset.name = name;
                        slotCard.dataset.price = String(price);
                        slotCard.ondragstart = (e) => window.dragStart(e, id, 'tempat');
                        slotCard.onclick = () => window.removeItemFromSlots(id);
                        slotCard.title = 'Klik untuk mengembalikan kartu ke Pilihan';
                        slotCard.innerHTML = `
                            <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-slate-100 flex items-center justify-center shrink-0 border border-slate-200 pointer-events-none">
                                ${window.getItemIconHtml(name)}
                            </div>
                            <span class="text-[11px] sm:text-xs md:text-[13px] font-bold text-slate-800 leading-snug flex-1 pointer-events-none">${name}</span>
                            <span class="px-2 py-0.5 sm:px-2.5 sm:py-0.5 rounded-lg bg-[#208DEB] text-white text-[11px] sm:text-xs md:text-[13px] font-black shrink-0 shadow-sm pointer-events-none">
                                Rp ${price.toLocaleString('id-ID')}
                            </span>
                        `;
                        container.appendChild(slotCard);
                    });

                    const costEl = document.getElementById('totalSelectedCost');
                    if (costEl) costEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
                };

                window.submitGameCheck = async function() {
                    if (window.selectedItems.length !== 3) {
                        window.showGameFeedbackModal(false, 'Maaf, jawaban kurang tepat, coba lagi! Pilihlah tepat 3 kebutuhan pengeluaran untuk produksi.');
                        return;
                    }

                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                    try {
                        const res = await fetch("{{ route('bisnisku.rencana-keuangan.game') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ selected_ids: window.selectedItems })
                        });

                        const data = await res.json();
                        if (data.is_correct) {
                            window.isGamePassed = true;
                        }
                        window.showGameFeedbackModal(data.is_correct, data.message);
                    } catch (err) {
                        window.showGameFeedbackModal(false, 'Gagal memeriksa jawaban. Silakan coba lagi.');
                    }
                };

                window.showGameFeedbackModal = function(isCorrect, message) {
                    const modal = document.getElementById('gameModal');
                    const iconContainer = document.getElementById('modalIconContainer');
                    const title = document.getElementById('modalTitle');
                    const msg = document.getElementById('modalMessage');
                    const buttons = document.getElementById('modalButtons');

                    if (isCorrect) {
                        iconContainer.innerHTML = `<img src="{{ asset('assets/c_jempol.webp') }}" alt="Benar" class="h-32 sm:h-36 w-auto drop-shadow select-none">`;
                        title.textContent = "Kamu Hebat!";
                        msg.textContent = message || "Kamu hebat! Pilihan belanjamu sangat bijak dan sesuai dengan kebutuhan usaha kerajinan kerang.";
                        buttons.innerHTML = `
                            <button type="button" onclick="window.closeModalAndGoToStep(4)" class="rounded-full border-3 border-white bg-gradient-to-b from-[#4ADE80] via-[#22C55E] to-[#15803D] px-8 py-2.5 text-white font-bold text-sm sm:text-base tracking-wide shadow-[0_5px_0_#0F5128] hover:brightness-110 active:translate-y-[2px] transition-all cursor-pointer font-['Jua']">
                                Lanjut Hitung Sisa Modal
                            </button>
                        `;
                    } else {
                        iconContainer.innerHTML = `<img src="{{ asset('assets/c_berpikir.webp') }}" alt="Kurang Tepat" class="h-32 sm:h-36 w-auto drop-shadow select-none">`;
                        title.textContent = "Maaf, Jawaban Kurang Tepat!";
                        msg.textContent = message || "Maaf, jawaban kurang tepat, coba lagi!";
                        buttons.innerHTML = `
                            <button type="button" onclick="window.closeGameModal()" class="rounded-full border-3 border-white bg-gradient-to-b from-[#EF4444] via-[#DC2626] to-[#B91C1C] px-8 py-2.5 text-white font-bold text-sm sm:text-base tracking-wide shadow-[0_5px_0_#7F1D1D] hover:brightness-110 active:translate-y-[2px] transition-all cursor-pointer font-['Jua']">
                                Coba Lagi
                            </button>
                        `;
                    }

                    modal.classList.remove('hidden');
                };

                window.closeGameModal = function() {
                    document.getElementById('gameModal')?.classList.add('hidden');
                };

                window.closeModalAndGoToStep = function(step) {
                    window.closeGameModal();
                    window.currentStep = step;
                    window.updateStepUI();
                };

                function initRencanaKeuangan() {
                    window.updateStepUI();
                    initTouchDrag();

                    // Step 4: Hitung Modal Form
                    const formModal = document.getElementById('hitungModalForm');
                    if (formModal && !formModal.dataset.bound) {
                        formModal.dataset.bound = "true";
                        formModal.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const btn = document.getElementById('btnSubmitModal');
                            btn.disabled = true;
                            btn.innerHTML = "<span>Menyimpan...</span>";

                            const answer = document.getElementById('inputSisaModal').value;
                            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

                            try {
                                const res = await fetch("{{ route('bisnisku.rencana-keuangan.hitung-modal') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ answer })
                                });

                                const data = await res.json();
                                const modal = document.getElementById('gameModal');
                                const iconContainer = document.getElementById('modalIconContainer');
                                const title = document.getElementById('modalTitle');
                                const msg = document.getElementById('modalMessage');
                                const buttons = document.getElementById('modalButtons');

                                if (data.is_correct) {
                                    iconContainer.innerHTML = `<img src="{{ asset('assets/c_jempol.webp') }}" alt="Hebat" class="h-32 sm:h-36 w-auto drop-shadow select-none">`;
                                    title.textContent = "Kamu Hebat!";
                                    msg.textContent = "Lanjutkan belajar Pengembangan Bisnis.";
                                    buttons.innerHTML = `
                                        <a href="{{ route('bisnisku', ['unlocked' => 'pengembangan_bisnis']) }}" onclick="window.closeGameModal()" class="rounded-full border-3 border-white bg-gradient-to-b from-[#4ADE80] via-[#22C55E] to-[#15803D] px-8 py-2.5 text-white font-bold text-base sm:text-lg tracking-wide shadow-[0_5px_0_#0F5128] hover:brightness-110 active:translate-y-[2px] transition-all font-['Jua'] inline-block text-center">
                                            Lanjut ke Menu Bisnisku
                                        </a>
                                    `;
                                } else {
                                    iconContainer.innerHTML = `<img src="{{ asset('assets/c_berpikir.webp') }}" alt="Belum Tepat" class="h-28 sm:h-32 w-auto drop-shadow select-none">`;
                                    title.textContent = "Maaf Kurang Tepat, Coba Lagi!";
                                    msg.textContent = data.message;
                                    buttons.innerHTML = `
                                        <button type="button" onclick="window.closeGameModal()" class="rounded-full border-3 border-white bg-gradient-to-b from-[#EF4444] via-[#DC2626] to-[#B91C1C] px-8 py-2.5 text-white font-bold text-sm sm:text-base tracking-wide shadow-[0_5px_0_#7F1D1D] hover:brightness-110 active:translate-y-[2px] transition-all cursor-pointer font-['Jua']">
                                            Coba Lagi
                                        </button>
                                    `;
                                }
                                modal.classList.remove('hidden');
                            } catch (err) {
                                alert('Gagal mengirim jawaban.');
                            } finally {
                                btn.disabled = false;
                                btn.innerHTML = `<span>Kirim Jawaban</span>`;
                            }
                        });
                    }
                }

                // Run immediately and on DOMContentLoaded
                initRencanaKeuangan();
                document.addEventListener('DOMContentLoaded', initRencanaKeuangan);
            })();
        </script>
            </div>
        </div>
    </body>
</html>
