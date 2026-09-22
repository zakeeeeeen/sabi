<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Petualangan Oklik - Mini Game 2D</title>
    <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
            user-select: none;
            -webkit-user-select: none;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background-color: #0f172a;
            font-family: 'Paytone One', sans-serif;
        }

        #gameContainer {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, #38bdf8 0%, #7dd3fc 60%, #bae6fd 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
            touch-action: none;
        }

        /* Top HUD Bar */
        .hud-bar {
            position: absolute;
            top: 12px;
            left: 16px;
            right: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 30;
            pointer-events: none;
        }

        .hud-group {
            display: flex;
            align-items: center;
            gap: 10px;
            pointer-events: auto;
        }

        .hud-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            border: 3px solid #facc15;
            border-radius: 9999px;
            padding: 6px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            color: #0f172a;
            font-size: 1.1rem;
        }

        .hud-btn {
            width: 48px;
            height: 48px;
            border-radius: 9999px;
            background: #ffffff;
            border: 3px solid #e2e8f0;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            pointer-events: auto;
        }

        .hud-btn:hover {
            transform: scale(1.05);
            background: #f8fafc;
        }

        /* Mobile Touch Controls */
        .touch-controls {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            z-index: 30;
            pointer-events: none;
        }

        .dpad-group {
            display: flex;
            gap: 16px;
            pointer-events: auto;
        }

        .touch-btn {
            width: 68px;
            height: 68px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.85);
            border: 4px solid #facc15;
            box-shadow: 0 8px 16px rgba(0,0,0,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            touch-action: manipulation;
            transition: transform 0.1s ease;
        }

        .touch-btn:active, .touch-btn.active {
            transform: scale(0.9);
            background: #facc15;
        }

        .jump-btn {
            width: 80px;
            height: 80px;
            border-radius: 9999px;
            background: #facc15;
            border: 4px solid #ffffff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
            font-size: 1.1rem;
            font-weight: bold;
            pointer-events: auto;
            cursor: pointer;
            touch-action: manipulation;
        }

        .interact-btn {
            height: 64px;
            padding: 0 20px;
            border-radius: 9999px;
            background: #38bdf8;
            border: 4px solid #ffffff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #0f172a;
            font-size: 0.95rem;
            font-family: 'Paytone One', sans-serif;
            pointer-events: auto;
            cursor: pointer;
            touch-action: manipulation;
            transition: transform 0.1s ease;
        }

        .interact-btn:active, .interact-btn.active {
            transform: scale(0.92);
            background: #0284c7;
            color: #ffffff;
        }

        /* Modals & Overlays */
        .modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .menu-card {
            background: #ffffff;
            border: 5px solid #facc15;
            border-radius: 28px;
            max-width: 520px;
            width: 100%;
            padding: 32px;
            box-shadow: 0 24px 48px rgba(0,0,0,0.4);
            text-align: center;
            transform: scale(0.92);
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-overlay.active .menu-card {
            transform: scale(1);
        }

        .game-menu-btn {
            width: 100%;
            padding: 16px;
            border-radius: 20px;
            font-size: 1.2rem;
            font-family: 'Paytone One', sans-serif;
            color: #1e293b;
            background: #fff26a;
            border: 3px solid #eab308;
            box-shadow: 0 8px 0 rgba(0,0,0,0.12);
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 14px;
        }

        .game-menu-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
        }

        .game-menu-btn:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 rgba(0,0,0,0.12);
        }

        .game-menu-btn.quit {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #475569;
        }

        /* Level Select Cards */
        .level-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 20px;
            max-height: 320px;
            overflow-y: auto;
            padding: 4px;
        }

        .level-card {
            background: #f8fafc;
            border: 3px solid #e2e8f0;
            border-radius: 20px;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            position: relative;
        }

        .level-card.unlocked {
            background: #fefce8;
            border-color: #facc15;
            color: #0f172a;
        }

        .level-card.unlocked:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .level-card.locked {
            background: #e2e8f0;
            border-color: #cbd5e1;
            color: #94a3b8;
            cursor: not-allowed;
            opacity: 0.75;
        }

        /* Quiz Card */
        .quiz-card {
            background: #ffffff;
            border: 4px solid #facc15;
            border-radius: 24px;
            max-width: 560px;
            width: 100%;
            padding: 28px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .quiz-option {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 14px 18px;
            margin-top: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: #1e293b;
            transition: all 0.15s ease;
        }

        .quiz-option:hover {
            border-color: #facc15;
            background: #fefce8;
        }

        .quiz-option.selected-correct {
            background: #dcfce7;
            border-color: #22c55e;
            color: #15803d;
        }

        .quiz-option.selected-wrong {
            background: #fee2e2;
            border-color: #ef4444;
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <div id="gameContainer">
        <!-- Canvas Game -->
        <canvas id="gameCanvas"></canvas>

        <!-- Top HUD -->
        <div class="hud-bar">
            <div class="hud-group">
                <button type="button" onclick="openStartScreen()" class="hud-btn" title="Menu Utama Game">
                    <iconify-icon icon="lucide:menu" class="text-xl text-slate-700"></iconify-icon>
                </button>

                @if($isAdmin)
                    <a href="{{ route('minigame.editor') }}" class="hud-btn" title="Map Editor (Khusus Admin)">
                        <iconify-icon icon="lucide:wrench" class="text-xl text-slate-700"></iconify-icon>
                    </a>
                @endif

                <div class="hud-card">
                    <img src="{{ asset('assets/poin1.png') }}" alt="Coin" class="w-4 h-7 object-contain">
                    <span id="coinCount">0</span>
                </div>
            </div>

            <div class="hud-group">
                <div class="hud-card">
                    <span class="text-xs text-slate-500 uppercase font-sans font-bold">Skor</span>
                    <span id="scoreCount">0</span>
                </div>
                <button type="button" id="muteBtn" class="hud-btn" title="Audio">
                    <span id="soundIconOn"><iconify-icon icon="lucide:volume-2" class="text-xl text-slate-700"></iconify-icon></span>
                    <span id="soundIconOff" class="hidden"><iconify-icon icon="lucide:volume-x" class="text-xl text-slate-400"></iconify-icon></span>
                </button>
            </div>
        </div>

        <!-- Mobile Touch Controls -->
        <div class="touch-controls">
            <div class="dpad-group">
                <button type="button" id="btnLeft" class="touch-btn" aria-label="Kiri">
                    <img src="{{ asset('assets/kiri.png') }}" alt="Kiri" class="w-8 h-8 pointer-events-none">
                </button>
                <button type="button" id="btnRight" class="touch-btn" aria-label="Kanan">
                    <img src="{{ asset('assets/kanan.png') }}" alt="Kanan" class="w-8 h-8 pointer-events-none">
                </button>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" id="btnInteract" class="interact-btn hidden" aria-label="Bicara">
                    <iconify-icon icon="lucide:message-square" class="text-xl"></iconify-icon>
                    <span>BICARA [E]</span>
                </button>
                <button type="button" id="btnJump" class="jump-btn" aria-label="Lompat">
                    LOMPAT
                </button>
            </div>
        </div>

        <!-- 1. GAME START SCREEN OVERLAY -->
        <div id="startScreenModal" class="modal-overlay active">
            <div class="menu-card">
                <img src="{{ asset('assets/sabi.webp') }}" alt="Logo" class="w-28 h-auto mx-auto mb-2">
                <h1 class="text-2xl md:text-3xl text-slate-800 mb-1">PETUALANGAN OKLIK</h1>
                <p class="text-xs text-slate-500 font-sans font-semibold mb-6">Mini Game 2D Budaya Bojonegoro</p>

                <button type="button" onclick="loadLevelMap(0)" class="game-menu-btn">
                    <iconify-icon icon="lucide:play" class="text-2xl"></iconify-icon>
                    <span>START</span>
                </button>
                <button type="button" onclick="openLevelSelect()" class="game-menu-btn">
                    <iconify-icon icon="lucide:list-ordered" class="text-2xl"></iconify-icon>
                    <span>PILIHAN LEVEL</span>
                </button>
                <button type="button" onclick="openOptionModal()" class="game-menu-btn">
                    <iconify-icon icon="lucide:settings" class="text-2xl"></iconify-icon>
                    <span>OPTION</span>
                </button>
                <a href="{{ route('menu') }}" class="game-menu-btn quit">
                    <iconify-icon icon="lucide:log-out" class="text-2xl"></iconify-icon>
                    <span>QUIT</span>
                </a>
            </div>
        </div>

        <!-- 2. LEVEL SELECT SCREEN MODAL -->
        <div id="levelSelectModal" class="modal-overlay">
            <div class="menu-card">
                <h2 class="text-2xl text-slate-800 mb-1">PILIHAN LEVEL</h2>
                <p class="text-xs text-slate-500 font-sans font-semibold mb-4">Pilih level untuk memulai permainan!</p>

                <div class="level-grid" id="levelGridContainer">
                    <!-- Dynamic level cards generated by JS -->
                </div>

                <button type="button" onclick="openStartScreen()" class="game-menu-btn quit mt-6">
                    <iconify-icon icon="lucide:arrow-left" class="text-xl"></iconify-icon>
                    <span>Kembali</span>
                </button>
            </div>
        </div>

        <!-- 3. OPTION MODAL -->
        <div id="optionModal" class="modal-overlay">
            <div class="menu-card text-left font-sans">
                <h2 class="text-2xl font-['Paytone_One'] text-slate-800 mb-4 text-center">PENGATURAN & KONTROL</h2>

                <div class="space-y-4 text-sm text-slate-700">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <h4 class="font-bold text-slate-900 mb-1 flex items-center gap-2">
                            <iconify-icon icon="lucide:gamepad-2" class="text-lg text-yellow-600"></iconify-icon>
                            <span>Kontrol Keyboard (PC)</span>
                        </h4>
                        <p><strong>A / D</strong> atau <strong>Panah Kiri/Kanan</strong>: Bergerak ke kiri/kanan</p>
                        <p><strong>W / Space</strong> atau <strong>Panah Atas</strong>: Melompat</p>
                        <p><strong>E</strong>: Bicara dengan NPC Checkpoint</p>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <h4 class="font-bold text-slate-900 mb-1 flex items-center gap-2">
                            <iconify-icon icon="lucide:smartphone" class="text-lg text-yellow-600"></iconify-icon>
                            <span>Kontrol Layar Sentuh (HP/Tablet)</span>
                        </h4>
                        <p>Gunakan tombol sentuh di sudut kiri dan kanan bawah layar.</p>
                    </div>
                </div>

                <button type="button" onclick="closeModal('optionModal')" class="game-menu-btn primary mt-6">
                    Tutup
                </button>
            </div>
        </div>

        <!-- 4. NPC QUIZ MODAL -->
        <div id="quizModal" class="modal-overlay">
            <div class="quiz-card">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <div class="flex items-center gap-3">
                        <img id="quizNpcAvatar" src="{{ asset('assets/npcidle1.png') }}" alt="NPC" class="w-12 h-12 rounded-full border-2 border-yellow-400 bg-yellow-100 object-cover" style="transform: scaleX(-1);">
                        <div>
                            <h3 class="font-['Paytone_One'] text-slate-800 text-lg leading-tight">NPC Jaga Gerbang</h3>
                            <p class="text-xs text-slate-500 font-semibold">Jawab kuis untuk melanjutkan!</p>
                        </div>
                    </div>
                    <span id="quizBadge" class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-bold">Pos 1</span>
                </div>

                <div id="quizQuestionText" class="text-slate-800 font-bold text-base md:text-lg mb-4">Soal...</div>
                <div id="quizOptionsContainer" class="space-y-2"></div>
                <div id="quizFeedback" class="mt-4 p-3 rounded-xl text-center text-sm font-bold hidden"></div>
            </div>
        </div>

        <!-- 5. STAGE CLEARED VICTORY MODAL -->
        <div id="victoryModal" class="modal-overlay">
            <div class="menu-card">
                <div class="w-20 h-20 mx-auto mb-2 bg-yellow-100 rounded-full flex items-center justify-center border-4 border-yellow-400">
                    <iconify-icon icon="lucide:trophy" class="text-yellow-600 text-4xl"></iconify-icon>
                </div>
                <h2 class="text-2xl text-slate-800 mb-1">STAGE CLEARED!</h2>
                <p class="text-slate-600 text-xs font-sans mb-4">Selamat! Kamu berhasil menyelesaikan stage ini!</p>

                <div class="grid grid-cols-2 gap-3 mb-4 font-sans">
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200">
                        <div class="text-xs text-slate-500 font-bold">Koin Diraih</div>
                        <div id="finalCoins" class="text-xl font-['Paytone_One'] text-yellow-600">0</div>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200">
                        <div class="text-xs text-slate-500 font-bold">Kuis Benar</div>
                        <div id="finalQuiz" class="text-xl font-['Paytone_One'] text-green-600">0</div>
                    </div>
                </div>

                <button type="button" id="btnNextLevel" onclick="nextLevel()" class="game-menu-btn">
                    <iconify-icon icon="lucide:arrow-right" class="text-xl"></iconify-icon>
                    <span>NEXT LEVEL</span>
                </button>
                <button type="button" onclick="restartLevel()" class="game-menu-btn">
                    <iconify-icon icon="lucide:rotate-ccw" class="text-xl"></iconify-icon>
                    <span>RESTART</span>
                </button>
                <button type="button" onclick="openLevelSelect()" class="game-menu-btn quit">
                    <iconify-icon icon="lucide:list-ordered" class="text-xl"></iconify-icon>
                    <span>PILIHAN LEVEL</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Sound FX Synthesizer -->
    <script>
        class SoundFX {
            constructor() { this.ctx = null; this.muted = false; }
            init() {
                if (!this.ctx) {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (AudioCtx) this.ctx = new AudioCtx();
                }
            }
            playJump() {
                if (this.muted) return; this.init(); if (!this.ctx) return;
                try {
                    const osc = this.ctx.createOscillator(), gain = this.ctx.createGain();
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(180, this.ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(450, this.ctx.currentTime + 0.15);
                    gain.gain.setValueAtTime(0.3, this.ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.15);
                    osc.connect(gain); gain.connect(this.ctx.destination);
                    osc.start(); osc.stop(this.ctx.currentTime + 0.15);
                } catch (e) {}
            }
            playCoin() {
                if (this.muted) return; this.init(); if (!this.ctx) return;
                try {
                    const osc = this.ctx.createOscillator(), gain = this.ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(987.77, this.ctx.currentTime);
                    osc.frequency.setValueAtTime(1318.51, this.ctx.currentTime + 0.08);
                    gain.gain.setValueAtTime(0.25, this.ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.25);
                    osc.connect(gain); gain.connect(this.ctx.destination);
                    osc.start(); osc.stop(this.ctx.currentTime + 0.25);
                } catch (e) {}
            }
            playCorrect() {
                if (this.muted) return; this.init(); if (!this.ctx) return;
                try {
                    [523.25, 659.25, 783.99, 1046.50].forEach((freq, idx) => {
                        const osc = this.ctx.createOscillator(), gain = this.ctx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(freq, this.ctx.currentTime + idx * 0.08);
                        gain.gain.setValueAtTime(0.2, this.ctx.currentTime + idx * 0.08);
                        gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + idx * 0.08 + 0.2);
                        osc.connect(gain); gain.connect(this.ctx.destination);
                        osc.start(this.ctx.currentTime + idx * 0.08);
                        osc.stop(this.ctx.currentTime + idx * 0.08 + 0.2);
                    });
                } catch (e) {}
            }
            playWrong() {
                if (this.muted) return; this.init(); if (!this.ctx) return;
                try {
                    const osc = this.ctx.createOscillator(), gain = this.ctx.createGain();
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(160, this.ctx.currentTime);
                    osc.frequency.setValueAtTime(120, this.ctx.currentTime + 0.15);
                    gain.gain.setValueAtTime(0.3, this.ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.01, this.ctx.currentTime + 0.3);
                    osc.connect(gain); gain.connect(this.ctx.destination);
                    osc.start(); osc.stop(this.ctx.currentTime + 0.3);
                } catch (e) {}
            }
        }
        const sfx = new SoundFX();
    </script>

    <!-- Game Engine -->
    <script>
        const quizQuestionsData = @json($questions);
        const dbLevelsList = @json($levels);

        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');

        // Character Sprite Assets
        const imgIdle = new Image(); imgIdle.src = "{{ asset('assets/idle.png') }}";
        const imgRun = [new Image(), new Image(), new Image(), new Image()];
        imgRun[0].src = "{{ asset('assets/run1.png') }}";
        imgRun[1].src = "{{ asset('assets/run2.png') }}";
        imgRun[2].src = "{{ asset('assets/run3.png') }}";
        imgRun[3].src = "{{ asset('assets/run4.png') }}";
        // Animated NPC Idle Sprites (Pola 1 -> 2 -> 3 -> 2 -> 1)
        const npcIdleFrames = [new Image(), new Image(), new Image()];
        npcIdleFrames[0].src = "{{ asset('assets/npcidle1.png') }}";
        npcIdleFrames[1].src = "{{ asset('assets/npcidle2.png') }}";
        npcIdleFrames[2].src = "{{ asset('assets/npcidle3.png') }}";
        const npcIdleSequence = [0, 1, 2, 1];

        // Animated Coin Sprites (Pola 1 -> 2 -> 3 -> 2 -> 1)
        const coinFrames = [new Image(), new Image(), new Image()];
        coinFrames[0].src = "{{ asset('assets/poin1.png') }}";
        coinFrames[1].src = "{{ asset('assets/poin2.png') }}";
        coinFrames[2].src = "{{ asset('assets/poin3.png') }}";
        const coinSequence = [0, 1, 2, 1];

        // Built-in Default Tile Assets
        const defaultTileAssets = [
            {
                id: 'dirt',
                name: 'Tanah 1 (Dirt)',
                url: "{{ asset('assets/dirt.png') }}",
                type: 'solid',
                isDefault: true
            },
            {
                id: 'dirt2',
                name: 'Tanah 2 (Dirt 2)',
                url: "{{ asset('assets/dirt2.png') }}",
                type: 'solid',
                isDefault: true
            }
        ];

        // Built-in Default NPC Assets
        const defaultNpcAssets = [
            {
                id: 'npc_idle',
                name: 'NPC Penjaga Gerbang (Animated)',
                url: "{{ asset('assets/npcidle1.png') }}",
                isDefault: true
            },
            {
                id: 'npc_co',
                name: 'Karakter Cowok',
                url: "{{ asset('assets/karakterco.png') }}",
                isDefault: true
            },
            {
                id: 'npc_ce',
                name: 'Karakter Cewek',
                url: "{{ asset('assets/karakterce.png') }}",
                isDefault: true
            }
        ];

        // Helper to resolve asset URLs across different ports/localhost
        function resolveAssetUrl(url) {
            if (!url) return '';
            if (url.startsWith('data:') || url.startsWith('blob:')) return url;
            const idx = url.indexOf('/assets/');
            if (idx !== -1) {
                return url.substring(idx);
            }
            if (url.startsWith('assets/')) {
                return '/' + url;
            }
            return url;
        }

        // Image Cache for Tiles & NPCs
        const tileImageCache = {};
        function getTileImage(url) {
            url = resolveAssetUrl(url);
            if (!tileImageCache[url]) {
                const img = new Image();
                img.src = url;
                tileImageCache[url] = img;
            }
            return tileImageCache[url];
        }

        const npcImageCache = {};
        function getNpcImage(url) {
            if (!url) url = "{{ asset('assets/npcidle1.png') }}";
            url = resolveAssetUrl(url);
            if (!npcImageCache[url]) {
                const img = new Image();
                img.src = url;
                npcImageCache[url] = img;
            }
            return npcImageCache[url];
        }

        // Preload default tiles & npcs
        defaultTileAssets.forEach(t => getTileImage(t.url));
        defaultNpcAssets.forEach(n => getNpcImage(n.url));
        npcIdleFrames.forEach(f => f);

        // Mute button logic
        let isMuted = false;
        document.getElementById('muteBtn').addEventListener('click', () => {
            isMuted = !isMuted; sfx.muted = isMuted;
            document.getElementById('soundIconOn').classList.toggle('hidden', isMuted);
            document.getElementById('soundIconOff').classList.toggle('hidden', !isMuted);
        });

        // Unlocked Levels tracking (localStorage)
        let unlockedLevels = JSON.parse(localStorage.getItem('unlocked_levels') || '[1]');

        // Game State
        const state = {
            currentLevelIndex: 0,
            coinsCollected: 0,
            quizCorrectCount: 0,
            score: 0,
            paused: true,
            cameraX: 0,
        };

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        // Player physics
        const player = {
            x: 100, y: 300, width: 70, height: 105, vx: 0, vy: 0,
            speed: 4.5, jumpPower: -15.5, gravity: 0.7,
            isGrounded: false, facingLeft: false, runFrame: 0, frameTimer: 0
        };

        const keys = { left: false, right: false, up: false };

        window.addEventListener('keydown', (e) => {
            sfx.init();
            if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = true;
            if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = true;
            if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W' || e.key === ' ') {
                if (!keys.up && player.isGrounded && !state.paused) {
                    player.vy = player.jumpPower; player.isGrounded = false; sfx.playJump();
                }
                keys.up = true;
            }
            if ((e.key === 'e' || e.key === 'E') && !state.paused) {
                if (nearbyNpc) {
                    openQuizModal(nearbyNpc);
                }
            }
        });

        window.addEventListener('keyup', (e) => {
            if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = false;
            if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = false;
            if (e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W' || e.key === ' ') keys.up = false;
        });

        const setupTouchBtn = (id, keyName) => {
            const btn = document.getElementById(id);
            if (!btn) return;
            btn.addEventListener('touchstart', (e) => {
                e.preventDefault(); sfx.init();
                if (keyName === 'up' && player.isGrounded && !state.paused) {
                    player.vy = player.jumpPower; player.isGrounded = false; sfx.playJump();
                }
                keys[keyName] = true; btn.classList.add('active');
            });
            btn.addEventListener('touchend', (e) => {
                e.preventDefault(); keys[keyName] = false; btn.classList.remove('active');
            });
        };
        setupTouchBtn('btnLeft', 'left');
        setupTouchBtn('btnRight', 'right');
        setupTouchBtn('btnJump', 'up');

        // Mobile touch interact button listener
        const btnInteract = document.getElementById('btnInteract');
        if (btnInteract) {
            btnInteract.addEventListener('click', (e) => {
                e.preventDefault(); sfx.init();
                if (nearbyNpc && !state.paused) {
                    openQuizModal(nearbyNpc);
                }
            });
            btnInteract.addEventListener('touchstart', (e) => {
                e.preventDefault(); sfx.init();
                if (nearbyNpc && !state.paused) {
                    openQuizModal(nearbyNpc);
                }
            });
        }

        // Level World Setup
        const groundY = 560;
        let platforms = [];
        let coins = [];
        let npcs = [];
        let nearbyNpc = null;
        let finishFlag = { x: 4000, y: 370, w: 60, h: 180 };
        let activeCustomMapData = null;

        // Helper to parse cell format (supports object {asset, type} and legacy string)
        function getCellData(cell) {
            if (!cell) return null;
            if (typeof cell === 'object') {
                return {
                    assetId: cell.asset || 'dirt',
                    type: cell.type === 'empty' || cell.type === 'passable' ? 'empty' : 'solid'
                };
            }
            if (typeof cell === 'string') {
                if (cell.includes(':')) {
                    const parts = cell.split(':');
                    return {
                        assetId: parts[0] || 'dirt',
                        type: parts[1] === 'empty' || parts[1] === 'passable' ? 'empty' : 'solid'
                    };
                }
                return { assetId: cell, type: 'solid' };
            }
            return { assetId: 'dirt', type: 'solid' };
        }

        function findTileAssetInGame(tileId) {
            const list = (activeCustomMapData && activeCustomMapData.tileAssets) || defaultTileAssets;
            let found = list.find(t => t.id === tileId);
            if (!found) {
                found = defaultTileAssets.find(t => t.id === tileId);
            }
            return found || defaultTileAssets[0];
        }

        function findNpcAssetInGame(npcId) {
            const list = (activeCustomMapData && activeCustomMapData.npcAssets) || defaultNpcAssets;
            let found = list.find(n => n.id === npcId);
            if (!found) {
                found = defaultNpcAssets.find(n => n.id === npcId);
            }
            return found || defaultNpcAssets[0];
        }

        // Generate Built-in Default Map (using dirt & dirt2 tiles)
        function createDefaultTileMap() {
            const grid = {};
            const ts = 40;
            // Ground layer: columns 0 to 28
            for (let c = 0; c < 28; c++) {
                grid[`${c},14`] = 'dirt';
                grid[`${c},15`] = 'dirt2';
            }
            // Floating platforms using dirt
            for (let c = 10; c <= 14; c++) grid[`${c},11`] = 'dirt';
            for (let c = 18; c <= 22; c++) grid[`${c},8`] = 'dirt';
            for (let c = 24; c <= 27; c++) grid[`${c},11`] = 'dirt';

            // Next island
            for (let c = 34; c < 60; c++) {
                grid[`${c},14`] = 'dirt';
                grid[`${c},15`] = 'dirt2';
            }
            for (let c = 40; c <= 44; c++) grid[`${c},10`] = 'dirt';
            for (let c = 48; c <= 52; c++) grid[`${c},7`] = 'dirt';

            // Final island
            for (let c = 66; c < 105; c++) {
                grid[`${c},14`] = 'dirt';
                grid[`${c},15`] = 'dirt2';
            }

            return {
                levelLength: 6000,
                tileSize: 40,
                tileAssets: JSON.parse(JSON.stringify(defaultTileAssets)),
                tileTypes: { 'dirt': 'solid', 'dirt2': 'solid' },
                npcAssets: JSON.parse(JSON.stringify(defaultNpcAssets)),
                gridMap: grid,
                spawnPoint: { x: 100, y: 400 },
                coins: [
                    { x: 480, y: 390 }, { x: 540, y: 390 },
                    { x: 800, y: 270 }, { x: 860, y: 270 },
                    { x: 1700, y: 350 }, { x: 1980, y: 230 },
                    { x: 2800, y: 500 }, { x: 3000, y: 500 }
                ],
                npcs: [
                    { id: 1, x: 1100, y: 470, w: 90, h: 90, assetId: 'npc_idle', questionIndex: 0 },
                    { id: 2, x: 2350, y: 470, w: 90, h: 90, assetId: 'npc_idle', questionIndex: 1 }
                ],
                finishFlag: { x: 3800, y: 380, w: 60, h: 180 }
            };
        }

        function loadLevelMap(index) {
            state.currentLevelIndex = index;
            const lvlObj = dbLevelsList[index];

            if (lvlObj && lvlObj.map_data && typeof lvlObj.map_data === 'object') {
                activeCustomMapData = lvlObj.map_data;
            } else {
                activeCustomMapData = createDefaultTileMap();
            }

            // Preload all tile & npc assets in this map
            if (activeCustomMapData.tileAssets) {
                activeCustomMapData.tileAssets.forEach(t => getTileImage(t.url));
            }
            if (activeCustomMapData.npcAssets) {
                activeCustomMapData.npcAssets.forEach(n => getNpcImage(n.url));
            }

            // Reset state
            state.coinsCollected = 0; state.score = 0; state.quizCorrectCount = 0;
            document.getElementById('coinCount').textContent = 0;
            document.getElementById('scoreCount').textContent = 0;

            // Player Spawn
            if (activeCustomMapData.spawnPoint && typeof activeCustomMapData.spawnPoint.x === 'number') {
                player.x = activeCustomMapData.spawnPoint.x;
                player.y = activeCustomMapData.spawnPoint.y;
            } else {
                player.x = 100; player.y = 300;
            }
            player.vx = 0; player.vy = 0;

            platforms = activeCustomMapData.platforms || [];
            coins = (activeCustomMapData.coins || []).map(c => ({ x: c.x, y: c.y, collected: false }));
            npcs = (activeCustomMapData.npcs || []).map((n, idx) => {
                const asset = findNpcAssetInGame(n.assetId);
                const defaultUrl = "{{ asset('assets/npcidle1.png') }}";
                const img = getNpcImage(asset ? asset.url : defaultUrl);
                const nw = n.w || 90;
                const nh = n.h || 90;
                let ny = n.y;
                if (ny === 450) ny = 470; // Adjust legacy y to fit ground cleanly
                return {
                    id: n.id || (idx + 1),
                    x: n.x,
                    y: ny,
                    w: nw,
                    h: nh,
                    assetId: n.assetId || 'npc_idle',
                    questionIndex: n.questionIndex || 0,
                    gateUnlocked: false,
                    img: img
                };
            });

            // Finish Point
            if (activeCustomMapData.finishFlag && typeof activeCustomMapData.finishFlag.x === 'number') {
                finishFlag = {
                    x: activeCustomMapData.finishFlag.x,
                    y: activeCustomMapData.finishFlag.y || 370,
                    w: 60, h: 180
                };
            }

            closeAllModals();
            state.paused = false;
        }

        // Overlay Navigation Controls
        function closeAllModals() {
            document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('active'));
        }

        function openStartScreen() {
            state.paused = true;
            closeAllModals();
            document.getElementById('startScreenModal').classList.add('active');
        }

        function openLevelSelect() {
            state.paused = true;
            closeAllModals();

            const container = document.getElementById('levelGridContainer');
            container.innerHTML = '';

            const totalLevels = dbLevelsList.length;
            for (let i = 0; i < totalLevels; i++) {
                const levelNumber = i + 1;
                const isUnlocked = unlockedLevels.includes(levelNumber);
                const levelObj = dbLevelsList[i];
                const title = levelObj ? levelObj.title : `Level ${levelNumber}`;

                const card = document.createElement('div');
                card.className = `level-card ${isUnlocked ? 'unlocked' : 'locked'}`;

                if (isUnlocked) {
                    card.innerHTML = `<iconify-icon icon="lucide:star" class="text-yellow-500 text-2xl"></iconify-icon><span class="font-['Paytone_One'] text-sm">${title}</span>`;
                    card.onclick = () => loadLevelMap(i);
                } else {
                    card.innerHTML = `<iconify-icon icon="lucide:lock" class="text-slate-400 text-2xl"></iconify-icon><span class="font-['Paytone_One'] text-xs text-slate-400">${title}</span>`;
                }
                container.appendChild(card);
            }

            document.getElementById('levelSelectModal').classList.add('active');
        }

        function openOptionModal() {
            closeAllModals();
            document.getElementById('optionModal').classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function restartLevel() {
            loadLevelMap(state.currentLevelIndex);
        }

        function nextLevel() {
            const nextIdx = state.currentLevelIndex + 1;
            if (nextIdx < dbLevelsList.length) {
                loadLevelMap(nextIdx);
            } else {
                openLevelSelect();
            }
        }

        // Game Loop Update
        function update() {
            if (state.paused) return;

            if (keys.left) { player.vx = -player.speed; player.facingLeft = true; }
            else if (keys.right) { player.vx = player.speed; player.facingLeft = false; }
            else { player.vx *= 0.7; }

            player.vy += player.gravity;

            let nextX = player.x + player.vx;
            let nextY = player.y + player.vy;

            // NPC Checkpoint Gates & Proximity Detection (Invisible Blocking & No Auto Popup)
            nearbyNpc = null;
            npcs.forEach(npc => {
                // Invisible barrier: Block player from passing locked NPC
                if (!npc.gateUnlocked) {
                    const barrierX = npc.x + npc.w;
                    if (player.x + player.width <= barrierX && nextX + player.width > barrierX) {
                        nextX = barrierX - player.width;
                        player.vx = 0;
                    }
                }

                // Check distance for [E] interaction prompt
                const distCenterX = Math.abs((player.x + player.width / 2) - (npc.x + npc.w / 2));
                const distCenterY = Math.abs((player.y + player.height / 2) - (npc.y + npc.h / 2));
                if (distCenterX < 140 && distCenterY < 130) {
                    nearbyNpc = npc;
                }
            });

            // Toggle Mobile Interact Button Visibility
            const btnInteractElem = document.getElementById('btnInteract');
            if (btnInteractElem) {
                if (nearbyNpc) {
                    btnInteractElem.classList.remove('hidden');
                } else {
                    btnInteractElem.classList.add('hidden');
                }
            }

            // Platform Collisions (Legacy)
            player.isGrounded = false;
            platforms.forEach(plat => {
                if (
                    player.x + player.width > plat.x && player.x < plat.x + plat.w &&
                    player.y + player.height <= plat.y && nextY + player.height >= plat.y
                ) {
                    nextY = plat.y - player.height; player.vy = 0; player.isGrounded = true;
                }
            });

            // Tilemap Solid Collisions
            if (activeCustomMapData && activeCustomMapData.gridMap) {
                const ts = activeCustomMapData.tileSize || 40;
                Object.keys(activeCustomMapData.gridMap).forEach(key => {
                    const cell = getCellData(activeCustomMapData.gridMap[key]);
                    if (cell && cell.type === 'solid') {
                        const [c, r] = key.split(',').map(Number);
                        const tx = c * ts, ty = r * ts;

                        if (
                            player.x + player.width > tx && player.x < tx + ts &&
                            player.y + player.height <= ty && nextY + player.height >= ty
                        ) {
                            nextY = ty - player.height; player.vy = 0; player.isGrounded = true;
                        }
                    }
                });
            }

            // No invisible ground: player falls freely if there is no solid tile!
            player.x = nextX; player.y = nextY;

            // Fall into void death & respawn
            const voidDeathY = Math.max(850, canvas.height + 150);
            if (player.y > voidDeathY) {
                sfx.playWrong();
                const sp = (activeCustomMapData && activeCustomMapData.spawnPoint) ? activeCustomMapData.spawnPoint : { x: 100, y: 300 };
                player.x = sp.x;
                player.y = sp.y;
                player.vx = 0;
                player.vy = 0;
            }
            if (player.x < 0) player.x = 0;

            if (Math.abs(player.vx) > 0.5) {
                player.frameTimer++;
                if (player.frameTimer % 14 === 0) player.runFrame = (player.runFrame + 1) % imgRun.length;
            } else {
                player.runFrame = 0;
            }

            // Coin Pickups
            coins.forEach(coin => {
                if (!coin.collected) {
                    const dist = Math.hypot((player.x + player.width/2) - coin.x, (player.y + player.height/2) - coin.y);
                    if (dist < 38) {
                        coin.collected = true; state.coinsCollected++; state.score += 50;
                        document.getElementById('coinCount').textContent = state.coinsCollected;
                        document.getElementById('scoreCount').textContent = state.score;
                        sfx.playCoin();
                    }
                }
            });

            // Finish Line
            if (player.x + player.width >= finishFlag.x) {
                triggerVictory();
            }

            state.cameraX = Math.max(0, player.x - canvas.width * 0.3);
        }

        // Render Loop
        function render() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            ctx.save();
            ctx.translate(-state.cameraX, 0);

            // Parallax Sky Hills
            ctx.fillStyle = 'rgba(110, 231, 183, 0.4)';
            ctx.beginPath(); ctx.arc(300 - state.cameraX * 0.15, 680, 380, 0, Math.PI, true); ctx.fill();
            ctx.beginPath(); ctx.arc(900 - state.cameraX * 0.15, 680, 420, 0, Math.PI, true); ctx.fill();
            ctx.beginPath(); ctx.arc(1600 - state.cameraX * 0.15, 680, 400, 0, Math.PI, true); ctx.fill();

            // Render Tilemap Tiles
            if (activeCustomMapData && activeCustomMapData.gridMap) {
                const ts = activeCustomMapData.tileSize || 40;

                // 1. Passable / Background Tiles
                Object.keys(activeCustomMapData.gridMap).forEach(key => {
                    const cell = getCellData(activeCustomMapData.gridMap[key]);
                    if (cell && cell.type === 'empty') {
                        const tile = findTileAssetInGame(cell.assetId);
                        const [c, r] = key.split(',').map(Number);
                        if (tile) {
                            const img = getTileImage(tile.url);
                            if (img && img.complete && img.naturalWidth > 0) {
                                ctx.save();
                                ctx.globalAlpha = 0.75;
                                ctx.drawImage(img, c * ts, r * ts, ts, ts);
                                ctx.restore();
                            } else {
                                ctx.fillStyle = '#334155';
                                ctx.fillRect(c * ts, r * ts, ts, ts);
                            }
                        }
                    }
                });

                // 2. Solid Ground Tiles
                Object.keys(activeCustomMapData.gridMap).forEach(key => {
                    const cell = getCellData(activeCustomMapData.gridMap[key]);
                    if (cell && cell.type === 'solid') {
                        const tile = findTileAssetInGame(cell.assetId);
                        const [c, r] = key.split(',').map(Number);
                        if (tile) {
                            const img = getTileImage(tile.url);
                            if (img && img.complete && img.naturalWidth > 0) {
                                ctx.drawImage(img, c * ts, r * ts, ts, ts);
                            } else {
                                ctx.fillStyle = '#854d0e';
                                ctx.fillRect(c * ts, r * ts, ts, ts);
                            }
                        }
                    }
                });
            }

            // Draw Legacy Platforms
            platforms.forEach(plat => {
                ctx.fillStyle = plat.color || '#166534';
                ctx.fillRect(plat.x, plat.y, plat.w, plat.h);
                ctx.fillStyle = '#22c55e';
                ctx.fillRect(plat.x, plat.y, plat.w, 8);
            });

            // Draw Animated Coins (Pola 1 -> 2 -> 3 -> 2 -> 1)
            const animIndex = Math.floor(Date.now() / 150) % coinSequence.length;
            const currentCoinFrame = coinFrames[coinSequence[animIndex]];
            const coinWidth = 22;
            const coinHeight = 44;
            const time = Date.now() * 0.005;

            coins.forEach(coin => {
                if (!coin.collected) {
                    const offsetY = Math.sin(time + coin.x) * 4;
                    if (currentCoinFrame && currentCoinFrame.complete && currentCoinFrame.naturalWidth > 0) {
                        ctx.drawImage(
                            currentCoinFrame,
                            coin.x - coinWidth / 2,
                            coin.y + offsetY - coinHeight / 2,
                            coinWidth,
                            coinHeight
                        );
                    } else {
                        ctx.save();
                        ctx.translate(coin.x, coin.y + offsetY);
                        ctx.fillStyle = '#facc15'; ctx.beginPath(); ctx.arc(0, 0, 14, 0, Math.PI * 2); ctx.fill();
                        ctx.strokeStyle = '#ca8a04'; ctx.lineWidth = 3; ctx.stroke();
                        ctx.restore();
                    }
                }
            });

            // Draw NPCs (Penjaga Gerbang Animated 1 -> 2 -> 3 -> 2 -> 1, Facing Left)
            const npcAnimIndex = Math.floor(Date.now() / 180) % npcIdleSequence.length;
            const currentNpcFrame = npcIdleFrames[npcIdleSequence[npcAnimIndex]];

            npcs.forEach(npc => {
                const isDefaultOrIdle = !npc.assetId || npc.assetId === 'npc_idle' || npc.assetId === 'npc_co' || npc.assetId === 'npc_ce';
                let frameImg = isDefaultOrIdle ? currentNpcFrame : (npc.img || currentNpcFrame);

                if (frameImg && frameImg.complete && frameImg.naturalWidth > 0) {
                    ctx.save();
                    ctx.translate(npc.x + npc.w / 2, npc.y + npc.h / 2);
                    ctx.scale(-1, 1); // Menghadap ke kiri (berhadapan dengan player)
                    ctx.drawImage(frameImg, -npc.w / 2, -npc.h / 2, npc.w, npc.h);
                    ctx.restore();
                } else if (npc.img && npc.img.complete) {
                    ctx.save();
                    ctx.translate(npc.x + npc.w / 2, npc.y + npc.h / 2);
                    ctx.scale(-1, 1);
                    ctx.drawImage(npc.img, -npc.w / 2, -npc.h / 2, npc.w, npc.h);
                    ctx.restore();
                }

                // Floating interaction indicator when player is nearby
                if (nearbyNpc === npc) {
                    const bobY = Math.sin(Date.now() * 0.008) * 4;
                    const promptX = npc.x + npc.w / 2;
                    const promptY = npc.y - 18 + bobY;

                    ctx.save();
                    // Draw rounded pill background
                    const badgeText = npc.gateUnlocked ? "💬 [E] Bicara" : "❓ [E] Tantangan";
                    ctx.font = "bold 13px 'Paytone One', 'Outfit', sans-serif";
                    const textWidth = ctx.measureText(badgeText).width;
                    const badgeW = textWidth + 20;
                    const badgeH = 26;
                    const badgeRadius = 13;

                    ctx.fillStyle = npc.gateUnlocked ? "rgba(16, 185, 129, 0.9)" : "rgba(239, 68, 68, 0.95)";
                    ctx.strokeStyle = "#ffffff";
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    ctx.roundRect(promptX - badgeW / 2, promptY - badgeH / 2, badgeW, badgeH, badgeRadius);
                    ctx.fill();
                    ctx.stroke();

                    // Draw text inside badge
                    ctx.fillStyle = "#ffffff";
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText(badgeText, promptX, promptY + 1);

                    // Downward small pointer arrow
                    ctx.beginPath();
                    ctx.moveTo(promptX - 5, promptY + badgeH / 2);
                    ctx.lineTo(promptX + 5, promptY + badgeH / 2);
                    ctx.lineTo(promptX, promptY + badgeH / 2 + 5);
                    ctx.closePath();
                    ctx.fillStyle = npc.gateUnlocked ? "rgba(16, 185, 129, 0.9)" : "rgba(239, 68, 68, 0.95)";
                    ctx.fill();

                    ctx.restore();
                }
            });

            // Draw Finish Flag
            ctx.fillStyle = '#64748b'; ctx.fillRect(finishFlag.x, finishFlag.y, 8, finishFlag.h);
            ctx.fillStyle = '#ef4444';
            ctx.beginPath(); ctx.moveTo(finishFlag.x + 8, finishFlag.y); ctx.lineTo(finishFlag.x + 60, finishFlag.y + 25); ctx.lineTo(finishFlag.x + 8, finishFlag.y + 50); ctx.fill();
            ctx.fillStyle = '#ef4444'; ctx.font = 'bold 12px "Paytone One", sans-serif';
            ctx.fillText('FINISH', finishFlag.x - 2, finishFlag.y - 8);

            // Draw Player Sprite
            ctx.save();
            ctx.translate(player.x + player.width/2, player.y + player.height/2);
            if (player.facingLeft) ctx.scale(-1, 1);
            let currentImg = (Math.abs(player.vx) > 0.5 && player.isGrounded) ? (imgRun[player.runFrame] || imgIdle) : imgIdle;
            if (currentImg && currentImg.complete) {
                ctx.drawImage(currentImg, -player.width/2, -player.height/2, player.width, player.height);
            }
            ctx.restore();

            ctx.restore();
        }

        function gameLoop() {
            update(); render(); requestAnimationFrame(gameLoop);
        }
        requestAnimationFrame(gameLoop);

        // Quiz Modal Logic
        function openQuizModal(npc) {
            state.paused = true;
            const qData = quizQuestionsData[npc.questionIndex % quizQuestionsData.length];
            document.getElementById('quizBadge').textContent = `Pos ${npc.id}`;
            document.getElementById('quizQuestionText').textContent = qData.question;
            
            const avatarElem = document.getElementById('quizNpcAvatar');
            if (avatarElem) {
                if (!npc.assetId || npc.assetId === 'npc_idle' || npc.assetId === 'npc_co' || npc.assetId === 'npc_ce') {
                    avatarElem.src = "{{ asset('assets/npcidle1.png') }}";
                } else if (npc.img && npc.img.src) {
                    avatarElem.src = npc.img.src;
                }
            }

            const container = document.getElementById('quizOptionsContainer');
            container.innerHTML = '';

            const options = [
                { key: 'a', label: 'A. ' + qData.option_a },
                { key: 'b', label: 'B. ' + qData.option_b },
                { key: 'c', label: 'C. ' + qData.option_c },
                { key: 'd', label: 'D. ' + qData.option_d },
            ];

            options.forEach(opt => {
                const btn = document.createElement('div');
                btn.className = 'quiz-option';
                btn.innerHTML = `<span class="bg-yellow-400 text-slate-900 w-8 h-8 rounded-full flex items-center justify-center font-bold flex-shrink-0">${opt.key.toUpperCase()}</span> <span>${opt.label.substring(3)}</span>`;
                btn.onclick = () => handleQuizAnswer(opt.key, qData.correct_option, btn, npc);
                container.appendChild(btn);
            });
            document.getElementById('quizFeedback').classList.add('hidden');
            document.getElementById('quizModal').classList.add('active');
        }

        function handleQuizAnswer(selected, correct, btnElem, npc) {
            const fb = document.getElementById('quizFeedback');
            fb.classList.remove('hidden');
            if (selected === correct) {
                btnElem.classList.add('selected-correct');
                fb.className = 'mt-4 p-3 rounded-xl text-center text-sm font-bold bg-green-100 text-green-800 border border-green-300';
                fb.textContent = '🎉 BENAR! Kuis Berhasil Dijawab!';
                sfx.playCorrect();
                npc.gateUnlocked = true; state.quizCorrectCount++; state.score += 100;
                document.getElementById('scoreCount').textContent = state.score;
                setTimeout(() => {
                    document.getElementById('quizModal').classList.remove('active');
                    state.paused = false;
                }, 1200);
            } else {
                btnElem.classList.add('selected-wrong');
                fb.className = 'mt-4 p-3 rounded-xl text-center text-sm font-bold bg-red-100 text-red-800 border border-red-300';
                fb.textContent = '❌ Belum tepat. Coba pilih lagi!';
                sfx.playWrong();
            }
        }

        // Victory Logic
        function triggerVictory() {
            state.paused = true;
            sfx.playCorrect();

            const nextLevelNum = state.currentLevelIndex + 2;
            if (!unlockedLevels.includes(nextLevelNum)) {
                unlockedLevels.push(nextLevelNum);
                localStorage.setItem('unlocked_levels', JSON.stringify(unlockedLevels));
            }

            document.getElementById('finalCoins').textContent = state.coinsCollected;
            document.getElementById('finalQuiz').textContent = state.quizCorrectCount;

            const btnNext = document.getElementById('btnNextLevel');
            if (state.currentLevelIndex + 1 < dbLevelsList.length) {
                btnNext.classList.remove('hidden');
            } else {
                btnNext.classList.add('hidden');
            }

            document.getElementById('victoryModal').classList.add('active');

            fetch("{{ route('minigame.submit') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ coins: state.coinsCollected, quiz_correct: state.quizCorrectCount })
            }).catch(e => console.log('Score saved'));
        }

        // Initialize Level on Boot
        loadLevelMap(0);
        state.paused = true;
        openStartScreen();
    </script>
</body>
</html>
