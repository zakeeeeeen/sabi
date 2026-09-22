<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>2D Map & Tilemap Level Editor - SABI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
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
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #f8fafc;
        }

        #editorApp {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }

        /* Top Navigation Header */
        .editor-header {
            height: 64px;
            background: #1e293b;
            border-bottom: 2px solid #334155;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 50;
        }

        .editor-title-input {
            background: #0f172a;
            border: 1.5px solid #475569;
            color: #facc15;
            font-family: 'Paytone One', sans-serif;
            font-size: 1.05rem;
            padding: 8px 16px;
            border-radius: 12px;
            width: 280px;
            outline: none;
        }

        .editor-title-input:focus {
            border-color: #facc15;
        }

        .editor-btn {
            background: #334155;
            color: #f8fafc;
            border: none;
            padding: 8px 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.15s ease;
        }

        .editor-btn:hover {
            background: #475569;
            transform: translateY(-1px);
        }

        .editor-btn.primary {
            background: #facc15;
            color: #0f172a;
        }

        .editor-btn.primary:hover {
            background: #eab308;
        }

        .editor-btn.playtest {
            background: #22c55e;
            color: #ffffff;
        }

        .editor-btn.playtest:hover {
            background: #16a34a;
        }

        /* Main Workspace Layout */
        .editor-workspace {
            flex: 1;
            display: flex;
            position: relative;
            overflow: hidden;
        }

        /* Left Toolbar */
        .editor-sidebar {
            width: 268px;
            background: #1e293b;
            border-right: 2px solid #334155;
            display: flex;
            flex-direction: column;
            padding: 14px;
            gap: 10px;
            z-index: 40;
            overflow-y: auto;
        }

        .sidebar-section-title {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-top: 8px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .tool-card {
            background: #0f172a;
            border: 2px solid #334155;
            border-radius: 12px;
            padding: 9px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .tool-card:hover {
            border-color: #facc15;
            background: #1e293b;
        }

        .tool-card.active {
            border-color: #facc15;
            background: #fefce8;
            color: #0f172a;
        }

        .tool-card.active .tool-name {
            color: #0f172a;
            font-weight: 800;
        }

        .tool-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .tool-card.active .tool-icon {
            background: #facc15;
            color: #0f172a;
        }

        .tool-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: #e2e8f0;
        }

        /* Brush Sifat Switcher */
        .brush-mode-toggle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            background: #0f172a;
            padding: 4px;
            border-radius: 12px;
            border: 1.5px solid #334155;
        }

        .brush-mode-btn {
            padding: 8px 6px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 800;
            text-align: center;
            cursor: pointer;
            border: 1.5px solid transparent;
            color: #94a3b8;
            background: transparent;
            transition: all 0.15s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .brush-mode-btn:hover {
            color: #f8fafc;
            background: rgba(255,255,255,0.05);
        }

        .brush-mode-btn.active.solid {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            border-color: #22c55e;
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.25);
        }

        .brush-mode-btn.active.passable {
            background: rgba(148, 163, 184, 0.2);
            color: #cbd5e1;
            border-color: #94a3b8;
            box-shadow: 0 0 10px rgba(148, 163, 184, 0.25);
        }

        /* Tilemap Palette Cards */
        .tile-palette-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 200px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .tile-asset-card {
            background: #0f172a;
            border: 2px solid #334155;
            border-radius: 12px;
            padding: 8px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.15s ease;
            position: relative;
        }

        .tile-asset-card:hover {
            border-color: #facc15;
            background: #1e293b;
        }

        .tile-asset-card.active {
            border-color: #facc15;
            background: rgba(250, 204, 21, 0.12);
            box-shadow: 0 0 0 1.5px #facc15;
        }

        .tile-thumb {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: 1.5px solid #475569;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            flex-shrink: 0;
        }

        .tile-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
            flex: 1;
        }

        .tile-card-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: #f8fafc;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Center Canvas Viewport */
        .canvas-viewport {
            flex: 1;
            position: relative;
            background: #090d16;
            overflow: hidden;
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
            cursor: crosshair;
        }

        /* Floating Viewport Overlay Bar (Zoom & Pan) */
        .viewport-controls-bar {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(12px);
            border: 1.5px solid #334155;
            border-radius: 16px;
            padding: 8px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            z-index: 30;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .zoom-btn {
            background: #334155;
            color: #f8fafc;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .zoom-btn:hover {
            background: #475569;
            color: #facc15;
        }

        .zoom-indicator {
            font-size: 0.82rem;
            font-weight: 800;
            color: #facc15;
            min-width: 52px;
            text-align: center;
            font-family: monospace;
        }

        /* Right Inspector Panel */
        .inspector-panel {
            width: 270px;
            background: #1e293b;
            border-left: 2px solid #334155;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            z-index: 40;
            overflow-y: auto;
        }

        .inspector-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .inspector-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #94a3b8;
        }

        .inspector-input {
            background: #0f172a;
            border: 1.5px solid #334155;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.88rem;
            outline: none;
        }

        .inspector-input:focus {
            border-color: #facc15;
        }

        /* Modals */
        .modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(6px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-card {
            background: #1e293b;
            border: 2px solid #facc15;
            border-radius: 20px;
            width: 520px;
            max-width: 90vw;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            padding: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }

        .modal-body {
            overflow-y: auto;
            flex: 1;
            margin: 16px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .question-item-card {
            background: #0f172a;
            border: 1.5px solid #334155;
            border-radius: 12px;
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .question-item-card:hover {
            border-color: #facc15;
            background: #1e293b;
        }
    </style>
</head>
<body>
    <div id="editorApp">
        <!-- Top Bar -->
        <div class="editor-header">
            <div class="flex items-center gap-2 md:gap-3">
                <a href="{{ route('minigame.editor') }}" class="editor-btn text-yellow-400 font-bold border-yellow-500/40 bg-yellow-500/10 hover:bg-yellow-500/20" title="Kembali ke Daftar Level">
                    <iconify-icon icon="lucide:layout-grid" class="text-lg"></iconify-icon>
                    <span>Daftar Level</span>
                </a>
                <a href="{{ route('minigame') }}" class="editor-btn" title="Mainkan Game">
                    <iconify-icon icon="lucide:gamepad-2" class="text-lg"></iconify-icon>
                    <span>Game</span>
                </a>
                <input type="text" id="levelTitleInput" class="editor-title-input" value="Petualangan Oklik - Level Baru" placeholder="Nama Level...">
            </div>

            <div class="flex items-center gap-2">
                <button type="button" id="btnCreateNewLevel" class="editor-btn">
                    <iconify-icon icon="lucide:plus" class="text-lg"></iconify-icon>
                    <span>Map Baru</span>
                </button>
                <button type="button" id="btnUploadTileModal" class="editor-btn">
                    <iconify-icon icon="lucide:image-plus" class="text-lg text-yellow-400"></iconify-icon>
                    <span>Upload Tile</span>
                </button>
                <button type="button" id="btnUploadNpcModal" class="editor-btn">
                    <iconify-icon icon="lucide:user-plus" class="text-lg text-sky-400"></iconify-icon>
                    <span>Upload NPC</span>
                </button>
                <button type="button" id="btnLoadModal" class="editor-btn">
                    <iconify-icon icon="lucide:folder-open" class="text-lg"></iconify-icon>
                    <span>Muat</span>
                </button>
                <button type="button" id="btnPlaytest" class="editor-btn playtest">
                    <iconify-icon icon="lucide:play" class="text-lg"></iconify-icon>
                    <span>Playtest</span>
                </button>
                <button type="button" id="btnSaveLevel" class="editor-btn primary">
                    <iconify-icon icon="lucide:save" class="text-lg"></iconify-icon>
                    <span>Simpan</span>
                </button>
                <button type="button" id="btnDeleteCurrentLevel" class="editor-btn bg-red-700 hover:bg-red-800 text-white">
                    <iconify-icon icon="lucide:trash-2" class="text-lg"></iconify-icon>
                    <span>Hapus</span>
                </button>
            </div>
        </div>

        <!-- Main Workspace -->
        <div class="editor-workspace">
            <!-- Sidebar Toolbar -->
            <div class="editor-sidebar">
                <div class="sidebar-section-title">Mode Kursor</div>
                <div class="tool-card active" data-tool="select">
                    <div class="tool-icon"><iconify-icon icon="lucide:mouse-pointer" class="text-lg text-sky-400"></iconify-icon></div>
                    <div class="tool-name">Kursor / Pilih</div>
                </div>

                <div class="sidebar-section-title">Alat Melukis Tile</div>
                <div class="tool-card" data-tool="paint">
                    <div class="tool-icon"><iconify-icon icon="lucide:paint-bucket" class="text-lg text-yellow-400"></iconify-icon></div>
                    <div class="tool-name">Lukis Tile (Paint)</div>
                </div>
                <div class="tool-card" data-tool="erase">
                    <div class="tool-icon"><iconify-icon icon="lucide:eraser" class="text-lg text-rose-400"></iconify-icon></div>
                    <div class="tool-name">Hapus (Erase)</div>
                </div>

                <!-- Sifat Brush (Ground vs Passable) -->
                <div class="sidebar-section-title">Sifat Kuas Melukis</div>
                <div class="brush-mode-toggle">
                    <button type="button" id="btnBrushSolid" class="brush-mode-btn active solid" onclick="setBrushType('solid')">
                        <iconify-icon icon="lucide:layers" class="text-base"></iconify-icon>
                        <span>🟩 Pijakan</span>
                    </button>
                    <button type="button" id="btnBrushPassable" class="brush-mode-btn passable" onclick="setBrushType('empty')">
                        <iconify-icon icon="lucide:image" class="text-base"></iconify-icon>
                        <span>🌫️ Latar</span>
                    </button>
                </div>

                <div class="sidebar-section-title mt-2 flex items-center justify-between">
                    <span>Tekstur Gambar Tile</span>
                    <button type="button" onclick="openUploadTileModal()" class="text-yellow-400 hover:text-yellow-300 text-xs font-bold flex items-center gap-1">
                        <iconify-icon icon="lucide:plus"></iconify-icon>
                        <span>Upload</span>
                    </button>
                </div>
                <!-- Tile Palette Container -->
                <div id="tilePaletteList" class="tile-palette-container">
                    <!-- Dynamic Tile Asset Cards will be rendered here -->
                </div>

                <div class="sidebar-section-title">Titik Awal & Akhir</div>
                <div class="tool-card" data-tool="spawn">
                    <div class="tool-icon"><iconify-icon icon="lucide:user-check" class="text-lg text-yellow-400"></iconify-icon></div>
                    <div class="tool-name">Player Spawn</div>
                </div>
                <div class="tool-card" data-tool="finish">
                    <div class="tool-icon"><iconify-icon icon="lucide:flag" class="text-lg text-red-400"></iconify-icon></div>
                    <div class="tool-name">Bendera Finish</div>
                </div>

                <div class="sidebar-section-title">Item & NPC</div>
                <div class="tool-card" data-tool="coin">
                    <div class="tool-icon"><iconify-icon icon="lucide:coins" class="text-lg text-yellow-400"></iconify-icon></div>
                    <div class="tool-name">Poin / Koin Animasi</div>
                </div>
                <div class="tool-card" data-tool="npc">
                    <div class="tool-icon"><iconify-icon icon="lucide:user" class="text-lg text-blue-400"></iconify-icon></div>
                    <div class="tool-name">Tempatkan NPC</div>
                </div>

                <div class="sidebar-section-title mt-2 flex items-center justify-between">
                    <span>Pilihan Karakter NPC</span>
                    <button type="button" onclick="openUploadNpcModal()" class="text-sky-400 hover:text-sky-300 text-xs font-bold flex items-center gap-1">
                        <iconify-icon icon="lucide:plus"></iconify-icon>
                        <span>Upload NPC</span>
                    </button>
                </div>
                <!-- NPC Palette Container -->
                <div id="npcPaletteList" class="tile-palette-container">
                    <!-- Dynamic NPC Asset Cards will be rendered here -->
                </div>
            </div>

            <!-- Canvas Viewport -->
            <div class="canvas-viewport">
                <!-- Pan & Zoom Canvas Tip Badge -->
                <div class="absolute top-3 left-4 bg-slate-900/90 backdrop-blur-md border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-slate-300 font-semibold pointer-events-none flex items-center gap-4 z-20 shadow-lg">
                    <div class="flex items-center gap-1.5">
                        <iconify-icon icon="lucide:zoom-in" class="text-yellow-400 text-sm"></iconify-icon>
                        <span><strong>Zoom:</strong> <kbd class="bg-slate-800 border border-slate-600 px-1 py-0.5 rounded text-[10px] text-yellow-300">Ctrl + Scroll</kbd></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <iconify-icon icon="lucide:move" class="text-emerald-400 text-sm"></iconify-icon>
                        <span><strong>Geser:</strong> <kbd class="bg-slate-800 border border-slate-600 px-1 py-0.5 rounded text-[10px] text-emerald-300">Tahan Scroll Mouse (Drag)</kbd></span>
                    </div>
                </div>

                <canvas id="editorCanvas"></canvas>

                <!-- Floating Viewport Controls (Zoom in/out, Zoom Reset, Center Spawn) -->
                <div class="viewport-controls-bar">
                    <div class="flex items-center gap-1.5">
                        <button type="button" id="btnZoomOut" class="zoom-btn" title="Zoom Out (Ctrl -)">
                            <iconify-icon icon="lucide:minus" class="text-base"></iconify-icon>
                        </button>
                        <span id="zoomVal" class="zoom-indicator">100%</span>
                        <button type="button" id="btnZoomIn" class="zoom-btn" title="Zoom In (Ctrl +)">
                            <iconify-icon icon="lucide:plus" class="text-base"></iconify-icon>
                        </button>
                        <button type="button" id="btnZoomReset" class="zoom-btn px-2 text-xs font-bold" title="Reset Zoom 100%">
                            1:1
                        </button>
                    </div>

                    <div class="w-px h-5 bg-slate-700"></div>

                    <button type="button" id="btnFocusSpawn" class="editor-btn text-xs py-1 px-2.5 bg-slate-800 hover:bg-slate-700 text-yellow-400">
                        <iconify-icon icon="lucide:locate" class="text-sm"></iconify-icon>
                        <span>Fokus Spawn</span>
                    </button>

                    <div id="coordsIndicator" class="text-xs font-mono text-slate-400 min-w-[120px] text-right">
                        X: 0, Y: 0
                    </div>
                </div>
            </div>

            <!-- Inspector Panel -->
            <div class="inspector-panel">
                <div class="sidebar-section-title">Kuas Aktif Saat Ini</div>
                <div id="activeTileInspectorBox" class="bg-slate-900 border border-slate-700 rounded-xl p-3 flex flex-col gap-2">
                    <div class="flex items-center gap-3">
                        <div id="inspectorTileThumb" class="w-10 h-10 rounded-lg border border-slate-600 bg-cover bg-center"></div>
                        <div>
                            <div id="inspectorTileName" class="font-bold text-white text-sm">Dirt 1</div>
                            <div id="inspectorBrushModeBadge" class="text-xs font-bold text-green-400">🟩 Mode: Solid (Pijakan)</div>
                        </div>
                    </div>
                    <div class="text-[11px] text-slate-400 mt-1 leading-relaxed">
                        Anda dapat melukis tekstur ini sebagai <strong>Pijakan (Solid)</strong> atau <strong>Latar (Passable)</strong> secara bebas di koordinat mana saja!
                    </div>
                </div>

                <div class="sidebar-section-title mt-4">Properti Objek Terpilih</div>
                <div id="noSelectionInfo" class="text-xs text-slate-400">Klik objek (Spawn/Finish/Coin/NPC) di canvas untuk mengedit properti.</div>

                <div id="inspectorForm" class="hidden flex flex-col gap-3">
                    <div class="inspector-field">
                        <label class="inspector-label">Tipe Objek</label>
                        <input type="text" id="inpType" class="inspector-input" readonly>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div class="inspector-field">
                            <label class="inspector-label">Posisi X</label>
                            <input type="number" id="inpX" class="inspector-input">
                        </div>
                        <div class="inspector-field">
                            <label class="inspector-label">Posisi Y</label>
                            <input type="number" id="inpY" class="inspector-input">
                        </div>
                    </div>

                    <div id="npcCharacterField" class="inspector-field hidden">
                        <label class="inspector-label">Sprite Karakter NPC</label>
                        <select id="selNpcAsset" class="inspector-input w-full"></select>
                    </div>

                    <div id="npcQuizField" class="inspector-field hidden">
                        <label class="inspector-label">Soal Kuis NPC</label>
                        <button type="button" id="btnPickQuiz" class="editor-btn w-full justify-center">
                            Pilih Soal Kuis
                        </button>
                        <div id="selectedQuizTitle" class="text-xs text-yellow-400 mt-1 font-bold">Default Pos Kuis</div>
                    </div>

                    <button type="button" id="btnDeleteSelected" class="editor-btn w-full justify-center bg-red-600 hover:bg-red-700 text-white mt-4">
                        <iconify-icon icon="lucide:trash-2" class="text-lg"></iconify-icon>
                        <span>Hapus Objek</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Upload Custom Tile Modal -->
        <div id="uploadTileModal" class="modal-overlay">
            <div class="modal-card">
                <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                    <h3 class="font-['Paytone_One'] text-yellow-400 text-lg">Unggah Asset Tekstur Baru</h3>
                    <button type="button" onclick="closeModal('uploadTileModal')" class="text-slate-400 hover:text-white font-bold text-xl">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="inspector-field">
                        <label class="inspector-label">Nama Asset / Tile</label>
                        <input type="text" id="inpNewTileName" class="inspector-input" placeholder="Misal: Rumput Hijau, Batu Sungai, dsb...">
                    </div>
                    <div class="inspector-field">
                        <label class="inspector-label">Pilih File Gambar (PNG / JPG / WEBP)</label>
                        <input type="file" id="inpNewTileFile" accept="image/*" class="inspector-input">
                    </div>
                    <div id="tilePreviewContainer" class="hidden mt-2 p-3 bg-slate-900 border border-slate-700 rounded-xl flex items-center gap-3">
                        <img id="imgTilePreview" class="w-14 h-14 object-cover rounded-lg border border-yellow-400" src="" alt="Preview">
                        <div class="text-xs text-slate-300">
                            <div class="font-bold text-white mb-0.5">Pratinjau Asset</div>
                            <div class="text-[11px] text-slate-400">Gambar siap diunggah & dimasukkan ke palet</div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-slate-700">
                    <button type="button" onclick="closeModal('uploadTileModal')" class="editor-btn">Batal</button>
                    <button type="button" id="btnSubmitUploadTile" class="editor-btn primary flex items-center gap-1.5">
                        <iconify-icon icon="lucide:upload-cloud"></iconify-icon>
                        <span>Unggah & Tambah ke Palet</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Upload Custom NPC Modal -->
        <div id="uploadNpcModal" class="modal-overlay">
            <div class="modal-card">
                <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                    <h3 class="font-['Paytone_One'] text-yellow-400 text-lg">Unggah Karakter NPC Baru</h3>
                    <button type="button" onclick="closeModal('uploadNpcModal')" class="text-slate-400 hover:text-white font-bold text-xl">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="inspector-field">
                        <label class="inspector-label">Nama Karakter NPC</label>
                        <input type="text" id="inpNewNpcName" class="inspector-input" placeholder="Misal: Tetua Desa, Seniman Oklik, Warga, dsb...">
                    </div>
                    <div class="inspector-field">
                        <label class="inspector-label">Pilih Gambar Sprite NPC (PNG / JPG / WEBP / GIF)</label>
                        <input type="file" id="inpNewNpcFile" accept="image/*" class="inspector-input">
                    </div>
                    <div id="npcPreviewContainer" class="hidden mt-2 p-3 bg-slate-900 border border-slate-700 rounded-xl flex items-center gap-3">
                        <img id="imgNpcPreview" class="w-14 h-18 object-contain rounded-lg border border-yellow-400 bg-slate-800 p-1" src="" alt="Preview NPC">
                        <div class="text-xs text-slate-300">
                            <div class="font-bold text-white mb-0.5">Pratinjau Karakter NPC</div>
                            <div class="text-[11px] text-slate-400">Karakter siap diunggah & dimasukkan ke daftar NPC</div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-3 border-t border-slate-700">
                    <button type="button" onclick="closeModal('uploadNpcModal')" class="editor-btn">Batal</button>
                    <button type="button" id="btnSubmitUploadNpc" class="editor-btn primary flex items-center gap-1.5">
                        <iconify-icon icon="lucide:user-plus"></iconify-icon>
                        <span>Unggah & Tambah ke Daftar NPC</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Load Level Modal -->
        <div id="loadModal" class="modal-overlay">
            <div class="modal-card">
                <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                    <h3 class="font-['Paytone_One'] text-yellow-400 text-lg">Daftar Level Tersimpan</h3>
                    <button type="button" onclick="closeModal('loadModal')" class="text-slate-400 hover:text-white font-bold text-xl">&times;</button>
                </div>
                <div class="modal-body">
                    @forelse($levels as $lvl)
                        <div class="question-item-card flex items-center justify-between" onclick="loadLevelData({{ $lvl->id }})">
                            <div>
                                <div class="font-bold text-white text-base">{{ $lvl->title }}</div>
                                <div class="text-xs text-slate-400">Diperbarui: {{ $lvl->updated_at->diffForHumans() }}</div>
                            </div>
                            <span class="text-yellow-400 text-sm font-bold">Buka &rarr;</span>
                        </div>
                    @empty
                        <div class="text-slate-400 text-sm text-center py-6">Belum ada level custom tersimpan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quiz Question Picker Modal -->
        <div id="quizPickModal" class="modal-overlay">
            <div class="modal-card">
                <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                    <h3 class="font-['Paytone_One'] text-yellow-400 text-lg">Pilih Soal Kuis Untuk NPC</h3>
                    <button type="button" onclick="closeModal('quizPickModal')" class="text-slate-400 hover:text-white font-bold text-xl">&times;</button>
                </div>
                <div class="modal-body">
                    @foreach($questions as $idx => $q)
                        <div class="question-item-card" onclick="selectQuizForNpc({{ $idx }})">
                            <div class="text-xs text-yellow-400 font-bold mb-1">Soal #{{ $idx + 1 }}</div>
                            <div class="text-sm font-semibold text-white">{{ $q->question }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        const questionsList = @json($questions);

        // Character Assets
        const imgIdle = new Image(); imgIdle.src = "{{ asset('assets/idle.png') }}";
        const imgNpc = new Image(); imgNpc.src = "{{ asset('assets/npcidle1.png') }}";

        // Animated NPC Idle Sprites (Pola 1 -> 2 -> 3 -> 2 -> 1)
        const npcIdleFrames = [new Image(), new Image(), new Image()];
        npcIdleFrames[0].src = "{{ asset('assets/npcidle1.png') }}";
        npcIdleFrames[1].src = "{{ asset('assets/npcidle2.png') }}";
        npcIdleFrames[2].src = "{{ asset('assets/npcidle3.png') }}";
        const npcIdleSequence = [0, 1, 2, 1];

        // Animated Coin Sprites (Frame 1, 2, 3 - Sequence: 1 -> 2 -> 3 -> 2 -> 1)
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
        npcIdleFrames.forEach(f => getNpcImage(f.src));

        const canvas = document.getElementById('editorCanvas');
        const ctx = canvas.getContext('2d');

        function resizeCanvas() {
            canvas.width = canvas.parentElement.clientWidth;
            canvas.height = canvas.parentElement.clientHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

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

        // Editor State (with Zoom and 2D Camera, initialized from active level)
        const serverLevel = @json($activeLevel ?? null);
        const state = {
            currentLevelId: serverLevel ? serverLevel.id : null,
            title: serverLevel ? serverLevel.title : "Petualangan Oklik - Level Baru",
            cameraX: 0,
            cameraY: 0,
            zoom: 1.0,
            activeTool: 'select',
            brushType: 'solid', // 'solid' (Ground Pijakan) | 'empty' (Passable Latar)
            gridSize: 40,
            selectedTileAssetId: 'dirt',
            selectedNpcAssetId: 'npc_idle',
            selectedObject: null,
            isPlaytesting: false,
            isMouseDown: false,
            isPanning: false,
            panStartX: 0,
            panStartY: 0,
            panCamStartX: 0,
            panCamStartY: 0,
            isSpacePressed: false,
            mouseHover: { inCanvas: false, x: 0, y: 0, col: 0, row: 0 },

            mapData: (serverLevel && serverLevel.map_data) ? {
                levelLength: serverLevel.map_data.levelLength || 6000,
                tileSize: serverLevel.map_data.tileSize || 40,
                tileAssets: (serverLevel.map_data.tileAssets && serverLevel.map_data.tileAssets.length > 0) ? serverLevel.map_data.tileAssets : JSON.parse(JSON.stringify(defaultTileAssets)),
                npcAssets: (serverLevel.map_data.npcAssets && serverLevel.map_data.npcAssets.length > 0) ? serverLevel.map_data.npcAssets : JSON.parse(JSON.stringify(defaultNpcAssets)),
                gridMap: serverLevel.map_data.gridMap || {},
                spawnPoint: serverLevel.map_data.spawnPoint || { x: 100, y: 300 },
                coins: serverLevel.map_data.coins || [],
                npcs: serverLevel.map_data.npcs || [],
                finishFlag: serverLevel.map_data.finishFlag || { x: 4000, y: 370, w: 60, h: 180 }
            } : {
                levelLength: 6000,
                tileSize: 40,
                tileAssets: JSON.parse(JSON.stringify(defaultTileAssets)),
                npcAssets: JSON.parse(JSON.stringify(defaultNpcAssets)),
                gridMap: {}, // { "col,row": { asset: "dirt", type: "solid" } }
                spawnPoint: { x: 100, y: 300 },
                coins: [
                    { x: 340, y: 410 },
                    { x: 400, y: 410 },
                    { x: 640, y: 310 }
                ],
                npcs: [
                    { id: 1, x: 1100, y: 470, w: 90, h: 90, assetId: 'npc_idle', questionIndex: 0 }
                ],
                finishFlag: { x: 4000, y: 370, w: 60, h: 180 }
            }
        };

        // Helper to find tile asset by ID
        function findTileAsset(tileId) {
            const list = state.mapData.tileAssets || defaultTileAssets;
            let found = list.find(t => t.id === tileId);
            if (!found) {
                found = defaultTileAssets.find(t => t.id === tileId);
            }
            return found || defaultTileAssets[0];
        }

        // Helper to find NPC asset by ID
        function findNpcAsset(assetId) {
            const list = state.mapData.npcAssets || defaultNpcAssets;
            let found = list.find(n => n.id === assetId);
            if (!found) {
                found = defaultNpcAssets.find(n => n.id === assetId);
            }
            return found || defaultNpcAssets[0];
        }

        function setBrushType(type) {
            state.brushType = (type === 'empty' || type === 'passable') ? 'empty' : 'solid';
            document.getElementById('btnBrushSolid').classList.toggle('active', state.brushType === 'solid');
            document.getElementById('btnBrushPassable').classList.toggle('active', state.brushType === 'empty');

            // Switch to paint tool automatically
            document.querySelectorAll('.tool-card').forEach(c => c.classList.remove('active'));
            const paintCard = document.querySelector('[data-tool="paint"]');
            if (paintCard) {
                paintCard.classList.add('active');
                state.activeTool = 'paint';
            }

            updateActiveTileInspector();
        }

        // Render Tile Palette List in Sidebar
        function renderTilePalette() {
            const container = document.getElementById('tilePaletteList');
            container.innerHTML = '';

            const allTiles = state.mapData.tileAssets || defaultTileAssets;
            allTiles.forEach(tile => {
                const card = document.createElement('div');
                card.className = `tile-asset-card ${state.selectedTileAssetId === tile.id ? 'active' : ''}`;
                card.dataset.tileId = tile.id;

                card.innerHTML = `
                    <div class="tile-thumb" style="background-image: url('${tile.url}');"></div>
                    <div class="tile-info">
                        <div class="tile-card-name">${tile.name}</div>
                        <div class="text-[10px] text-slate-400">Klik untuk memilih tekstur</div>
                    </div>
                `;

                card.onclick = () => {
                    selectTileAsset(tile.id);
                };

                container.appendChild(card);
            });

            updateActiveTileInspector();
        }

        function selectTileAsset(tileId) {
            state.selectedTileAssetId = tileId;
            document.querySelectorAll('#tilePaletteList .tile-asset-card').forEach(c => {
                c.classList.toggle('active', c.dataset.tileId === tileId);
            });

            // Switch tool to Paint
            document.querySelectorAll('.tool-card').forEach(c => c.classList.remove('active'));
            const paintCard = document.querySelector('[data-tool="paint"]');
            if (paintCard) {
                paintCard.classList.add('active');
                state.activeTool = 'paint';
            }

            updateActiveTileInspector();
        }

        // Render NPC Palette List in Sidebar
        function renderNpcPalette() {
            const container = document.getElementById('npcPaletteList');
            if (!container) return;
            container.innerHTML = '';

            const allNpcs = state.mapData.npcAssets || defaultNpcAssets;
            allNpcs.forEach(npc => {
                const card = document.createElement('div');
                card.className = `tile-asset-card ${state.selectedNpcAssetId === npc.id ? 'active' : ''}`;
                card.dataset.npcId = npc.id;

                card.innerHTML = `
                    <div class="tile-thumb" style="background-image: url('${npc.url}'); background-size: contain; background-color: #1e293b;"></div>
                    <div class="tile-info">
                        <div class="tile-card-name">${npc.name}</div>
                        <div class="text-[10px] text-slate-400">Pilih untuk menempatkan</div>
                    </div>
                `;

                card.onclick = () => {
                    selectNpcAsset(npc.id);
                };

                container.appendChild(card);
            });

            updateNpcSelectDropdown();
        }

        function selectNpcAsset(npcId) {
            state.selectedNpcAssetId = npcId;
            document.querySelectorAll('#npcPaletteList .tile-asset-card').forEach(c => {
                c.classList.toggle('active', c.dataset.npcId === npcId);
            });

            // Switch tool to NPC
            document.querySelectorAll('.tool-card').forEach(c => c.classList.remove('active'));
            const npcCard = document.querySelector('[data-tool="npc"]');
            if (npcCard) {
                npcCard.classList.add('active');
                state.activeTool = 'npc';
            }
        }

        function updateNpcSelectDropdown() {
            const sel = document.getElementById('selNpcAsset');
            if (!sel) return;
            sel.innerHTML = '';
            const allNpcs = state.mapData.npcAssets || defaultNpcAssets;
            allNpcs.forEach(n => {
                const opt = document.createElement('option');
                opt.value = n.id;
                opt.textContent = n.name;
                sel.appendChild(opt);
            });
        }

        function updateActiveTileInspector() {
            const tile = findTileAsset(state.selectedTileAssetId);
            if (!tile) return;

            document.getElementById('inspectorTileThumb').style.backgroundImage = `url('${tile.url}')`;
            document.getElementById('inspectorTileName').textContent = tile.name;

            const badge = document.getElementById('inspectorBrushModeBadge');
            if (state.brushType === 'solid') {
                badge.className = 'text-xs font-bold text-green-400';
                badge.textContent = '🟩 Mode: Solid (Pijakan)';
            } else {
                badge.className = 'text-xs font-bold text-slate-300';
                badge.textContent = '🌫️ Mode: Passable (Latar)';
            }
        }

        // Zoom Helpers & Buttons
        function updateZoomDisplay() {
            document.getElementById('zoomVal').textContent = Math.round(state.zoom * 100) + '%';
        }

        function setZoom(newZoom, centerX = canvas.width / 2, centerY = canvas.height / 2) {
            const clamped = Math.min(Math.max(newZoom, 0.25), 2.5);
            if (clamped === state.zoom) return;

            const worldXBefore = (centerX / state.zoom) + state.cameraX;
            const worldYBefore = (centerY / state.zoom) + state.cameraY;

            state.zoom = clamped;

            state.cameraX = worldXBefore - (centerX / state.zoom);
            state.cameraY = worldYBefore - (centerY / state.zoom);

            updateZoomDisplay();
        }

        document.getElementById('btnZoomIn').addEventListener('click', () => {
            setZoom(state.zoom * 1.25);
        });

        document.getElementById('btnZoomOut').addEventListener('click', () => {
            setZoom(state.zoom / 1.25);
        });

        document.getElementById('btnZoomReset').addEventListener('click', () => {
            setZoom(1.0);
        });

        document.getElementById('btnFocusSpawn').addEventListener('click', () => {
            const sp = state.mapData.spawnPoint || { x: 100, y: 300 };
            state.cameraX = sp.x - (canvas.width / (2 * state.zoom));
            state.cameraY = sp.y - (canvas.height / (2 * state.zoom));
        });

        // Player physics for playtest
        const player = {
            x: 100, y: 300, w: 70, h: 105, vx: 0, vy: 0,
            speed: 5.0, jumpPower: -16.0, gravity: 0.75,
            isGrounded: false
        };

        const keys = { left: false, right: false, up: false };

        window.addEventListener('keydown', (e) => {
            if (e.code === 'Space' && document.activeElement.tagName !== 'INPUT') {
                state.isSpacePressed = true;
                if (!state.isPlaytesting) canvas.style.cursor = 'grab';
            }

            if (state.isPlaytesting) {
                if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = true;
                if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = true;
                if ((e.key === 'ArrowUp' || e.key === 'w' || e.key === 'W' || e.code === 'Space') && player.isGrounded) {
                    player.vy = player.jumpPower; player.isGrounded = false;
                }
            } else if (e.key === 'Delete' || e.key === 'Backspace') {
                if (document.activeElement.tagName !== 'INPUT') deleteSelected();
            }
        });

        window.addEventListener('keyup', (e) => {
            if (e.code === 'Space') {
                state.isSpacePressed = false;
                if (!state.isPlaytesting) canvas.style.cursor = (state.activeTool === 'select' ? 'default' : 'crosshair');
            }
            if (e.key === 'ArrowLeft' || e.key === 'a' || e.key === 'A') keys.left = false;
            if (e.key === 'ArrowRight' || e.key === 'd' || e.key === 'D') keys.right = false;
        });

        // Tool Switching
        document.querySelectorAll('.tool-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.tool-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
                state.activeTool = card.getAttribute('data-tool');
            });
        });

        // Wheel Event: Zoom with Ctrl + Scroll, Pan with regular Wheel
        canvas.addEventListener('wheel', (e) => {
            if (state.isPlaytesting) return;
            e.preventDefault();

            const rect = canvas.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;

            if (e.ctrlKey) {
                // Zoom with Ctrl + Scroll
                const zoomFactor = e.deltaY < 0 ? 1.15 : 0.87;
                setZoom(state.zoom * zoomFactor, mouseX, mouseY);
            } else {
                // Regular scroll pans the canvas
                state.cameraX += (e.deltaX !== 0 ? e.deltaX : 0) / state.zoom;
                state.cameraY += e.deltaY / state.zoom;
            }
        }, { passive: false });

        function openUploadTileModal() {
            document.getElementById('uploadTileModal').classList.add('active');
        }
        document.getElementById('btnUploadTileModal').addEventListener('click', openUploadTileModal);

        function openUploadNpcModal() {
            document.getElementById('uploadNpcModal').classList.add('active');
        }
        document.getElementById('btnUploadNpcModal').addEventListener('click', openUploadNpcModal);

        function closeModal(id) { document.getElementById(id).classList.remove('active'); }

        // Live Preview Upload Tile File
        document.getElementById('inpNewTileFile').addEventListener('change', (e) => {
            const file = e.target.files[0];
            const previewBox = document.getElementById('tilePreviewContainer');
            const previewImg = document.getElementById('imgTilePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = (re) => {
                    previewImg.src = re.target.result;
                    previewBox.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewBox.classList.add('hidden');
            }
        });

        // Live Preview Upload NPC File
        document.getElementById('inpNewNpcFile').addEventListener('change', (e) => {
            const file = e.target.files[0];
            const previewBox = document.getElementById('npcPreviewContainer');
            const previewImg = document.getElementById('imgNpcPreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = (re) => {
                    previewImg.src = re.target.result;
                    previewBox.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                previewBox.classList.add('hidden');
            }
        });

        // Process Upload Custom Tile
        document.getElementById('btnSubmitUploadTile').addEventListener('click', () => {
            const fileInput = document.getElementById('inpNewTileFile');
            const nameInput = document.getElementById('inpNewTileName');

            if (!fileInput.files || fileInput.files.length === 0) {
                alert('Pilih file gambar tekstur tile terlebih dahulu!');
                return;
            }

            const tileName = nameInput.value.trim() || 'Tile Custom';
            const formData = new FormData();
            formData.append('image', fileInput.files[0]);

            fetch("{{ route('minigame.tilemaps.upload') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    const newTileId = 'tile_' + Date.now();
                    const newTile = {
                        id: newTileId,
                        name: tileName,
                        url: res.url,
                        isDefault: false
                    };

                    if (!state.mapData.tileAssets) {
                        state.mapData.tileAssets = JSON.parse(JSON.stringify(defaultTileAssets));
                    }
                    state.mapData.tileAssets.push(newTile);

                    getTileImage(res.url);
                    renderTilePalette();
                    selectTileAsset(newTileId);
                    closeModal('uploadTileModal');

                    nameInput.value = '';
                    fileInput.value = '';
                    document.getElementById('tilePreviewContainer').classList.add('hidden');
                    alert(`Asset Tile "${tileName}" berhasil diunggah & siap digunakan!`);
                }
            })
            .catch(err => {
                alert('Gagal mengunggah tile: ' + err.message);
            });
        });

        // Process Upload Custom NPC
        document.getElementById('btnSubmitUploadNpc').addEventListener('click', () => {
            const fileInput = document.getElementById('inpNewNpcFile');
            const nameInput = document.getElementById('inpNewNpcName');

            if (!fileInput.files || fileInput.files.length === 0) {
                alert('Pilih file gambar sprite NPC terlebih dahulu!');
                return;
            }

            const npcName = nameInput.value.trim() || 'NPC Custom';
            const formData = new FormData();
            formData.append('image', fileInput.files[0]);

            fetch("{{ route('minigame.tilemaps.upload') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    const newNpcId = 'npc_' + Date.now();
                    const newNpc = {
                        id: newNpcId,
                        name: npcName,
                        url: res.url,
                        isDefault: false
                    };

                    if (!state.mapData.npcAssets) {
                        state.mapData.npcAssets = JSON.parse(JSON.stringify(defaultNpcAssets));
                    }
                    state.mapData.npcAssets.push(newNpc);

                    getNpcImage(res.url);
                    renderNpcPalette();
                    selectNpcAsset(newNpcId);
                    closeModal('uploadNpcModal');

                    nameInput.value = '';
                    fileInput.value = '';
                    document.getElementById('npcPreviewContainer').classList.add('hidden');
                    alert(`Karakter NPC "${npcName}" berhasil diunggah & ditambahkan ke palet NPC!`);
                }
            })
            .catch(err => {
                alert('Gagal mengunggah NPC: ' + err.message);
            });
        });

        // Convert Screen Mouse Position to World Coordinates
        function getMouseWorldPos(e) {
            const rect = canvas.getBoundingClientRect();
            const screenX = e.clientX - rect.left;
            const screenY = e.clientY - rect.top;
            return {
                x: (screenX / state.zoom) + state.cameraX,
                y: (screenY / state.zoom) + state.cameraY,
                screenX, screenY
            };
        }

        // Canvas Interactions (Middle Mouse Pan Hold, Spacebar Pan, Tool Pan, Paint, Erase, Select)
        canvas.addEventListener('mousedown', (e) => {
            if (state.isPlaytesting) return;

            // Pan: Scroll wheel click (e.button === 1), or activeTool === 'pan', or Spacebar pressed
            if (e.button === 1 || state.activeTool === 'pan' || state.isSpacePressed) {
                state.isPanning = true;
                state.panStartX = e.clientX;
                state.panStartY = e.clientY;
                state.panCamStartX = state.cameraX;
                state.panCamStartY = state.cameraY;
                canvas.style.cursor = 'grabbing';
                e.preventDefault();
                return;
            }

            if (e.button === 0) {
                state.isMouseDown = true;
                handleCanvasPointer(e);
            }
        });

        window.addEventListener('mousemove', (e) => {
            if (state.isPanning) {
                const dx = (e.clientX - state.panStartX) / state.zoom;
                const dy = (e.clientY - state.panStartY) / state.zoom;
                state.cameraX = state.panCamStartX - dx;
                state.cameraY = state.panCamStartY - dy;
                return;
            }

            const mousePos = getMouseWorldPos(e);
            document.getElementById('coordsIndicator').textContent = `X: ${Math.round(mousePos.x)}, Y: ${Math.round(mousePos.y)}`;

            const rect = canvas.getBoundingClientRect();
            const inCanvas = e.clientX >= rect.left && e.clientX <= rect.right && e.clientY >= rect.top && e.clientY <= rect.bottom;
            const ts = state.mapData.tileSize || 40;
            state.mouseHover = {
                inCanvas: inCanvas,
                x: mousePos.x,
                y: mousePos.y,
                col: Math.floor(mousePos.x / ts),
                row: Math.floor(mousePos.y / ts)
            };

            if (state.isPlaytesting) return;

            if (state.activeTool === 'select') {
                const sp = state.mapData.spawnPoint || { x: 100, y: 300 };
                const isOverSpawn = (mousePos.x >= sp.x && mousePos.x <= sp.x + 70 && mousePos.y >= sp.y && mousePos.y <= sp.y + 105);
                const f = state.mapData.finishFlag;
                const isOverFinish = (mousePos.x >= f.x && mousePos.x <= f.x + 60 && mousePos.y >= f.y && mousePos.y <= f.y + 180);
                const isOverCoin = state.mapData.coins.some(c => Math.hypot(mousePos.x - c.x, mousePos.y - c.y) <= 24);
                const isOverNpc = state.mapData.npcs.some(n => mousePos.x >= n.x && mousePos.x <= n.x + n.w && mousePos.y >= n.y && mousePos.y <= n.y + n.h);

                if (state.isMouseDown && state.selectedObject) {
                    canvas.style.cursor = 'grabbing';
                    const sel = state.selectedObject;
                    if (sel.kind === 'coin') {
                        sel.obj.x = state.mouseHover.col * ts + ts / 2;
                        sel.obj.y = state.mouseHover.row * ts + ts / 2;
                    } else if (sel.kind === 'npc') {
                        sel.obj.x = state.mouseHover.col * ts;
                        sel.obj.y = (state.mouseHover.row + 1) * ts - 110;
                    } else if (sel.kind === 'spawn') {
                        sel.obj.x = state.mouseHover.col * ts;
                        sel.obj.y = (state.mouseHover.row + 1) * ts - 105;
                    } else if (sel.kind === 'finish') {
                        sel.obj.x = state.mouseHover.col * ts;
                        sel.obj.y = (state.mouseHover.row + 1) * ts - 180;
                    }
                    updateInspector();
                } else {
                    canvas.style.cursor = (isOverSpawn || isOverFinish || isOverCoin || isOverNpc) ? 'pointer' : 'default';
                }
            } else {
                canvas.style.cursor = 'crosshair';
                if (state.isMouseDown && (state.activeTool === 'paint' || state.activeTool === 'erase')) {
                    handleCanvasPointer(e);
                }
            }
        });

        canvas.addEventListener('mouseleave', () => {
            state.mouseHover.inCanvas = false;
        });

        window.addEventListener('mouseup', (e) => {
            if (state.isPanning) {
                state.isPanning = false;
                canvas.style.cursor = (state.isSpacePressed || state.activeTool === 'pan') ? 'grab' : (state.activeTool === 'select' ? 'default' : 'crosshair');
            }
            state.isMouseDown = false;
        });

        canvas.addEventListener('contextmenu', (e) => e.preventDefault());
        canvas.addEventListener('auxclick', (e) => { if (e.button === 1) e.preventDefault(); });

        function handleCanvasPointer(e) {
            const worldPos = getMouseWorldPos(e);
            const worldX = worldPos.x;
            const worldY = worldPos.y;

            const ts = state.mapData.tileSize || 40;
            const col = Math.floor(worldX / ts);
            const row = Math.floor(worldY / ts);
            const gridKey = `${col},${row}`;

            if (state.activeTool === 'select') {
                // Check if clicking on Player Spawn
                const sp = state.mapData.spawnPoint || { x: 100, y: 300 };
                if (worldX >= sp.x && worldX <= sp.x + 70 && worldY >= sp.y && worldY <= sp.y + 105) {
                    state.selectedObject = { obj: sp, kind: 'spawn' };
                    updateInspector();
                    return;
                }

                // Check if clicking on Finish Flag
                const f = state.mapData.finishFlag;
                if (worldX >= f.x && worldX <= f.x + 60 && worldY >= f.y && worldY <= f.y + 180) {
                    state.selectedObject = { obj: f, kind: 'finish' };
                    updateInspector();
                    return;
                }

                // Check if clicking on Coin
                const coin = state.mapData.coins.find(c => Math.hypot(worldX - c.x, worldY - c.y) <= 24);
                if (coin) {
                    state.selectedObject = { obj: coin, kind: 'coin' };
                    updateInspector();
                    return;
                }

                // Check if clicking on NPC
                const npc = state.mapData.npcs.find(n => worldX >= n.x && worldX <= n.x + n.w && worldY >= n.y && worldY <= n.y + n.h);
                if (npc) {
                    state.selectedObject = { obj: npc, kind: 'npc' };
                    updateInspector();
                    return;
                }

                // Clicked on empty canvas -> deselect
                state.selectedObject = null;
                updateInspector();
            } else if (state.activeTool === 'paint') {
                // Save cell as an object with asset and type (solid vs passable)
                state.mapData.gridMap[gridKey] = {
                    asset: state.selectedTileAssetId,
                    type: state.brushType
                };
            } else if (state.activeTool === 'erase') {
                // 1. Hapus tile pada koordinat grid
                delete state.mapData.gridMap[gridKey];

                // 2. Hapus Koin yang tersentuh kursor
                const prevCoinCount = state.mapData.coins.length;
                state.mapData.coins = state.mapData.coins.filter(c => {
                    return Math.hypot(worldX - c.x, worldY - c.y) >= 24;
                });

                // 3. Hapus NPC yang tersentuh kursor
                state.mapData.npcs = state.mapData.npcs.filter(npc => {
                    const inside = (worldX >= npc.x && worldX <= npc.x + npc.w && worldY >= npc.y && worldY <= npc.y + npc.h);
                    return !inside;
                });

                // Update inspector jika objek yang terseleksi ikut terhapus
                if (state.selectedObject) {
                    if (state.selectedObject.kind === 'coin' && !state.mapData.coins.includes(state.selectedObject.obj)) {
                        state.selectedObject = null;
                        updateInspector();
                    } else if (state.selectedObject.kind === 'npc' && !state.mapData.npcs.includes(state.selectedObject.obj)) {
                        state.selectedObject = null;
                        updateInspector();
                    }
                }
            } else if (state.activeTool === 'spawn') {
                // Snap player spawn to grid bottom line
                const snappedX = col * ts;
                const snappedY = (row + 1) * ts - 105;
                state.mapData.spawnPoint = { x: snappedX, y: snappedY };
                state.selectedObject = { obj: state.mapData.spawnPoint, kind: 'spawn' };
                updateInspector();
            } else if (state.activeTool === 'coin') {
                // Snap coin to exact grid center
                const snappedX = col * ts + ts / 2;
                const snappedY = row * ts + ts / 2;
                const exists = state.mapData.coins.some(c => Math.hypot(c.x - snappedX, c.y - snappedY) < 10);
                if (!exists) {
                    state.mapData.coins.push({ x: snappedX, y: snappedY });
                }
            } else if (state.activeTool === 'npc') {
                // Snap NPC to grid bottom line with selected NPC asset
                const snappedX = col * ts;
                const snappedY = (row + 1) * ts - 90;
                const exists = state.mapData.npcs.some(n => Math.abs(n.x - snappedX) < 20 && Math.abs((n.y + (n.h || 90)) - (row + 1) * ts) < 20);
                if (!exists) {
                    state.mapData.npcs.push({
                        id: state.mapData.npcs.length + 1,
                        x: snappedX,
                        y: snappedY,
                        w: 90,
                        h: 90,
                        assetId: state.selectedNpcAssetId || 'npc_idle',
                        questionIndex: 0
                    });
                }
            } else if (state.activeTool === 'finish') {
                // Snap Finish flag to grid bottom line
                const snappedX = col * ts;
                const snappedY = (row + 1) * ts - 180;
                state.mapData.finishFlag.x = snappedX;
                state.mapData.finishFlag.y = snappedY;
            }
        }

        function updateInspector() {
            const form = document.getElementById('inspectorForm');
            const noSel = document.getElementById('noSelectionInfo');

            if (!state.selectedObject) {
                form.classList.add('hidden'); noSel.classList.remove('hidden'); return;
            }

            form.classList.remove('hidden'); noSel.classList.add('hidden');
            const item = state.selectedObject;
            document.getElementById('inpType').value = item.kind.toUpperCase();
            document.getElementById('inpX').value = item.obj.x;
            document.getElementById('inpY').value = item.obj.y;

            const charField = document.getElementById('npcCharacterField');
            const npcField = document.getElementById('npcQuizField');
            if (item.kind === 'npc') {
                charField.classList.remove('hidden');
                npcField.classList.remove('hidden');
                updateNpcSelectDropdown();
                document.getElementById('selNpcAsset').value = item.obj.assetId || 'npc_idle';
                const q = questionsList[item.obj.questionIndex || 0];
                document.getElementById('selectedQuizTitle').textContent = q ? `Soal #${item.obj.questionIndex + 1}: ${q.question.substring(0, 25)}...` : 'Default';
            } else {
                charField.classList.add('hidden');
                npcField.classList.add('hidden');
            }
        }

        document.getElementById('selNpcAsset').addEventListener('change', (e) => {
            if (state.selectedObject && state.selectedObject.kind === 'npc') {
                state.selectedObject.obj.assetId = e.target.value;
            }
        });

        document.getElementById('inpX').addEventListener('input', (e) => {
            if (state.selectedObject) {
                state.selectedObject.obj.x = parseFloat(e.target.value) || 0;
            }
        });

        document.getElementById('inpY').addEventListener('input', (e) => {
            if (state.selectedObject) {
                state.selectedObject.obj.y = parseFloat(e.target.value) || 0;
            }
        });

        function deleteSelected() {
            if (!state.selectedObject) return;
            const item = state.selectedObject;
            if (item.kind === 'coin') state.mapData.coins = state.mapData.coins.filter(c => c !== item.obj);
            if (item.kind === 'npc') state.mapData.npcs = state.mapData.npcs.filter(n => n !== item.obj);
            state.selectedObject = null; updateInspector();
        }
        document.getElementById('btnDeleteSelected').addEventListener('click', deleteSelected);

        document.getElementById('btnPickQuiz').addEventListener('click', () => {
            document.getElementById('quizPickModal').classList.add('active');
        });

        function selectQuizForNpc(idx) {
            if (state.selectedObject && state.selectedObject.kind === 'npc') {
                state.selectedObject.obj.questionIndex = idx;
                updateInspector();
            }
            closeModal('quizPickModal');
        }

        // Playtest Toggle
        document.getElementById('btnPlaytest').addEventListener('click', () => {
            state.isPlaytesting = !state.isPlaytesting;
            const btn = document.getElementById('btnPlaytest');
            if (state.isPlaytesting) {
                btn.innerHTML = `<iconify-icon icon="lucide:square" class="text-lg"></iconify-icon><span>Stop Playtest</span>`;
                btn.classList.replace('playtest', 'bg-red-600');
                const sp = state.mapData.spawnPoint || { x: 100, y: 300 };
                player.x = sp.x; player.y = sp.y; player.vx = 0; player.vy = 0;
            } else {
                btn.innerHTML = `<iconify-icon icon="lucide:play" class="text-lg"></iconify-icon><span>Playtest</span>`;
                btn.className = 'editor-btn playtest';
            }
        });

        // Playtest Physics (Only Solid tiles have collision, Passable tiles can be walked through)
        function updatePlaytest() {
            if (!state.isPlaytesting) return;

            if (keys.left) player.vx = -player.speed;
            else if (keys.right) player.vx = player.speed;
            else player.vx *= 0.7;

            player.vy += player.gravity;
            let nextX = player.x + player.vx;
            let nextY = player.y + player.vy;

            player.isGrounded = false;
            const ts = state.mapData.tileSize || 40;

            // Only collide with actual solid tiles
            Object.keys(state.mapData.gridMap).forEach(key => {
                const cell = getCellData(state.mapData.gridMap[key]);
                if (cell && cell.type === 'solid') {
                    const [c, r] = key.split(',').map(Number);
                    const tx = c * ts, ty = r * ts;
                    if (
                        player.x + player.w > tx && player.x < tx + ts &&
                        player.y + player.h <= ty && nextY + player.h >= ty
                    ) {
                        nextY = ty - player.h; player.vy = 0; player.isGrounded = true;
                    }
                }
            });

            // If player falls below the bottom void (no solid ground tile), player dies & respawns!
            const deathVoidY = Math.max(900, (canvas.height / state.zoom) + state.cameraY + 200);
            if (nextY > deathVoidY || nextY > 1200) {
                const sp = state.mapData.spawnPoint || { x: 100, y: 300 };
                player.x = sp.x;
                player.y = sp.y;
                player.vx = 0;
                player.vy = 0;
                nextX = sp.x;
                nextY = sp.y;
            }

            player.x = nextX; player.y = nextY;

            // Auto follow camera during playtest
            state.cameraX = player.x - (canvas.width / (2 * state.zoom));
            state.cameraY = player.y - (canvas.height / (2 * state.zoom));
        }

        // Render Canvas
        function render() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            ctx.save();
            ctx.scale(state.zoom, state.zoom);
            ctx.translate(-state.cameraX, -state.cameraY);

            const ts = state.mapData.tileSize || 40;

            // Grid rendering in Viewport
            if (!state.isPlaytesting) {
                const minX = Math.floor(state.cameraX / ts) * ts;
                const maxX = Math.ceil((state.cameraX + canvas.width / state.zoom) / ts) * ts;
                const minY = Math.floor(state.cameraY / ts) * ts;
                const maxY = Math.ceil((state.cameraY + canvas.height / state.zoom) / ts) * ts;

                ctx.strokeStyle = 'rgba(255, 255, 255, 0.07)';
                ctx.lineWidth = 1 / state.zoom;

                for (let x = minX; x <= maxX; x += ts) {
                    ctx.beginPath(); ctx.moveTo(x, minY); ctx.lineTo(x, maxY); ctx.stroke();
                }
                for (let y = minY; y <= maxY; y += ts) {
                    ctx.beginPath(); ctx.moveTo(minX, y); ctx.lineTo(maxX, y); ctx.stroke();
                }

                // Origin / Ground guide line (y=560)
                ctx.strokeStyle = 'rgba(250, 204, 21, 0.15)';
                ctx.lineWidth = 1.5 / state.zoom;
                ctx.beginPath(); ctx.moveTo(minX, 560); ctx.lineTo(maxX, 560); ctx.stroke();
            }

            // 1. Draw Passable / Background Tiles first
            Object.keys(state.mapData.gridMap).forEach(key => {
                const cell = getCellData(state.mapData.gridMap[key]);
                if (cell && cell.type === 'empty') {
                    const tile = findTileAsset(cell.assetId);
                    const [c, r] = key.split(',').map(Number);
                    if (tile) {
                        const img = getTileImage(tile.url);
                        if (img && img.complete && img.naturalWidth > 0) {
                            ctx.save();
                            ctx.globalAlpha = state.isPlaytesting ? 0.75 : 0.65;
                            ctx.drawImage(img, c * ts, r * ts, ts, ts);
                            if (!state.isPlaytesting) {
                                ctx.fillStyle = 'rgba(15, 23, 42, 0.25)';
                                ctx.fillRect(c * ts, r * ts, ts, ts);
                                ctx.strokeStyle = 'rgba(148, 163, 184, 0.4)';
                                ctx.lineWidth = 1 / state.zoom;
                                ctx.strokeRect(c * ts, r * ts, ts, ts);
                            }
                            ctx.restore();
                        } else {
                            ctx.fillStyle = '#334155';
                            ctx.fillRect(c * ts, r * ts, ts, ts);
                        }
                    }
                }
            });

            // 2. Draw Solid Ground Tiles
            Object.keys(state.mapData.gridMap).forEach(key => {
                const cell = getCellData(state.mapData.gridMap[key]);
                if (cell && cell.type === 'solid') {
                    const tile = findTileAsset(cell.assetId);
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

            // Draw Player Spawn Point Marker
            const sp = state.mapData.spawnPoint || { x: 100, y: 300 };
            ctx.strokeStyle = '#facc15'; ctx.lineWidth = 2 / state.zoom; ctx.setLineDash([4 / state.zoom, 4 / state.zoom]);
            ctx.strokeRect(sp.x, sp.y, 70, 105);
            ctx.setLineDash([]);
            ctx.fillStyle = 'rgba(250, 204, 21, 0.2)';
            ctx.fillRect(sp.x, sp.y, 70, 105);
            ctx.fillStyle = '#facc15'; ctx.font = `bold ${Math.max(10, 11)}px sans-serif`;
            ctx.fillText('📍 PLAYER SPAWN', sp.x - 10, sp.y - 8);

            // Draw Animated Coins (Pattern 1 -> 2 -> 3 -> 2 -> 1)
            const animIndex = Math.floor(Date.now() / 150) % coinSequence.length;
            const currentCoinFrame = coinFrames[coinSequence[animIndex]];
            const coinWidth = 22;
            const coinHeight = 44;

            state.mapData.coins.forEach(c => {
                if (currentCoinFrame && currentCoinFrame.complete && currentCoinFrame.naturalWidth > 0) {
                    ctx.drawImage(currentCoinFrame, c.x - coinWidth / 2, c.y - coinHeight / 2, coinWidth, coinHeight);
                } else {
                    ctx.fillStyle = '#facc15';
                    ctx.beginPath(); ctx.arc(c.x, c.y, 14, 0, Math.PI * 2); ctx.fill();
                    ctx.strokeStyle = '#ca8a04'; ctx.lineWidth = 2 / state.zoom; ctx.stroke();
                }
            });

            // Draw NPCs with animation (1 -> 2 -> 3 -> 2 -> 1) and facing LEFT towards the player
            const npcAnimIndex = Math.floor(Date.now() / 180) % npcIdleSequence.length;
            const currentNpcFrame = npcIdleFrames[npcIdleSequence[npcAnimIndex]];

            state.mapData.npcs.forEach(npc => {
                const asset = findNpcAsset(npc.assetId);
                const isDefaultOrIdle = !npc.assetId || npc.assetId === 'npc_idle' || npc.assetId === 'npc_co' || npc.assetId === 'npc_ce';
                let img = isDefaultOrIdle ? currentNpcFrame : (asset ? getNpcImage(asset.url) : currentNpcFrame);

                const nw = npc.w || 90;
                const nh = npc.h || 90;

                if (img && img.complete && img.naturalWidth > 0) {
                    ctx.save();
                    ctx.translate(npc.x + nw / 2, npc.y + nh / 2);
                    ctx.scale(-1, 1); // Flip horizontally to face left
                    ctx.drawImage(img, -nw / 2, -nh / 2, nw, nh);
                    ctx.restore();
                } else {
                    ctx.fillStyle = '#eab308'; ctx.fillRect(npc.x, npc.y, nw, nh);
                }
            });

            // Draw Finish Flag
            const f = state.mapData.finishFlag;
            ctx.fillStyle = '#64748b'; ctx.fillRect(f.x, f.y, 8, f.h);
            ctx.fillStyle = '#ef4444';
            ctx.beginPath(); ctx.moveTo(f.x + 8, f.y); ctx.lineTo(f.x + 60, f.y + 25); ctx.lineTo(f.x + 8, f.y + 50); ctx.fill();
            ctx.fillStyle = '#ef4444'; ctx.font = 'bold 11px sans-serif';
            ctx.fillText('🏁 FINISH', f.x - 5, f.y - 8);

            // Draw Playtest Character
            if (state.isPlaytesting) {
                ctx.fillStyle = '#3b82f6';
                if (imgIdle.complete) ctx.drawImage(imgIdle, player.x, player.y, player.w, player.h);
                else ctx.fillRect(player.x, player.y, player.w, player.h);
            }

            // Draw Selection Highlight on Selected Object
            if (!state.isPlaytesting && state.selectedObject) {
                ctx.save();
                ctx.strokeStyle = '#38bdf8';
                ctx.lineWidth = 2.5 / state.zoom;
                ctx.setLineDash([6 / state.zoom, 4 / state.zoom]);
                const sel = state.selectedObject;
                if (sel.kind === 'spawn') {
                    ctx.strokeRect(sel.obj.x - 4, sel.obj.y - 4, 78, 113);
                } else if (sel.kind === 'finish') {
                    ctx.strokeRect(sel.obj.x - 4, sel.obj.y - 4, 68, 188);
                } else if (sel.kind === 'coin') {
                    ctx.beginPath();
                    ctx.arc(sel.obj.x, sel.obj.y, 22, 0, Math.PI * 2);
                    ctx.stroke();
                } else if (sel.kind === 'npc') {
                    ctx.strokeRect(sel.obj.x - 4, sel.obj.y - 4, (sel.obj.w || 90) + 8, (sel.obj.h || 90) + 8);
                }
                ctx.restore();
            }

            // Draw Ghost / Grid Cursor Preview (Snap to Grid)
            if (!state.isPlaytesting && state.mouseHover && state.mouseHover.inCanvas) {
                const { col, row } = state.mouseHover;
                const cellX = col * ts;
                const cellY = row * ts;

                ctx.save();
                if (state.activeTool === 'paint') {
                    const tile = findTileAsset(state.selectedTileAssetId);
                    if (tile) {
                        const img = getTileImage(tile.url);
                        ctx.globalAlpha = 0.6;
                        if (img && img.complete && img.naturalWidth > 0) {
                            ctx.drawImage(img, cellX, cellY, ts, ts);
                        } else {
                            ctx.fillStyle = state.brushType === 'solid' ? '#22c55e' : '#94a3b8';
                            ctx.fillRect(cellX, cellY, ts, ts);
                        }
                    }
                    ctx.strokeStyle = state.brushType === 'solid' ? '#4ade80' : '#cbd5e1';
                    ctx.lineWidth = 2 / state.zoom;
                    ctx.strokeRect(cellX, cellY, ts, ts);
                } else if (state.activeTool === 'erase') {
                    ctx.fillStyle = 'rgba(239, 68, 68, 0.35)';
                    ctx.fillRect(cellX, cellY, ts, ts);
                    ctx.strokeStyle = '#ef4444';
                    ctx.lineWidth = 2 / state.zoom;
                    ctx.strokeRect(cellX, cellY, ts, ts);
                } else if (state.activeTool === 'coin') {
                    // Coin snap to grid center
                    const coinX = cellX + ts / 2;
                    const coinY = cellY + ts / 2;
                    ctx.globalAlpha = 0.65;
                    if (currentCoinFrame && currentCoinFrame.complete && currentCoinFrame.naturalWidth > 0) {
                        ctx.drawImage(currentCoinFrame, coinX - coinWidth / 2, coinY - coinHeight / 2, coinWidth, coinHeight);
                    } else {
                        ctx.fillStyle = '#facc15';
                        ctx.beginPath(); ctx.arc(coinX, coinY, 14, 0, Math.PI * 2); ctx.fill();
                    }
                    ctx.strokeStyle = '#facc15';
                    ctx.lineWidth = 1.5 / state.zoom;
                    ctx.strokeRect(cellX, cellY, ts, ts);
                } else if (state.activeTool === 'npc') {
                    // NPC snap to grid bottom line with active selected NPC asset preview (facing left)
                    const npcW = 90;
                    const npcH = 90;
                    const npcX = cellX;
                    const npcY = (row + 1) * ts - npcH;
                    const asset = findNpcAsset(state.selectedNpcAssetId);
                    const isDefaultOrIdle = !state.selectedNpcAssetId || state.selectedNpcAssetId === 'npc_idle' || state.selectedNpcAssetId === 'npc_co' || state.selectedNpcAssetId === 'npc_ce';
                    const img = isDefaultOrIdle ? currentNpcFrame : (asset ? getNpcImage(asset.url) : currentNpcFrame);

                    ctx.save();
                    ctx.globalAlpha = 0.7;
                    if (img && img.complete && img.naturalWidth > 0) {
                        ctx.translate(npcX + npcW / 2, npcY + npcH / 2);
                        ctx.scale(-1, 1); // Flip horizontally to face left
                        ctx.drawImage(img, -npcW / 2, -npcH / 2, npcW, npcH);
                    } else {
                        ctx.fillStyle = '#eab308';
                        ctx.fillRect(npcX, npcY, npcW, npcH);
                    }
                    ctx.restore();
                    ctx.strokeStyle = '#38bdf8';
                    ctx.lineWidth = 2 / state.zoom;
                    ctx.setLineDash([4 / state.zoom, 4 / state.zoom]);
                    ctx.strokeRect(npcX, npcY, npcW, npcH);
                } else if (state.activeTool === 'spawn') {
                    // Spawn snap to grid bottom line
                    const spX = cellX;
                    const spY = (row + 1) * ts - 105;
                    ctx.globalAlpha = 0.6;
                    ctx.fillStyle = 'rgba(250, 204, 21, 0.2)';
                    ctx.fillRect(spX, spY, 70, 105);
                    ctx.strokeStyle = '#facc15';
                    ctx.lineWidth = 2 / state.zoom;
                    ctx.setLineDash([4 / state.zoom, 4 / state.zoom]);
                    ctx.strokeRect(spX, spY, 70, 105);
                } else if (state.activeTool === 'finish') {
                    // Finish flag snap to grid bottom line
                    const fX = cellX;
                    const fY = (row + 1) * ts - 180;
                    ctx.globalAlpha = 0.6;
                    ctx.fillStyle = '#64748b'; ctx.fillRect(fX, fY, 8, 180);
                    ctx.fillStyle = '#ef4444';
                    ctx.beginPath(); ctx.moveTo(fX + 8, fY); ctx.lineTo(fX + 60, fY + 25); ctx.lineTo(fX + 8, fY + 50); ctx.fill();
                }
                ctx.restore();
            }

            ctx.restore();
        }

        function loop() {
            updatePlaytest(); render(); requestAnimationFrame(loop);
        }
        requestAnimationFrame(loop);

        // Save & Load Handlers
        document.getElementById('btnLoadModal').addEventListener('click', () => {
            document.getElementById('loadModal').classList.add('active');
        });

        function loadLevelData(id) {
            fetch(`/minigame/levels/${id}`)
                .then(r => r.json())
                .then(res => {
                    if (res.status === 'success') {
                        state.currentLevelId = res.level.id;
                        state.title = res.level.title;
                        document.getElementById('levelTitleInput').value = res.level.title;

                        const rawData = res.level.map_data || {};
                        state.mapData = {
                            levelLength: rawData.levelLength || 10000,
                            tileSize: rawData.tileSize || 40,
                            tileAssets: rawData.tileAssets && rawData.tileAssets.length > 0 ? rawData.tileAssets : JSON.parse(JSON.stringify(defaultTileAssets)),
                            npcAssets: rawData.npcAssets && rawData.npcAssets.length > 0 ? rawData.npcAssets : JSON.parse(JSON.stringify(defaultNpcAssets)),
                            gridMap: rawData.gridMap || {},
                            spawnPoint: rawData.spawnPoint || { x: 100, y: 300 },
                            coins: rawData.coins || [],
                            npcs: rawData.npcs || [],
                            finishFlag: rawData.finishFlag || { x: 4000, y: 370, w: 60, h: 180 }
                        };

                        (state.mapData.tileAssets || []).forEach(t => getTileImage(t.url));
                        (state.mapData.npcAssets || []).forEach(n => getNpcImage(n.url));

                        renderTilePalette();
                        renderNpcPalette();
                        if (state.mapData.tileAssets && state.mapData.tileAssets.length > 0) {
                            selectTileAsset(state.mapData.tileAssets[0].id);
                        }
                        if (state.mapData.npcAssets && state.mapData.npcAssets.length > 0) {
                            selectNpcAsset(state.mapData.npcAssets[0].id);
                        }

                        // Center to spawn point
                        const sp = state.mapData.spawnPoint || { x: 100, y: 300 };
                        state.cameraX = sp.x - (canvas.width / (2 * state.zoom));
                        state.cameraY = sp.y - (canvas.height / (2 * state.zoom));

                        closeModal('loadModal');
                        alert('Level & Tilemap/NPC Assets berhasil dimuat!');
                    }
                });
        }

        document.getElementById('btnSaveLevel').addEventListener('click', () => {
            const title = document.getElementById('levelTitleInput').value;
            fetch("{{ route('minigame.levels.save') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: state.currentLevelId,
                    title: title,
                    map_data: state.mapData
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    state.currentLevelId = res.level.id;
                    alert('🎉 Level berhasil disimpan!');
                }
            });
        });

        document.getElementById('btnCreateNewLevel').addEventListener('click', () => {
            if (confirm('Buat Map Level baru?')) {
                state.currentLevelId = null;
                state.title = "Petualangan Oklik - Level Baru";
                document.getElementById('levelTitleInput').value = state.title;
                state.mapData = {
                    levelLength: 10000, tileSize: 40,
                    tileAssets: JSON.parse(JSON.stringify(defaultTileAssets)),
                    npcAssets: JSON.parse(JSON.stringify(defaultNpcAssets)),
                    gridMap: {}, spawnPoint: { x: 100, y: 300 },
                    coins: [
                        { x: 340, y: 410 },
                        { x: 400, y: 410 },
                        { x: 640, y: 310 }
                    ],
                    npcs: [{ id: 1, x: 1100, y: 470, w: 90, h: 90, assetId: 'npc_idle', questionIndex: 0 }],
                    finishFlag: { x: 4000, y: 370, w: 60, h: 180 }
                };
                state.selectedObject = null; updateInspector();
                renderTilePalette();
                renderNpcPalette();
                selectTileAsset('dirt');
                selectNpcAsset('npc_idle');
                setBrushType('solid');
                state.cameraX = 0;
                state.cameraY = 0;
                alert('Map baru siap dirancang!');
            }
        });

        document.getElementById('btnDeleteCurrentLevel').addEventListener('click', () => {
            if (!state.currentLevelId) { alert('Level ini belum disimpan di Database.'); return; }
            if (confirm(`Yakin ingin menghapus level "${document.getElementById('levelTitleInput').value}" dari Database?`)) {
                fetch(`/minigame/levels/${state.currentLevelId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}' }
                })
                .then(r => r.json())
                .then(res => {
                    if (res.status === 'success') { alert('Level berhasil dihapus!'); location.reload(); }
                });
            }
        });

        // Initialize Palettes & UI
        document.getElementById('levelTitleInput').value = state.title;
        (state.mapData.tileAssets || []).forEach(t => getTileImage(t.url));
        (state.mapData.npcAssets || []).forEach(n => getNpcImage(n.url));

        renderTilePalette();
        renderNpcPalette();
        if (state.mapData.tileAssets && state.mapData.tileAssets.length > 0) {
            selectTileAsset(state.mapData.tileAssets[0].id);
        }
        if (state.mapData.npcAssets && state.mapData.npcAssets.length > 0) {
            selectNpcAsset(state.mapData.npcAssets[0].id);
        }
        setBrushType('solid');
        updateZoomDisplay();

        // Focus camera on spawn point initially
        const initialSpawn = state.mapData.spawnPoint || { x: 100, y: 300 };
        state.cameraX = initialSpawn.x - 120;
        state.cameraY = Math.max(0, initialSpawn.y - 200);
    </script>
</body>
</html>
