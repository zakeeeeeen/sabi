<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Menu Utama - SABI</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jua&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

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
               ANIMASI PANTAI, KARAKTER & KAPAL LAUT
               ============================================================ */
            @keyframes charSlideInLeft {
                0% {
                    opacity: 0;
                    transform: translateX(-140px) translateY(50px) scale(0.9);
                }
                70% {
                    opacity: 1;
                    transform: translateX(12px) translateY(-5px) scale(1.02);
                }
                100% {
                    opacity: 1;
                    transform: translateX(0) translateY(0) scale(1);
                }
            }

            @keyframes charIdleFloat {
                0%, 100% {
                    transform: translateY(0) rotate(0deg);
                }
                50% {
                    transform: translateY(-6px) rotate(-0.8deg);
                }
            }

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

            /* Efek Tombol Kayu */
            .wooden-btn {
                background: linear-gradient(180deg, #A85D25 0%, #8D4715 20%, #A0551E 32%, #75370E 68%, #914B17 74%, #5A2505 100%);
                border: 3.5px solid #3D1804;
                box-shadow: 0 8px 16px rgba(0,0,0,0.35), 0 5px 0 #280E02, inset 0 2px 0 rgba(255,255,255,0.25), inset 0 -2px 0 rgba(0,0,0,0.35);
                transition: all 0.2s ease-in-out;
            }

            .wooden-btn:hover {
                filter: brightness(1.08);
                transform: translateX(-4px) scale(1.02);
                box-shadow: 0 12px 20px rgba(0,0,0,0.4), 0 6px 0 #280E02, inset 0 2px 0 rgba(255,255,255,0.35), inset 0 -2px 0 rgba(0,0,0,0.35);
            }

            .wooden-btn:active {
                transform: translateY(3px) scale(0.99);
                box-shadow: 0 2px 6px rgba(0,0,0,0.4), 0 2px 0 #280E02, inset 0 1px 0 rgba(255,255,255,0.2);
            }

            .wood-text-shadow {
                text-shadow: 2px 2px 0 #3D1804, -2px -2px 0 #3D1804, 2px -2px 0 #3D1804, -2px 2px 0 #3D1804, 0 3px 5px rgba(0,0,0,0.5);
            }

            /* Custom Range Slider */
            input[type=range] {
                -webkit-appearance: none;
                background: transparent;
            }
            input[type=range]:focus {
                outline: none;
            }
            input[type=range]::-webkit-slider-runnable-track {
                width: 100%;
                height: 12px;
                cursor: pointer;
                background: #E2B774;
                border-radius: 9999px;
                border: 2px solid #5A2505;
                box-shadow: inset 0 2px 4px rgba(0,0,0,0.2);
            }
            input[type=range]::-webkit-slider-thumb {
                height: 24px;
                width: 24px;
                border-radius: 50%;
                background: #2D7BFF;
                border: 3px solid #FFFFFF;
                cursor: pointer;
                -webkit-appearance: none;
                margin-top: -7px;
                box-shadow: 0 3px 6px rgba(0,0,0,0.3);
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-[100dvh] h-[100dvh] overflow-hidden font-['Jua'] select-none">
        @php
            $menuBackground = asset('assets/pantai.webp');
        @endphp

        <!-- Loader -->
        
        </div>

        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ $menuBackground }}'); background-size: cover; background-position: center;">
                
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
                <div class="absolute z-10 pointer-events-none"
                     style="top: -40px; left: -180px; transform: scaleX(1);">
                    <div class="animate-tree-sway pointer-events-none">
                        <img src="{{ asset('assets/pohon.webp') }}" 
                             alt="Pohon Kiri" 
                             class="h-[80vh] md:h-[90vh] w-auto max-w-none drop-shadow-md select-none pointer-events-none">
                    </div>
                </div>

                <div class="absolute z-10 pointer-events-none"
                     style="top: -40px; right: -180px; transform: scaleX(-1);">
                    <div class="animate-tree-sway pointer-events-none" style="animation-delay: -3s;">
                        <img src="{{ asset('assets/pohon.webp') }}" 
                             alt="Pohon Kanan (Mirrored)" 
                             class="h-[80vh] md:h-[90vh] w-auto max-w-none drop-shadow-md select-none pointer-events-none">
                    </div>
                </div>

                <!-- ============================================================
                     3. TOP BAR: LOGO SABI (KIRI) & PROFIL / POIN / SETTING (KANAN)
                     ============================================================ -->
                <div class="absolute top-2.5 left-3 sm:top-4 sm:left-5 md:top-5 md:left-6 z-30 flex items-center">
                    <img src="{{ asset('assets/sabi.webp') }}" alt="SABI" class="w-20 sm:w-28 md:w-36 lg:w-44 h-auto drop-shadow-lg transition-transform hover:scale-105 select-none">
                </div>

                <!-- ============================================================
                     3. POJOK KANAN ATAS: TOMBOL PENGATURAN SUARA SAJA
                     ============================================================ -->
                <div class="absolute top-3 right-3 sm:top-4 sm:right-5 md:top-5 md:right-6 z-40">
                    <button type="button" 
                            onclick="openSettingsModal()" 
                            data-sfx="hover" 
                            class="w-9 h-9 sm:w-11 sm:h-11 md:w-12 md:h-12 lg:w-13 lg:h-13 rounded-full bg-gradient-to-b from-[#FFF5B8] to-[#F5C744] border-2 sm:border-3 border-white shadow-[0_6px_14px_rgba(0,0,0,0.22)] flex items-center justify-center transition-transform hover:scale-110 active:scale-95 cursor-pointer text-[#6D360B]"
                            title="Pengaturan Suara">
                        <svg viewBox="0 0 24 24" class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 drop-shadow-sm" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>

                <!-- ============================================================
                     4. KARAKTER C_MENYAPA & CLOUD CHAT (DI SISI KIRI)
                     ============================================================ -->
                <!-- Karakter c_menyapa (Mobile: semula, Desktop: setting pilihan Anda) -->
                <div class="absolute z-20 pointer-events-none animate-char-entrance-left -bottom-[85px] -left-[15px] md:-bottom-[125px] md:left-[100px]">
                    <div class="animate-char-idle">
                        <img src="{{ asset('assets/c_menyapa.webp') }}" 
                             alt="Karakter Menyapa" 
                             class="h-[50vh] md:h-[78vh] w-auto drop-shadow-[0_14px_18px_rgba(0,0,0,0.3)] select-none">
                    </div>
                </div>

                <!-- Cloud Chat Bubble (Mobile: menyesuaikan HP, Desktop: setting pilihan Anda) -->
                <div class="absolute z-30 left-[250px] sm:left-[220px] md:left-[290px] lg:left-[555px] top-[40%] -translate-y-1/2 max-w-[210px] sm:max-w-[260px] md:max-w-[340px] lg:max-w-[555px] pointer-events-auto animate-bubble-float select-none">
                    <div class="relative" style="filter: drop-shadow(-8px 8px 0 #7FBFC9);">
                        <!-- White Speech Bubble Box -->
                        <div class="bg-white rounded-[22px] sm:rounded-[28px] md:rounded-[32px] px-4 sm:px-5 md:px-6 py-3.5 sm:py-4 md:py-4.5 text-left">
                            <p class="text-[#785135] text-xs sm:text-sm md:text-base lg:text-2xl font-['Jua'] leading-snug sm:leading-relaxed tracking-wide">
                                Halo {{ auth()->user()->name ?? 'Teman' }}! Selamat datang di SABI! Yuk, belajar jadi pengusaha hebat dengan cara yang asyik 
                            </p>
                        </div>

                        <!-- Ekor Cloud Chat di Pojok Kiri Bawah mengarah ke Karakter -->
                        <div class="absolute -bottom-3.5 left-4 sm:left-6 w-7 h-5 overflow-visible pointer-events-none">
                            <svg viewBox="0 0 28 20" class="w-full h-full fill-white overflow-visible">
                                <path d="M0,0 L24,0 C16,8 6,15 -10,20 C-2,12 0,6 0,0 Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- ============================================================
                     5. TOMBOL MENU UTAMA (GAMBAR TOMBOL KUSTOM)
                     ============================================================ -->
                <div class="absolute right-[4%] sm:right-[6%] md:right-[8%] lg:right-[10%] xl:right-[12%] top-[53%] -translate-y-1/2 z-30 flex flex-col items-center gap-2.5 sm:gap-3.5 md:gap-4 w-[220px] sm:w-[280px] md:w-[350px] lg:w-[430px] xl:w-[470px]">
                    
                    <!-- 1. Tombol MULAI BISNISKU -->
                    <a href="{{ route('bisnisku') }}" 
                       data-sfx="hover" 
                       class="block w-full transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/mulaibisnisku_button.webp') }}" 
                             alt="Mulai Bisnisku" 
                             class="w-full h-auto drop-shadow-xl select-none pointer-events-none">
                    </a>

                    <!-- 2. Tombol PANDUAN / PETUNJUK -->
                    <a href="{{ route('petunjuk') }}" 
                       data-sfx="hover" 
                       class="block w-full transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/panduan_button.webp') }}" 
                             alt="Panduan" 
                             class="w-full h-auto drop-shadow-xl select-none pointer-events-none">
                    </a>

                    <!-- 3. Tombol TENTANG MEDIA -->
                    <a href="{{ route('page', ['slug' => 'tentang-media']) }}" 
                       data-sfx="hover" 
                       class="block w-full transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/tentang_button.webp') }}" 
                             alt="Tentang Media" 
                             class="w-full h-auto drop-shadow-xl select-none pointer-events-none">
                    </a>

                    <!-- 4. Tombol EXIT (Keluar Web) -->
                    <button type="button" 
                            onclick="handleExitWeb()" 
                            data-sfx="hover" 
                            class="block w-full transition-transform hover:scale-105 active:scale-95 cursor-pointer border-none bg-transparent p-0">
                        <img src="{{ asset('assets/exit_button.webp') }}" 
                             alt="Keluar" 
                             class="w-full h-auto drop-shadow-xl select-none pointer-events-none">
                    </button>

                </div>

                <script>
                    function handleExitWeb() {
                        if (confirm("Apakah kamu yakin ingin keluar dari SABI?")) {
                            try {
                                window.close();
                            } catch (e) {}
                            const logoutForm = document.querySelector('form[action*="logout"]');
                            if (logoutForm) {
                                logoutForm.submit();
                            } else {
                                window.location.href = "{{ url('/') }}";
                            }
                        }
                    }
                </script>

                <!-- ============================================================
                     6. POP-UP MODAL PENGATURAN SUARA (THEME PAPAN KAYU - VECTOR ICONS)
                     ============================================================ -->
                <div id="settingsModal" 
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/65 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300 font-['Jua'] select-none">
                    
                    <!-- Backdrop -->
                    <div class="absolute inset-0" onclick="closeSettingsModal()"></div>

                    <!-- Modal Box Papan Kayu -->
                    <div id="settingsBox" 
                         class="relative z-10 w-full max-w-[420px] transform scale-90 transition-all duration-300 rounded-3xl border-4 border-[#3D1804] px-6 py-6 shadow-[0_20px_40px_rgba(0,0,0,0.5),0_8px_0_#280E02,inset_0_2px_0_rgba(255,255,255,0.25),inset_0_-3px_0_rgba(0,0,0,0.35)]"
                         style="background: linear-gradient(180deg, #9E531F 0%, #7E3E11 25%, #9E531F 30%, #6E330C 65%, #8A4416 70%, #522204 100%);">
                        
                        <!-- Baut Sudut -->
                        <div class="absolute top-3 left-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
                        <div class="absolute top-3 right-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
                        <div class="absolute bottom-3 left-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>
                        <div class="absolute bottom-3 right-3 w-4 h-4 rounded-full bg-gradient-to-br from-[#E6BC7E] to-[#6A3F14] border border-[#3E1A04] shadow-inner flex items-center justify-center text-[10px] text-[#3E1A04] font-black select-none pointer-events-none">✕</div>

                        <!-- Tombol Tutup (X) -->
                        <button type="button" 
                                onclick="closeSettingsModal()" 
                                class="absolute -top-3.5 -right-3.5 w-10 h-10 rounded-full bg-gradient-to-b from-[#EF4444] to-[#B91C1C] hover:from-[#F87171] hover:to-[#DC2626] text-white font-bold text-lg flex items-center justify-center border-2 border-white shadow-[0_4px_8px_rgba(0,0,0,0.3)] transition-transform hover:scale-110 active:scale-95 cursor-pointer z-20">
                            ✕
                        </button>

                        <!-- Header Modal -->
                        <div class="text-center mb-4">
                            <h2 class="text-2xl sm:text-3xl font-bold text-[#FFF2A6] tracking-wide" 
                                style="text-shadow: 2px 2px 0 #3D1804, -2px -2px 0 #3D1804, 2px -2px 0 #3D1804, -2px 2px 0 #3D1804, 0 4px 6px rgba(0,0,0,0.4);">
                                Pengaturan Suara
                            </h2>
                            <p class="text-xs text-[#FFE8A3] font-medium mt-0.5">
                                Atur volume musik latar belakang
                            </p>
                        </div>

                        <!-- Kartu Perkamen Dalam -->
                        <div class="rounded-2xl border-3 border-[#612A07] bg-gradient-to-b from-[#FFFDF0] to-[#FCEEC7] p-4 sm:p-5 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)] space-y-4">
                            
                            <!-- 1. Kontrol Musik Latar (BGM) -->
                            <div class="bg-white/90 border-2 border-[#D49B5B] rounded-xl p-3.5 shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <!-- Clean SVG Music Note Icon -->
                                        <div class="w-7 h-7 rounded-lg bg-amber-100 flex items-center justify-center text-[#B45309] shrink-0 border border-amber-200">
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                            </svg>
                                        </div>
                                        <span class="text-base sm:text-lg font-bold text-[#6D360B]">Musik Latar</span>
                                    </div>
                                    <span id="bgmVolumeVal" class="text-sm sm:text-base font-bold text-[#2D7BFF] bg-sky-50 px-2.5 py-0.5 rounded-lg border border-sky-200 shadow-inner">
                                        60%
                                    </span>
                                </div>

                                <!-- Slider Volume -->
                                <div class="py-1">
                                    <input id="bgmVolumeSlider" type="range" min="0" max="100" value="60" class="w-full cursor-pointer accent-[#00A3FF]">
                                </div>

                                <!-- Tombol Mute / Suara -->
                                <div class="mt-2.5 flex justify-end">
                                    <button id="bgmMuteBtn" type="button" class="px-4 py-1.5 rounded-xl bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-bold flex items-center gap-1.5 shadow transition-all active:scale-95 cursor-pointer">
                                        <span id="bgmMuteIcon" class="flex items-center">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.3">
                                                <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                                <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                                            </svg>
                                        </span>
                                        <span id="bgmMuteLabel">Aktif</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Tombol Simpan & Tutup -->
                            <div class="pt-1">
                                <button type="button" 
                                        onclick="closeSettingsModal()" 
                                        class="w-full rounded-full border-3 border-white/90 bg-gradient-to-b from-[#4ADE80] via-[#22C55E] to-[#15803D] py-2.5 text-white font-bold text-base sm:text-lg tracking-wide shadow-[0_5px_0_#0F5128] hover:brightness-110 active:translate-y-[2px] active:shadow-[0_2px_0_#0F5128] transition-all flex items-center justify-center gap-2 cursor-pointer font-['Jua']">
                                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    <span>Simpan & Selesai</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </body>
</html>
