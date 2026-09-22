<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

        <title>{{ $title }}</title>
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
            

            @keyframes bannerBobbing {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(6px);
                }
            }
            .animate-banner-float {
                animation: bannerBobbing 3s ease-in-out infinite;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if (($slug ?? '') === 'alat-musik-oklik')
            <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
        @endif
    </head>
    @php
        $mode = request()->query('mode');
        $isAsalUsul = ($slug ?? '') === 'asal-usul';
        $isProfilSeniman = ($slug ?? '') === 'profil-seniman';
        $isTentangMedia = ($slug ?? '') === 'tentang-media';
        $isOklik = ($slug ?? '') === 'alat-musik-oklik';
        $isOklikDisplay = $isOklik && $mode === 'display';
        $isOklikSim = $isOklik && $mode === 'simulasi';
        $showTitle = ! $isOklikDisplay && ! $isOklikSim && ! $isAsalUsul;
        $showFontControls = ! $isOklikDisplay && ! $isOklikSim && ! $isAsalUsul && ! $isTentangMedia;
        $pageBackgroundStyle = "background-image: url('".asset('assets/pantai.webp')."'); background-size: cover; background-position: center;";

        if ($isAsalUsul) {
            $pageBackgroundStyle = 'background-color: #000000';
        } elseif ($isOklikDisplay || $isOklikSim) {
            $pageBackgroundStyle = 'background-color: #4a3f3f';
        }
    @endphp
    <body class="min-h-[100dvh] h-[100dvh] overflow-hidden font-['Paytone_One']">
        
        </div>

        <div class="landscape-force">
            <div data-app-root data-content style="{{ $pageBackgroundStyle }};">
                @if ($showTitle)
                    @if ($isTentangMedia)
                        <div class="absolute left-0 right-0 -top-2 sm:-top-3 md:-top-4 flex justify-center px-4 z-20 pointer-events-none">
                            <img src="{{ asset('assets/menutentangmedia.webp') }}" 
                                 alt="Tentang Media" 
                                 class="h-20 sm:h-24 md:h-32 lg:h-36 xl:h-40 w-auto drop-shadow-xl animate-banner-float select-none">
                        </div>
                    @elseif ($isProfilSeniman)
                        <div class="absolute left-0 right-0 top-3 md:top-6 flex justify-center px-6 z-20 pointer-events-none">
                            <div class="rounded-[28px] bg-[#D9D9D9]/70 px-10 md:px-14 py-3 md:py-4 border border-black/10 shadow-[0_10px_0_rgba(0,0,0,0.18)]">
                                <div class="text-center leading-none tracking-wide" style="text-shadow: -3px 0 #ffffff, 3px 0 #ffffff, 0 -3px #ffffff, 0 3px #ffffff, 0 6px 0 rgba(0,0,0,0.15);">
                                    <div class="text-[#FFA24A] text-3xl md:text-5xl">
                                        PROFIL
                                    </div>
                                    <div class="mt-1 text-[#FFA24A] text-3xl md:text-5xl">
                                        SENIMAN
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="absolute left-0 right-0 top-3 md:top-6 flex justify-center px-6 z-20 pointer-events-none">
                            <div class="rounded-[28px] bg-[#D9D9D9]/70 px-10 md:px-14 py-3 md:py-4 border border-black/10 shadow-[0_10px_0_rgba(0,0,0,0.18)]">
                                <div class="text-[#00A3FF] text-3xl md:text-6xl leading-none tracking-wide"
                                    style="text-shadow: -3px 0 #ffffff, 3px 0 #ffffff, 0 -3px #ffffff, 0 3px #ffffff, 0 6px 0 rgba(0,0,0,0.15);">
                                    {{ mb_strtoupper($title, 'UTF-8') }}
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                @if ($isTentangMedia)
                    <!-- Tombol Kembali di Pojok Kiri Atas -->
                    <div class="absolute top-3 left-3 sm:top-4 sm:left-5 md:top-5 md:left-6 z-30">
                        <button type="button" id="tentangMediaBtnBack" onclick="handleTentangMediaBack()" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95 cursor-pointer block">
                            <img src="{{ asset('assets/left_button.webp') }}" alt="Kembali" class="w-11 sm:w-13 md:w-16 h-auto drop-shadow-md">
                        </button>
                    </div>

                    <!-- Tombol Lanjut di Pojok Kanan Atas (ke Capaian & Tujuan) -->
                    <div id="tentangMediaNextWrap" class="absolute top-3 right-3 sm:top-4 sm:right-5 md:top-5 md:right-6 z-30">
                        <button type="button" id="tentangMediaBtnNext" onclick="switchTentangMediaSlide('capaian')" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95 cursor-pointer block">
                            <img src="{{ asset('assets/right_button.webp') }}" alt="Lanjut" class="w-11 sm:w-13 md:w-16 h-auto drop-shadow-md">
                        </button>
                    </div>
                @else
                    <div class="absolute top-4 right-4 md:top-6 md:right-6 z-20">
                        <img src="{{ asset('assets/sabi.webp') }}" alt="SABI" class="w-24 sm:w-28 md:w-40 h-auto">
                    </div>
                @endif

            @if ($showFontControls)
                <div class="absolute top-4 left-4 md:top-6 md:left-6 z-20 flex items-center gap-2">
                    <button type="button" data-font-decrease class="rounded-xl bg-white/90 border border-black/10 px-3 py-2 text-slate-900 text-sm md:text-base shadow hover:bg-white active:translate-y-[1px]">
                        A-
                    </button>
                    <div data-font-indicator class="rounded-xl bg-white/90 border border-black/10 px-3 py-2 text-slate-900 text-sm md:text-base shadow">
                        100%
                    </div>
                    <button type="button" data-font-increase class="rounded-xl bg-white/90 border border-black/10 px-3 py-2 text-slate-900 text-sm md:text-base shadow hover:bg-white active:translate-y-[1px]">
                        A+
                    </button>
                </div>
            @endif

            @if (($slug ?? '') === 'alat-musik-oklik')
                @if ($isOklikDisplay)
                    @php
                        $firstInstrument = null;
                        if (isset($instruments)) {
                            if ($instruments instanceof \Illuminate\Support\Collection) {
                                $firstInstrument = $instruments->first();
                            } elseif (is_array($instruments)) {
                                $firstInstrument = $instruments[0] ?? null;
                            }
                        }

                        $initialName = $firstInstrument['name'] ?? 'Kentongan Oklik';
                        $initialDescription = $firstInstrument['description'] ?? "Kentongan merupakan salah satu instrumen pemukul yang menjadi identitas bunyi dalam kesenian Oklik.\n\nBiasanya dimainkan berkelompok dengan pola ritme tertentu untuk membentuk irama yang kompak dan dinamis.";
                        $fallbackModelPath = 'assets/klur.glb';
                        $fallbackModelUrl = asset($fallbackModelPath);
                        $fallbackModelFull = public_path($fallbackModelPath);
                        if (file_exists($fallbackModelFull)) {
                            $fallbackModelUrl .= '?v='.filemtime($fallbackModelFull).'-'.filesize($fallbackModelFull);
                        }

                        $initialSrc = $firstInstrument['src'] ?? $fallbackModelUrl;
                        $initialAudio = $firstInstrument['audio'] ?? null;
                    @endphp

                    <div class="absolute left-0 right-0 top-6 md:top-8 flex justify-center px-6">
                        <div id="instrumentName" class="text-white text-3xl md:text-4xl tracking-wide text-center">
                            {{ $initialName }}
                        </div>
                    </div>

                    <div class="absolute inset-x-0 top-16 md:top-14 bottom-24 md:bottom-28 flex justify-center px-8">
                        <div class="w-full max-w-5xl h-full flex flex-col gap-6">
                            <div class="relative flex-1 min-h-0">
                                <button type="button" data-instrument-prev class="absolute left-3 md:left-6 top-1/2 -translate-y-1/2 z-10 transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                                    <img src="{{ asset('assets/left_button.webp') }}" alt="Sebelumnya" class="w-12 md:w-16 h-auto drop-shadow-md">
                                </button>
                                <button type="button" data-instrument-next class="absolute right-3 md:right-6 top-1/2 -translate-y-1/2 z-10 transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                                    <img src="{{ asset('assets/right_button.webp') }}" alt="Berikutnya" class="w-12 md:w-16 h-auto drop-shadow-md">
                                </button>
                                <model-viewer
                                    id="instrumentViewer"
                                    src="{{ $initialSrc }}"
                                    camera-controls
                                    touch-action="pan-y"
                                    class="w-full h-full"
                                ></model-viewer>
                            </div>

                            <div class="shrink-0 flex items-center justify-end gap-3 px-2">
                                <button type="button" data-instrument-audio-toggle class="transition-transform hover:scale-105 active:scale-95">
                                    <img data-instrument-audio-icon src="{{ asset('assets/play.png') }}" alt="Play" class="w-12 md:w-14 h-auto">
                                </button>
                                <audio id="instrumentAudio" preload="none" @if($initialAudio) src="{{ $initialAudio }}" @endif></audio>
                            </div>

                            <div class="shrink-0 rounded-[26px] bg-white/90 px-10 py-6 text-center">
                                <div id="instrumentDescription" class="text-slate-900 text-base md:text-xl leading-relaxed whitespace-pre-line max-h-32 overflow-y-auto" data-font-target data-font-base="1.25">
                                    {{ $initialDescription }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <script id="instrumentData" type="application/json">
                        @json($instruments ?? [])
                    </script>
                @elseif ($isOklikSim)
                    @php
                        $assetV = function (string $src) {
                            if (str_starts_with($src, 'data:') || str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
                                return $src;
                            }

                            if (str_starts_with($src, '/')) {
                                return url($src);
                            }

                            $normalized = ltrim(rawurldecode($src), '/');
                            $full = public_path($normalized);
                            $url = asset(str_replace(' ', '%20', $normalized));
                            if (file_exists($full)) {
                                $url .= '?v='.filemtime($full).'-'.filesize($full);
                            }
                            return $url;
                        };

                        $simImage = file_exists(public_path('assets/oklik.png'))
                            ? $assetV('assets/oklik.png')
                            : $assetV('assets/simulasi alat musik.png');

                        $settings = is_array($oklikSettings ?? null) ? ($oklikSettings ?? []) : [];
                        $pickAudio = function (string $key, ?string $fallbackRawPath) use ($settings, $assetV) {
                            $fromDb = is_string($settings[$key] ?? null) ? trim((string) $settings[$key]) : '';
                            if ($fromDb !== '') {
                                return $assetV($fromDb);
                            }
                            if ($fallbackRawPath && file_exists(public_path($fallbackRawPath))) {
                                return $assetV($fallbackRawPath);
                            }
                            return null;
                        };

                        $simSounds = [
                            'A' => $pickAudio('sim_audio_a', 'assets/Gedhug a2.mp3'),
                            'B' => $pickAudio('sim_audio_b', 'assets/Gedhug b2.mp3'),
                            'C' => $pickAudio('sim_audio_c', 'assets/Gedhug c2.mp3'),
                        ];

                        $simDemo = $pickAudio('sim_demo', 'assets/Demo gedhuh.m4a');
                    @endphp

                    <div class="absolute inset-0 flex items-center justify-center gap-4 px-4 pt-16 pb-24 md:block md:px-0 md:pt-0 md:pb-0">
                        <div class="order-2 md:order-none w-auto max-w-[220px] sm:max-w-[260px] md:max-w-md shrink-0 md:absolute md:left-50 md:top-[28%]">
                            <div class="text-white font-['Paytone_One'] text-base md:text-xl tracking-wide text-center md:text-left">
                                IKUTI POLA DIBAWAH INI
                            </div>
                            <div class="mt-3 md:mt-4 rounded-2xl bg-[#FFF9B3] px-5 md:px-6 py-4 md:py-6 text-slate-900">
                                <div class="font-['Paytone_One'] text-sm md:text-lg">BABC&nbsp;&nbsp;BABC</div>
                                <div class="h-[2px] bg-black/20 my-3"></div>
                                <div class="font-['Paytone_One'] text-sm md:text-lg">ABC&nbsp;&nbsp;ABAC&nbsp;&nbsp;BABC&nbsp;&nbsp;ABAC&nbsp;&nbsp;2×</div>
                                <div class="h-[2px] bg-black/20 my-3"></div>
                                <div class="font-['Paytone_One'] text-sm md:text-lg">BBBCC&nbsp;&nbsp;BCBCBC&nbsp;&nbsp;2×</div>
                            </div>

                            @if ($simDemo)
                                <div class="mt-3 md:mt-4 flex items-center justify-center md:justify-start gap-3">
                                    <button type="button" data-oklik-demo-toggle class="transition-transform hover:scale-105 active:scale-95">
                                        <img data-oklik-demo-icon src="{{ asset('assets/play.png') }}" alt="Play" class="w-10 md:w-12 h-auto">
                                    </button>
                                    <div class="text-white font-['Paytone_One'] text-sm md:text-base tracking-wide">
                                        DEMO GEDHUG
                                    </div>
                                    <audio id="oklikDemoAudio" preload="none" src="{{ $simDemo }}"></audio>
                                </div>
                            @endif
                        </div>

                        <div class="order-1 md:order-none w-full max-w-xs flex justify-center shrink-0 md:absolute md:left-1/2 md:top-[10%] md:-translate-x-1/2">
                            <div class="relative w-full max-w-[200px] sm:max-w-[200px] md:w-[320px] md:max-w-none">
                                <img src="{{ $simImage }}" alt="Simulasi Oklik" class="w-full h-auto select-none pointer-events-none">

                                <button type="button" data-oklik-sim-key="B" class="absolute -translate-x-1/2 -translate-y-1/2" style="left: 50%; top: 44%;">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-20 md:h-20 rounded-full bg-white border-2 border-black flex items-center justify-center text-3xl sm:text-4xl md:text-5xl font-['Paytone_One'] text-slate-900">
                                        B
                                    </div>
                                </button>
                                <button type="button" data-oklik-sim-key="C" class="absolute -translate-x-1/2 -translate-y-1/2" style="left: 90%; top: 44%;">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-20 md:h-20 rounded-full bg-white border-2 border-black flex items-center justify-center text-3xl sm:text-4xl md:text-5xl font-['Paytone_One'] text-slate-900">
                                        C
                                    </div>
                                </button>
                                <button type="button" data-oklik-sim-key="A" class="absolute -translate-x-1/2 -translate-y-1/2" style="left: 50%; top: 72%;">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 md:w-20 md:h-20 rounded-full bg-white border-2 border-black flex items-center justify-center text-3xl sm:text-4xl md:text-5xl font-['Paytone_One'] text-slate-900">
                                        A
                                    </div>
                                </button>
                            </div>
                        </div>

                        <audio id="oklikSimAudio" preload="auto"></audio>
                        <script id="oklikSimSounds" type="application/json">
                            @json($simSounds)
                        </script>
                    </div>
                @else
                    <div class="absolute inset-x-0 top-[34%] md:top-[36%] flex justify-center px-6">
                        <div class="w-full max-w-4xl">
                            <div class="mx-auto max-w-3xl grid grid-cols-2 gap-6">
                                <a href="{{ route('page', ['slug' => 'alat-musik-oklik', 'mode' => 'display']) }}" data-sfx="hover" class="rounded-2xl bg-[#FFF26A] px-6 py-10 text-center text-lg md:text-2xl text-green-900 shadow-[0_12px_0_rgba(0,0,0,0.15)] hover:brightness-105 active:translate-y-[1px] menu-shake">
                                    Alat Musik
                                </a>
                                <a href="{{ route('page', ['slug' => 'alat-musik-oklik', 'mode' => 'simulasi']) }}" data-sfx="hover" class="rounded-2xl bg-[#FFF26A] px-6 py-10 text-center text-lg md:text-2xl text-green-900 shadow-[0_12px_0_rgba(0,0,0,0.15)] hover:brightness-105 active:translate-y-[1px] menu-shake">
                                    Simulasi Alat Musik
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @elseif (($slug ?? '') === 'asal-usul')
                @php
                    $slidesFromDb = null;
                    if (! empty($body)) {
                        $decoded = json_decode($body, true);
                        if (is_array($decoded)) {
                            $slidesFromDb = collect($decoded)
                                ->filter(fn ($item) => is_string($item) && $item !== '')
                                ->values()
                                ->all();
                        }
                    }

                    $slides = ! empty($slidesFromDb)
                        ? collect($slidesFromDb)
                            ->map(function (string $src) {
                                if (str_starts_with($src, 'data:') || str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
                                    return $src;
                                }

                                if (str_starts_with($src, '/')) {
                                    return url($src);
                                }

                                $normalized = ltrim($src, '/');
                                $full = public_path($normalized);
                                $url = asset($normalized);
                                if (file_exists($full)) {
                                    $url .= '?v='.filemtime($full).'-'.filesize($full);
                                }
                                return $url;
                            })
                            ->values()
                            ->all()
                        : [
                            asset('assets/slide1.png'),
                            asset('assets/slide2.png'),
                            asset('assets/slide3.png'),
                            asset('assets/slide4.png'),
                            asset('assets/slide5.png'),
                        ];
                @endphp

                <div class="absolute inset-0 z-0">
                    <div
                        data-asal-backdrop
                        class="absolute inset-0"
                        style="background-image: url('{{ $slides[0] }}'); background-size: cover; background-position: center; filter: blur(18px) saturate(1.15); transform: scale(1.08);"
                    ></div>
                    <div class="absolute inset-0" style="background: rgba(0, 0, 0, 0.25);"></div>

                    <div class="flipbook-container absolute inset-0 flex items-center justify-center">
                        @foreach($slides as $index => $src)
                            <div class="flipbook-page {{ $index === 0 ? 'front' : '' }} {{ $index > 0 ? 'flipped' : '' }}" data-index="{{ $index }}">
                                <img src="{{ $src }}" alt="Slide {{ $index + 1 }}" class="w-full h-full object-contain">
                            </div>
                        @endforeach
                    </div>

                    <button type="button" data-asal-prev class="absolute left-4 md:left-10 top-1/2 -translate-y-1/2 z-10 transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/left_button.webp') }}" alt="Sebelumnya" class="w-12 md:w-16 h-auto drop-shadow-md">
                    </button>
                    <button type="button" data-asal-next class="absolute right-4 md:right-10 top-1/2 -translate-y-1/2 z-10 transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/right_button.webp') }}" alt="Berikutnya" class="w-12 md:w-16 h-auto drop-shadow-md">
                    </button>

                    <script id="asalUsulSlides" type="application/json">
                        @json($slides)
                    </script>
                </div>
            @elseif (($slug ?? '') === 'profil-seniman')
                @php
                    $assetV = function (string $src) {
                        if (str_starts_with($src, 'data:') || str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
                            return $src;
                        }

                        if (str_starts_with($src, '/')) {
                            return url($src);
                        }

                        $normalized = ltrim($src, '/');
                        $full = public_path($normalized);
                        $url = asset($normalized);
                        if (file_exists($full)) {
                            $url .= '?v='.filemtime($full).'-'.filesize($full);
                        }
                        return $url;
                    };

                    $profileConfig = null;
                    if (! empty($body)) {
                        $decoded = json_decode($body, true);
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $profileConfig = $decoded;
                        }
                    }

                    $defaultProfileBody = implode("\n", [
                            "Kadarminto dikenal sebagai maestro seni oklik sekaligus generasi ke-3 dalam garis pelestari kesenian Oklik di Bojonegoro, yang memiliki peran besar dalam menjaga dan mengembangkan musik tradisional tersebut. Dengan dedikasi tinggi, beliau tidak hanya aktif sebagai seniman, tetapi juga sebagai pembina generasi muda melalui Seni Oklik “Mbah Mojo’ yang didirikannya.",
                            '',
                            'Nama    : Kadarminto',
                            'Usia      : 67 tahun',
                            'Alamat  : JL. Singonggolo RT 08 RW 02, Desa Sobontoro, Kecamatan Balen, Kabupaten Bojonegoro, Jawa Timur.',
                            'No Telp : 081335385097',
                        ]);

                    $profileBody = is_array($profileConfig)
                        ? ($profileConfig['profile_body'] ?? $defaultProfileBody)
                        : (! empty($body) ? $body : $defaultProfileBody);

                    $defaultGenerasiBody = implode("\n\n", [
                        'Kesenian Oklik di Desa Sobontoro berkembang dari generasi ke generasi melalui peran para seniman yang terus menjaga dan melestarikan tradisi tersebut.',
                        'Generasi pertama merupakan para pelopor awal kesenian Oklik, yaitu P. Dibyo, P. Rustamaji, dan P. Sukijan.',
                        'Pada generasi kedua sekitar tahun 1950–1960, kesenian Oklik mulai berkembang lebih luas melalui para seniman seperti P. Kaerun, P. Samiran, P. Mamik, P. Kandar, P. Yaeman, P. Supriyadi, P. Pariyono, dan P. Bibit.',
                        'Generasi ketiga pada sekitar tahun 1970-an meneruskan perjuangan para pendahulunya. Tokoh-tokoh seperti P. Kadarminto, P. Sarmu, P. Sukri, P. Rasimin, P. Harto, P. Kaslam, P. Wartam, P. Harjono, P. Mardi, P. Sujarwo, dan P. Suharto mulai melakukan berbagai pengembangan dalam pertunjukan.',
                    ]);

                    $generasiBody = is_array($profileConfig) && ! empty($profileConfig['generasi_body'] ?? null)
                        ? $profileConfig['generasi_body']
                        : $defaultGenerasiBody;

                    $mainProfileImage = is_array($profileConfig) && ! empty($profileConfig['main_image'] ?? null)
                        ? $assetV($profileConfig['main_image'])
                        : (file_exists(public_path('assets/group32.png')) ? $assetV('assets/group32.png') : $assetV('assets/Group%2032.png'));

                    $sideTopImage = is_array($profileConfig) && ! empty($profileConfig['side_top_image'] ?? null)
                        ? $assetV($profileConfig['side_top_image'])
                        : $assetV('assets/image1.png');

                    $sideBottomImage = is_array($profileConfig) && ! empty($profileConfig['side_bottom_image'] ?? null)
                        ? $assetV($profileConfig['side_bottom_image'])
                        : (file_exists(public_path('assets/image3.png')) ? $assetV('assets/image3.png') : $sideTopImage);

                    $pentasImage = is_array($profileConfig) && ! empty($profileConfig['pentas_image'] ?? null)
                        ? $assetV($profileConfig['pentas_image'])
                        : (file_exists(public_path('assets/pentas.png')) ? $assetV('assets/pentas.png') : $assetV('assets/Pentas.png'));

                    $profileSlides = [
                        [
                            'img' => $mainProfileImage,
                            'alt' => 'Profil Seniman',
                            'body' => $profileBody,
                            'photo' => [
                                'shift_x' => 0,
                                'shift_y' => 0,
                                'scale' => 1,
                                'width' => null,
                            ],
                            'photo_mobile' => [
                                'shift_x' => 0,
                                'shift_y' => 0,
                                'scale' => 1,
                                'width' => null,
                            ],
                            'text' => [
                                'shift_x' => 0,
                                'shift_y' => 0,
                            ],
                            'text_mobile' => [
                                'shift_x' => 0,
                                'shift_y' => 0,
                            ],
                        ],
                        [
                            'type' => 'gallery',
                            'images' => [
                                [
                                    'src' => $sideTopImage,
                                    'alt' => 'Foto Kegiatan 1'
                                ],
                                [
                                    'src' => $sideBottomImage,
                                    'alt' => 'Foto Kegiatan 2'
                                ]
                            ]
                        ],
                        [
                            'img' => $pentasImage,
                            'alt' => 'Pentas Oklik',
                            'body' => $generasiBody,
                            'photo' => [
                                'shift_x' => -50,
                                'shift_y' => 80,
                                'scale' => 1.10,
                                'width' => null,
                            ],
                            'photo_mobile' => [
                                'shift_x' => -50,
                                'shift_y' => 80,
                                'scale' => 1.10,
                                'width' => null,
                            ],
                            'text' => [
                                'shift_x' => 0,
                                'shift_y' => 0,
                            ],
                            'text_mobile' => [
                                'shift_x' => 0,
                                'shift_y' => 0,
                            ],
                        ]
                    ];
                @endphp

                <div class="absolute inset-x-0 top-[20%] md:top-[22%] bottom-24 md:bottom-28 flex justify-center px-6">
                    <div class="relative w-full max-w-6xl h-full" style="max-width: 1600px;">
                        <button
                            type="button"
                            data-profile-seniman-prev
                            class="absolute left-3 md:left-6 lg:left-8 xl:left-[-120px] top-1/2 -translate-y-1/2 z-20 transition-transform hover:scale-105 active:scale-95 cursor-pointer"
                            aria-label="Sebelumnya"
                        >
                            <img src="{{ asset('assets/left_button.webp') }}" alt="Sebelumnya" class="w-12 md:w-16 h-auto drop-shadow-md">
                        </button>

                        <button
                            type="button"
                            data-profile-seniman-next
                            class="absolute right-3 md:right-6 lg:right-8 xl:right-[-150px] top-1/2 -translate-y-1/2 z-20 transition-transform hover:scale-105 active:scale-95 cursor-pointer"
                            aria-label="Berikutnya"
                        >
                            <img src="{{ asset('assets/right_button.webp') }}" alt="Berikutnya" class="w-12 md:w-16 h-auto drop-shadow-md">
                        </button>

                        <div data-profile-seniman-content class="w-full h-full flex items-start justify-center gap-6 md:gap-16 pt-2">
                            <div data-profile-seniman-normal class="h-full flex flex-row items-start justify-center gap-3 md:gap-16 pt-2 w-full md:w-auto">
                                <div data-profile-seniman-photo-wrap class="w-[190px] sm:w-[220px] md:w-[360px] shrink-0 flex justify-center pt-2 md:pt-6">
                                    <button
                                        type="button"
                                        data-profile-seniman-photo-open
                                        data-photo-open
                                        data-photo-src="{{ $profileSlides[0]['img'] }}"
                                        data-photo-alt="{{ $profileSlides[0]['alt'] }}"
                                        class="block w-full"
                                    >
                                        <img
                                            data-profile-seniman-img
                                            src="{{ $profileSlides[0]['img'] }}"
                                            alt="{{ $profileSlides[0]['alt'] }}"
                                            class="w-full h-auto"
                                            style="background: rgba(255,255,255,0.75);"
                                        >
                                    </button>
                                </div>

                                <div data-profile-seniman-text-wrap class="flex-1 min-w-0 h-auto md:h-full overflow-y-auto pr-0 md:pr-2 pt-2 md:pt-10 min-h-0 max-h-[42vh] md:max-h-none">
                                    <div class="font-['Jua'] text-slate-900 leading-relaxed whitespace-pre-line text-sm sm:text-base md:text-base" data-font-target data-font-base="1.05">
                                        <div data-profile-seniman-text>{{ $profileSlides[0]['body'] }}</div>
                                    </div>
                                </div>
                            </div>

                            <div data-profile-seniman-gallery class="hidden h-full items-center justify-center gap-6 md:gap-10 px-6 w-full">
                            </div>
                        </div>

                        <script id="profileSenimanSlides" type="application/json">
                            @json($profileSlides)
                        </script>
                    </div>
                </div>

                <div id="profilePhotoModal" aria-hidden="true" style="display: none; position: fixed; inset: 0; z-index: 50; align-items: center; justify-content: center; background: rgba(0,0,0,0.55);">
                    <div style="width: min(1100px, 94vw); height: min(640px, 80vh); display: flex; align-items: center; justify-content: center; padding: 18px;">
                        <div style="position: relative; width: fit-content; height: fit-content; max-width: 100%; max-height: 100%;">
                            <button type="button" data-photo-close style="position: absolute; top: -14px; right: -14px; z-index: 2;">
                                <img src="{{ asset('assets/x.png') }}" alt="Tutup" style="width: 38px; height: auto;">
                            </button>
                            <img id="profilePhotoModalImg" src="" alt="" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                    </div>
                </div>
            @elseif (($slug ?? '') === 'tentang-media')
                <div class="absolute inset-x-0 top-[15%] md:top-[18%] bottom-3 md:bottom-5 flex flex-col items-center justify-center px-4 md:px-8 overflow-y-auto">
                    
                    <!-- Slide 1: Profil Pengembang (Langsung tanpa panel putih, ukuran ekstra besar) -->
                    <div id="tabContentProfil" class="flex-1 w-full flex items-center justify-center py-2 overflow-visible">
                        <div class="grid grid-cols-3 gap-3 sm:gap-6 md:gap-8 lg:gap-12 items-center justify-items-center w-full max-w-7xl mx-auto px-2 sm:px-4">
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('assets/pengembang1.webp') }}" alt="Pengembang 1" class="w-full max-w-[280px] sm:max-w-[340px] md:max-w-[400px] lg:max-w-[460px] max-h-[62vh] md:max-h-[68vh] object-contain drop-shadow-[0_12px_24px_rgba(0,0,0,0.3)] hover:scale-105 transition-transform duration-300 select-none">
                            </div>
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('assets/pengembang2.webp') }}" alt="Pengembang 2" class="w-full max-w-[280px] sm:max-w-[340px] md:max-w-[400px] lg:max-w-[460px] max-h-[62vh] md:max-h-[68vh] object-contain drop-shadow-[0_12px_24px_rgba(0,0,0,0.3)] hover:scale-105 transition-transform duration-300 select-none">
                            </div>
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('assets/pengembang3.webp') }}" alt="Pengembang 3" class="w-full max-w-[280px] sm:max-w-[340px] md:max-w-[400px] lg:max-w-[460px] max-h-[62vh] md:max-h-[68vh] object-contain drop-shadow-[0_12px_24px_rgba(0,0,0,0.3)] hover:scale-105 transition-transform duration-300 select-none">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Capaian dan Tujuan Pembelajaran (Dibuat sampingan / side-by-side di mobile maupun desktop) -->
                    <div id="tabContentCapaian" class="hidden flex-1 w-full flex items-center justify-center py-2 overflow-visible">
                        <div class="grid grid-cols-2 gap-2.5 sm:gap-6 md:gap-8 lg:gap-14 items-center justify-items-center w-full max-w-6xl mx-auto px-2 sm:px-4">
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('assets/CAPAIAN.webp') }}" alt="Capaian Pembelajaran" class="w-full max-w-[260px] sm:max-w-[380px] md:max-w-[480px] lg:max-w-[540px] max-h-[60vh] sm:max-h-[66vh] md:max-h-[72vh] object-contain drop-shadow-[0_10px_20px_rgba(0,0,0,0.3)] hover:scale-105 transition-transform duration-300 select-none">
                            </div>
                            <div class="w-full flex justify-center">
                                <img src="{{ asset('assets/TUJUAN.webp') }}" alt="Tujuan Pembelajaran" class="w-full max-w-[260px] sm:max-w-[380px] md:max-w-[480px] lg:max-w-[540px] max-h-[60vh] sm:max-h-[66vh] md:max-h-[72vh] object-contain drop-shadow-[0_10px_20px_rgba(0,0,0,0.3)] hover:scale-105 transition-transform duration-300 select-none">
                            </div>
                        </div>
                    </div>

                </div>

                <script>
                    let currentTentangMediaSlide = 'profil';

                    function switchTentangMediaSlide(slide) {
                        currentTentangMediaSlide = slide;
                        const contentProfil = document.getElementById('tabContentProfil');
                        const contentCapaian = document.getElementById('tabContentCapaian');
                        const nextWrap = document.getElementById('tentangMediaNextWrap');

                        if (slide === 'profil') {
                            if (contentProfil) contentProfil.classList.remove('hidden');
                            if (contentCapaian) contentCapaian.classList.add('hidden');
                            if (nextWrap) nextWrap.style.display = 'block';
                        } else {
                            if (contentProfil) contentProfil.classList.add('hidden');
                            if (contentCapaian) contentCapaian.classList.remove('hidden');
                            if (nextWrap) nextWrap.style.display = 'none';
                        }
                    }

                    function handleTentangMediaBack() {
                        if (currentTentangMediaSlide === 'capaian') {
                            switchTentangMediaSlide('profil');
                        } else {
                            if (window.sabiRouter) {
                                window.sabiRouter.navigateTo("{{ route('menu') }}");
                            } else {
                                window.location.href = "{{ route('menu') }}";
                            }
                        }
                    }
                </script>
            @elseif (! empty($body))
                @if (($slug ?? '') === 'soal-evaluasi')
                    <div class="absolute inset-x-0 top-[28%] md:top-[30%] flex justify-center px-6">
                        <div class="w-full max-w-2xl rounded-2xl bg-white/80 border border-black/10 shadow-[0_10px_0_rgba(0,0,0,0.18)] px-8 py-10 text-center">
                            <div class="text-slate-900 text-base md:text-xl leading-relaxed whitespace-pre-line" data-font-target data-font-base="1.25">
                                {{ $body }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="absolute left-0 right-0 top-[22%] md:top-[26%] flex justify-center px-6">
                        <div @class([
                            'w-full max-w-2xl text-slate-900 text-base md:text-xl leading-relaxed whitespace-pre-line',
                            "font-['Jua']" => ($slug ?? '') === 'tentang-media',
                        ]) data-font-target data-font-base="1.25">
                            {{ $body }}
                        </div>
                    </div>
                @endif
            @endif

            @if (($slug ?? '') === 'soal-evaluasi')
                <div class="absolute left-0 right-0 bottom-16 md:bottom-20 flex justify-center">
                    <a href="{{ route('quiz.start') }}" class="transition-transform hover:scale-105 active:scale-95">
                        <img src="{{ asset('assets/mulaijo.png') }}" alt="Mulai" class="w-28 md:w-36 h-auto">
                    </a>
                </div>
            @endif

            @if (($slug ?? '') === 'asal-usul')
                <div id="asalUsulExit" class="absolute left-0 right-0 bottom-6 md:bottom-8 flex justify-center" style="display: none;">
                    <a href="{{ route('menu') }}" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/keluar.png') }}" alt="Keluar" class="w-28 md:w-40 h-auto">
                    </a>
                </div>
            @elseif (($slug ?? '') === 'tentang-media')
                {{-- Tombol kembali sudah berada di pojok kiri atas --}}
            @else
                <div class="absolute left-0 right-0 bottom-6 md:bottom-8 flex justify-center">
                    <a href="{{ route('menu') }}" data-sfx="hover" class="transition-transform hover:scale-105 active:scale-95 cursor-pointer">
                        <img src="{{ asset('assets/keluar.png') }}" alt="Keluar" class="w-28 md:w-40 h-auto">
                    </a>
                </div>
            @endif
        </div>
        </div>
    </body>
</html>
