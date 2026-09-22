<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>Menu Bisnisku - SABI</title>
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
            

            @keyframes lockShake {
                0%, 100% { transform: rotate(0deg); }
                20%, 60% { transform: rotate(-10deg) scale(1.05); }
                40%, 80% { transform: rotate(10deg) scale(1.05); }
            }

            @keyframes unlockBurst {
                0% {
                    transform: scale(1);
                    opacity: 1;
                }
                50% {
                    transform: scale(1.3) rotate(8deg);
                    opacity: 0.9;
                }
                100% {
                    transform: scale(1.8) rotate(15deg);
                    opacity: 0;
                    visibility: hidden;
                }
            }

            @keyframes popGlow {
                0% {
                    transform: scale(0.96);
                    filter: brightness(0.55) grayscale(100%);
                }
                50% {
                    transform: scale(1.08);
                    filter: brightness(1.2) drop-shadow(0 0 25px rgba(255, 215, 0, 0.8));
                }
                100% {
                    transform: scale(1);
                    filter: none;
                }
            }

            .animate-lock-shake {
                animation: lockShake 0.5s ease-in-out;
            }

            .animate-unlock-burst {
                animation: unlockBurst 0.65s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            }

            .animate-pop-glow {
                animation: popGlow 0.85s ease-out forwards;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-[100dvh] h-[100dvh] overflow-hidden font-['Jua'] select-none">
        @php
            $canIde = true;
            $canRencana = !empty($progress['ide_bisnis']);
            $canPengembangan = !empty($progress['rencana_keuangan']);
            $justUnlockedRencana = (request('unlocked') === 'rencana_keuangan' && $canRencana);
            $justUnlockedPengembangan = (request('unlocked') === 'pengembangan_bisnis' && $canPengembangan);
        @endphp

        
        </div>

        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); background-size: cover; background-position: center;">
                
                <!-- Header Title Banner -->
                <div class="absolute left-0 right-0 -top-2 sm:-top-3 md:-top-4 flex justify-center px-4 z-20 pointer-events-none">
                    <img src="{{ asset('assets/menubisnisku.webp') }}" 
                         alt="Menu Bisnisku" 
                         class="h-20 sm:h-24 md:h-32 lg:h-36 xl:h-40 w-auto drop-shadow-xl animate-banner-float select-none">
                </div>

                <!-- Tombol Kembali di Pojok Kiri Atas -->
                <div class="absolute top-3 left-3 sm:top-4 sm:left-5 md:top-5 md:left-6 z-30">
                    <a href="{{ route('menu') }}" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95 cursor-pointer block" title="Kembali">
                        <img src="{{ asset('assets/left_button.webp') }}" alt="Kembali ke Menu" class="w-11 sm:w-13 md:w-16 h-auto drop-shadow-md pointer-events-none select-none">
                    </a>
                </div>

                <!-- Main Content: 3 Custom Image Buttons -->
                <div class="flex-1 w-full flex items-center justify-center py-2 overflow-visible">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 md:gap-10 lg:gap-14 items-center justify-items-center w-full max-w-6xl mx-auto px-4">
                        
                        <!-- Sub-menu 1: Ide Bisnisku (Selalu Terbuka) -->
                        <div class="w-full flex justify-center">
                            <a href="{{ route('bisnisku.ide-bisnis') }}" data-sfx="hover" class="group transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer block text-center focus:outline-none">
                                <img src="{{ asset('assets/IDE.webp') }}" 
                                     alt="Ide Bisnisku" 
                                     class="w-full max-w-[280px] sm:max-w-[320px] md:max-w-[360px] lg:max-w-[400px] max-h-[58vh] md:max-h-[64vh] h-auto object-contain drop-shadow-[0_12px_24px_rgba(0,0,0,0.3)] group-hover:brightness-105 select-none">
                            </a>
                        </div>

                        <!-- Sub-menu 2: Rencana Keuangan -->
                        <div class="w-full flex justify-center relative">
                            <a id="btnRencanaLink" 
                               href="{{ $canRencana ? route('bisnisku.rencana-keuangan') : 'javascript:void(0)' }}" 
                               @if($canRencana) data-sfx="hover" @endif
                               class="group transition-all duration-300 {{ $canRencana ? 'hover:scale-105 active:scale-95 cursor-pointer' : 'cursor-not-allowed opacity-90' }} block text-center focus:outline-none relative">
                                
                                <img id="btnRencanaImg" 
                                     src="{{ asset('assets/RENCANA.webp') }}" 
                                     alt="Rencana Keuangan" 
                                     class="w-full max-w-[280px] sm:max-w-[320px] md:max-w-[360px] lg:max-w-[400px] max-h-[58vh] md:max-h-[64vh] h-auto object-contain drop-shadow-[0_12px_24px_rgba(0,0,0,0.3)] select-none transition-all duration-700 {{ (!$canRencana || $justUnlockedRencana) ? 'filter grayscale brightness-50 opacity-70' : 'group-hover:brightness-105' }}">
                            </a>

                            <!-- Lock Overlay Rencana Keuangan -->
                            @if(!$canRencana || $justUnlockedRencana)
                            <div id="lockOverlayRencana" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none z-20">
                                <div class="lock-icon-wrap w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-black/65 border-3 border-amber-300 flex items-center justify-center shadow-[0_8px_20px_rgba(0,0,0,0.6)] backdrop-blur-sm transition-all">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-amber-300 drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs sm:text-sm font-bold text-white bg-black/75 px-3.5 py-1 rounded-full border border-amber-200/40 shadow">
                                    Terkunci
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Sub-menu 3: Pengembangan Bisnis -->
                        <div class="w-full flex justify-center relative">
                            <a id="btnPengembanganLink" 
                               href="{{ $canPengembangan ? route('bisnisku.pengembangan-bisnis') : 'javascript:void(0)' }}" 
                               @if($canPengembangan) data-sfx="hover" @endif
                               class="group transition-all duration-300 {{ $canPengembangan ? 'hover:scale-105 active:scale-95 cursor-pointer' : 'cursor-not-allowed opacity-90' }} block text-center focus:outline-none relative">
                                
                                <img id="btnPengembanganImg" 
                                     src="{{ asset('assets/PENGEMBANGAN.webp') }}" 
                                     alt="Pengembangan Bisnis" 
                                     class="w-full max-w-[280px] sm:max-w-[320px] md:max-w-[360px] lg:max-w-[400px] max-h-[58vh] md:max-h-[64vh] h-auto object-contain drop-shadow-[0_12px_24px_rgba(0,0,0,0.3)] select-none transition-all duration-700 {{ (!$canPengembangan || $justUnlockedPengembangan) ? 'filter grayscale brightness-50 opacity-70' : 'group-hover:brightness-105' }}">
                            </a>

                            <!-- Lock Overlay Pengembangan Bisnis -->
                            @if(!$canPengembangan || $justUnlockedPengembangan)
                            <div id="lockOverlayPengembangan" class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none z-20">
                                <div class="lock-icon-wrap w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-black/65 border-3 border-amber-300 flex items-center justify-center shadow-[0_8px_20px_rgba(0,0,0,0.6)] backdrop-blur-sm transition-all">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-amber-300 drop-shadow" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="mt-2 text-xs sm:text-sm font-bold text-white bg-black/75 px-3.5 py-1 rounded-full border border-amber-200/40 shadow">
                                    Terkunci
                                </span>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>

                <script>
            (() => {
                function initBisniskuMenu() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const unlocked = urlParams.get('unlocked');

                    if (unlocked === 'rencana_keuangan') {
                        const lockOverlay = document.getElementById('lockOverlayRencana');
                        const img = document.getElementById('btnRencanaImg');
                        const link = document.getElementById('btnRencanaLink');

                        if (lockOverlay && img && link) {
                            const iconWrap = lockOverlay.querySelector('.lock-icon-wrap');
                            
                            // 1. Shake the lock
                            setTimeout(() => {
                                if (iconWrap) iconWrap.classList.add('animate-lock-shake');
                            }, 300);

                            // 2. Burst / vanish the lock and glow the button to normal color
                            setTimeout(() => {
                                lockOverlay.classList.add('animate-unlock-burst');
                                img.classList.remove('filter', 'grayscale', 'brightness-50', 'opacity-70');
                                img.classList.add('animate-pop-glow');
                                link.href = "{{ route('bisnisku.rencana-keuangan') }}";
                                link.classList.remove('cursor-not-allowed', 'opacity-90');
                                link.classList.add('hover:scale-105', 'active:scale-95', 'cursor-pointer');
                            }, 900);

                            // 3. Cleanup lock element & clean url
                            setTimeout(() => {
                                if (lockOverlay) lockOverlay.remove();
                                window.history.replaceState(null, '', window.location.pathname);
                            }, 1700);
                        }
                    } else if (unlocked === 'pengembangan_bisnis') {
                        const lockOverlay = document.getElementById('lockOverlayPengembangan');
                        const img = document.getElementById('btnPengembanganImg');
                        const link = document.getElementById('btnPengembanganLink');

                        if (lockOverlay && img && link) {
                            const iconWrap = lockOverlay.querySelector('.lock-icon-wrap');
                            
                            setTimeout(() => {
                                if (iconWrap) iconWrap.classList.add('animate-lock-shake');
                            }, 300);

                            setTimeout(() => {
                                lockOverlay.classList.add('animate-unlock-burst');
                                img.classList.remove('filter', 'grayscale', 'brightness-50', 'opacity-70');
                                img.classList.add('animate-pop-glow');
                                link.href = "{{ route('bisnisku.pengembangan-bisnis') }}";
                                link.classList.remove('cursor-not-allowed', 'opacity-90');
                                link.classList.add('hover:scale-105', 'active:scale-95', 'cursor-pointer');
                            }, 900);

                            setTimeout(() => {
                                if (lockOverlay) lockOverlay.remove();
                                window.history.replaceState(null, '', window.location.pathname);
                            }, 1700);
                        }
                    }
                }

                window.initBisniskuMenu = initBisniskuMenu;
                initBisniskuMenu();
                document.addEventListener('DOMContentLoaded', initBisniskuMenu);
            })();
        </script>
            </div>
        </div>
    </body>
</html>
