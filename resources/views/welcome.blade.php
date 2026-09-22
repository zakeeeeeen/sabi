<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full overflow-hidden">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>SABI - Media Pembelajaran Bisnisku</title>
        <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Jua&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

        <script>
            window.__SABI_BGM_URL = "{{ asset('assets/underthesea.mp3') }}";
        </script>

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="antialiased font-['Jua']">
        <!-- GLOBAL PRELOADER LAYAR PENUH (PERSIS SEPERTI MOCKUP) -->
        <div id="globalAppPreloader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-between overflow-hidden select-none bg-cover bg-bottom"
             style="background-image: url('{{ asset('assets/pantai.webp') }}');">
            
            <!-- Top Spacer / Logo SABI -->
            <div class="w-full flex flex-col items-center pt-8 md:pt-12 z-10">
                <img src="{{ asset('assets/sabi.webp') }}" 
                     alt="SABI - Sarana Asyik Kelola Bisnisku!" 
                     class="w-[280px] sm:w-[380px] md:w-[480px] lg:w-[540px] h-auto drop-shadow-xl animate-pulse">
            </div>

            <!-- Center Progress Area (LOADING + PROGRESS BAR) -->
            <div class="flex flex-col items-center justify-center w-full max-w-md sm:max-w-lg px-6 z-10 mb-8 sm:mb-12">
                <div id="loaderText" class="text-[#0084FF] font-black text-2xl sm:text-3xl md:text-4xl tracking-widest mb-3"
                     style="text-shadow: 2.5px 2.5px 0 #fff, -2.5px -2.5px 0 #fff, 2.5px -2.5px 0 #fff, -2.5px 2.5px 0 #fff, 0 4px 10px rgba(0,132,255,0.4);">
                    LOADING
                </div>
                
                <!-- Progress Bar Container (Kapsul Putih Berbingkai) -->
                <div class="w-full h-8 sm:h-10 md:h-12 bg-white/95 rounded-2xl md:rounded-3xl border-3 sm:border-4 border-[#0084FF]/60 p-1 md:p-1.5 shadow-[0_8px_20px_rgba(0,0,0,0.2),inset_0_2px_4px_rgba(0,0,0,0.1)] backdrop-blur-sm overflow-hidden flex items-center">
                    <div id="loaderProgressBar" 
                         class="h-full bg-gradient-to-r from-[#00A3FF] via-[#0084FF] to-[#0066CC] rounded-xl md:rounded-2xl transition-all duration-200 ease-out shadow-[0_2px_6px_rgba(0,132,255,0.6)]"
                         style="width: 0%;"></div>
                </div>
                
                <div id="loaderPercent" class="text-xs sm:text-sm font-bold text-sky-900/80 mt-2">
                    0%
                </div>
            </div>

            <!-- Karakter Kiri Bawah (Membawa Gantungan Kerang) -->
            <div class="absolute -bottom-6 sm:-bottom-8 left-0 sm:left-4 md:left-10 z-20 pointer-events-none">
                <img src="{{ asset('assets/c_kerang.webp') }}" 
                     alt="Karakter Sabiku" 
                     class="h-[48vh] sm:h-[55vh] md:h-[62vh] max-h-[460px] w-auto drop-shadow-[0_12px_20px_rgba(0,0,0,0.3)]">
            </div>
        </div>

        <div class="landscape-force">
            <div data-app-root data-content style="background-image: url('{{ asset('assets/pantai.webp') }}'); visibility: hidden;">
                <livewire:beranda />
            </div>
        </div>

        <script>
            (function() {
                try {
                    sessionStorage.removeItem('app.booted');
                    sessionStorage.removeItem('app.fullscreen.preferred');
                    sessionStorage.removeItem('app.fullscreen.prompted');
                    sessionStorage.removeItem('app.fullscreen.next');
                } catch (e) {}

                var preloader = document.getElementById('globalAppPreloader');
                var bar = document.getElementById('loaderProgressBar');
                var txt = document.getElementById('loaderPercent');
                var root = document.querySelector('[data-app-root]');
                
                var percent = 0;
                var loaderInterval = setInterval(function() {
                    percent += (percent < 70 ? 8 : (percent < 90 ? 4 : 2));
                    if (percent > 95) percent = 95;
                    if (bar) bar.style.width = percent + '%';
                    if (txt) txt.textContent = percent + '%';
                }, 70);

                window.dismissAppPreloader = function() {
                    clearInterval(loaderInterval);
                    if (bar) bar.style.width = '100%';
                    if (txt) txt.textContent = '100%';
                    if (root) root.style.visibility = 'visible';
                    if (preloader) {
                        preloader.style.opacity = '0';
                        preloader.style.transition = 'opacity 350ms ease-out, transform 350ms ease-out';
                        preloader.style.transform = 'scale(1.02)';
                        preloader.style.pointerEvents = 'none';
                        setTimeout(function() {
                            preloader.style.display = 'none';
                        }, 400);
                    }
                };

                // Fallback otomatis: maksimal 2 detik preloader pasti selesai & terbuka
                setTimeout(function() {
                    if (window.dismissAppPreloader) {
                        window.dismissAppPreloader();
                    }
                }, 1800);
            })();
        </script>
        
        @livewireScripts
    </body>
</html>
