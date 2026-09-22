<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih & Kelola Level - Minigame Oklik</title>
    <link rel="icon" type="image/webp" href="{{ asset('assets/sabi.webp') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Jua&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            color: #f8fafc;
        }

        .heading-font {
            font-family: 'Paytone One', cursive, sans-serif;
        }

        .game-font {
            font-family: 'Jua', sans-serif;
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .level-card {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.95) 100%);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .level-card:hover {
            transform: translateY(-4px);
            border-color: rgba(250, 204, 21, 0.5);
            box-shadow: 0 16px 32px -8px rgba(0, 0, 0, 0.5), 0 0 20px 2px rgba(250, 204, 21, 0.15);
        }

        .btn-gradient-yellow {
            background: linear-gradient(135deg, #facc15 0%, #eab308 100%);
            color: #0f172a;
            box-shadow: 0 4px 14px rgba(234, 179, 8, 0.35);
            transition: all 0.2s ease;
        }

        .btn-gradient-yellow:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(234, 179, 8, 0.45);
        }

        .btn-gradient-yellow:active {
            transform: translateY(1px);
        }

        .btn-game-outline {
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            color: #f8fafc;
            transition: all 0.2s ease;
        }

        .btn-game-outline:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            color: #ffffff;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: all 0.25s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background: #1e293b;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            transform: scale(0.95);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
        }
    </style>
</head>
<body class="py-8 px-4 md:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Top Navigation -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 glass-card p-4 md:p-6 rounded-3xl">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-400 to-amber-500 p-0.5 shadow-lg flex items-center justify-center">
                    <img src="{{ asset('assets/sabi.webp') }}" alt="Logo" class="w-full h-full object-contain rounded-2xl bg-slate-900/60 p-1.5">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="heading-font text-xl md:text-2xl text-yellow-400">Pilih & Kelola Level</h1>
                        <span class="bg-yellow-400/20 text-yellow-300 text-xs px-2.5 py-0.5 rounded-full font-bold border border-yellow-400/30">Admin Map Editor</span>
                    </div>
                    <p class="text-xs md:text-sm text-slate-400 mt-0.5">Kelola tingkat kesulitan, buat level baru, atau klik <strong>Edit Map</strong> untuk merancang canvas.</p>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('minigame') }}" class="btn-game-outline px-4 py-2.5 rounded-2xl font-bold text-xs md:text-sm flex items-center gap-2">
                    <iconify-icon icon="lucide:gamepad-2" class="text-base text-yellow-400"></iconify-icon>
                    <span>Main Minigame</span>
                </a>
                <a href="{{ route('menu') }}" class="btn-game-outline px-4 py-2.5 rounded-2xl font-bold text-xs md:text-sm flex items-center gap-2">
                    <iconify-icon icon="lucide:home" class="text-base"></iconify-icon>
                    <span>Menu Utama</span>
                </a>
                <button type="button" onclick="openCreateModal()" class="btn-gradient-yellow px-5 py-2.5 rounded-2xl font-extrabold text-xs md:text-sm flex items-center gap-2">
                    <iconify-icon icon="lucide:plus-circle" class="text-lg"></iconify-icon>
                    <span>Buat Level Baru</span>
                </button>
            </div>
        </header>

        <!-- Status Toast / Alerts -->
        @if (session('status'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 flex items-center gap-3">
                <iconify-icon icon="lucide:check-circle-2" class="text-2xl text-emerald-400 shrink-0"></iconify-icon>
                <span class="font-medium text-sm">{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/20 border border-rose-500/40 text-rose-300 flex items-center gap-3">
                <iconify-icon icon="lucide:alert-triangle" class="text-2xl text-rose-400 shrink-0"></iconify-icon>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Quick Summary Metrics -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glass-card p-4 rounded-2xl flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-yellow-400/10 border border-yellow-400/30 flex items-center justify-center text-yellow-400 text-xl">
                    <iconify-icon icon="lucide:layers"></iconify-icon>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Total Level</div>
                    <div class="heading-font text-lg text-white">{{ $levels->count() }}</div>
                </div>
            </div>

            <div class="glass-card p-4 rounded-2xl flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-400/10 border border-green-400/30 flex items-center justify-center text-green-400 text-xl">
                    <iconify-icon icon="lucide:play-circle"></iconify-icon>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Level Aktif</div>
                    <div class="heading-font text-lg text-white">{{ $levels->where('is_active', true)->count() }}</div>
                </div>
            </div>

            <div class="glass-card p-4 rounded-2xl flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-400/30 flex items-center justify-center text-amber-400 text-xl">
                    <iconify-icon icon="lucide:coins"></iconify-icon>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">Total Koin Game</div>
                    <div class="heading-font text-lg text-white">
                        {{ $levels->sum(fn($l) => count($l->map_data['coins'] ?? [])) }}
                    </div>
                </div>
            </div>

            <div class="glass-card p-4 rounded-2xl flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-400/10 border border-blue-400/30 flex items-center justify-center text-blue-400 text-xl">
                    <iconify-icon icon="lucide:help-circle"></iconify-icon>
                </div>
                <div>
                    <div class="text-xs text-slate-400 font-medium">NPC Gerbang Kuis</div>
                    <div class="heading-font text-lg text-white">
                        {{ $levels->sum(fn($l) => count($l->map_data['npcs'] ?? [])) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Levels List Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($levels as $index => $level)
                @php
                    $mapData = $level->map_data ?? [];
                    $coinCount = count($mapData['coins'] ?? []);
                    $npcCount = count($mapData['npcs'] ?? []);
                    $tileCount = count($mapData['gridMap'] ?? []);
                    $mapLength = $mapData['levelLength'] ?? 6000;
                @endphp
                <div class="level-card rounded-3xl p-6 flex flex-col justify-between relative overflow-hidden group">
                    <!-- Top Ribbon info -->
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="heading-font text-xs bg-yellow-400 text-slate-900 px-3 py-1 rounded-full font-bold tracking-wide">
                                    LEVEL {{ $index + 1 }}
                                </span>
                                @if ($level->is_active)
                                    <span class="text-[11px] font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="text-[11px] font-bold text-slate-400 bg-slate-700/40 border border-slate-600/30 px-2.5 py-0.5 rounded-full">
                                        Draft
                                    </span>
                                @endif
                            </div>

                            <!-- Quick Action Menu -->
                            <div class="flex items-center gap-1">
                                <button type="button" 
                                    onclick="openEditInfoModal({{ $level->id }}, '{{ addslashes($level->title) }}', '{{ addslashes($level->description ?? '') }}', {{ $level->is_active ? 'true' : 'false' }})" 
                                    class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-700/50 transition-colors" 
                                    title="Ubah Judul & Info">
                                    <iconify-icon icon="lucide:pencil" class="text-base"></iconify-icon>
                                </button>
                                <form method="POST" action="{{ route('minigame.levels.duplicate', $level->id) }}" class="inline" onsubmit="return confirm('Duplikat level ini?')">
                                    @csrf
                                    <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-yellow-400 hover:bg-slate-700/50 transition-colors" title="Duplikat Level">
                                        <iconify-icon icon="lucide:copy" class="text-base"></iconify-icon>
                                    </button>
                                </form>
                                @if ($levels->count() > 1)
                                    <form method="POST" action="{{ route('minigame.levels.delete', $level->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus level \'{{ addslashes($level->title) }}\'? Data peta akan terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-400 hover:bg-slate-700/50 transition-colors" title="Hapus Level">
                                            <iconify-icon icon="lucide:trash-2" class="text-base"></iconify-icon>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Title & Description -->
                        <h2 class="heading-font text-lg text-white group-hover:text-yellow-400 transition-colors line-clamp-1 mb-1">
                            {{ $level->title }}
                        </h2>
                        <p class="text-xs text-slate-400 line-clamp-2 min-h-[32px] mb-5">
                            {{ $level->description ?: 'Tidak ada deskripsi tambahan.' }}
                        </p>

                        <!-- Map Specs Badges -->
                        <div class="grid grid-cols-3 gap-2 p-3 rounded-2xl bg-slate-900/60 border border-slate-800/80 mb-6">
                            <div class="text-center">
                                <div class="text-[10px] text-slate-400 uppercase font-bold flex items-center justify-center gap-1">
                                    <iconify-icon icon="lucide:coins" class="text-yellow-400"></iconify-icon>
                                    <span>Koin</span>
                                </div>
                                <div class="font-bold text-sm text-yellow-300">{{ $coinCount }}</div>
                            </div>
                            <div class="text-center border-x border-slate-800">
                                <div class="text-[10px] text-slate-400 uppercase font-bold flex items-center justify-center gap-1">
                                    <iconify-icon icon="lucide:user-check" class="text-blue-400"></iconify-icon>
                                    <span>NPC Pos</span>
                                </div>
                                <div class="font-bold text-sm text-blue-300">{{ $npcCount }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-[10px] text-slate-400 uppercase font-bold flex items-center justify-center gap-1">
                                    <iconify-icon icon="lucide:box" class="text-green-400"></iconify-icon>
                                    <span>Tiles</span>
                                </div>
                                <div class="font-bold text-sm text-green-300">{{ $tileCount }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Action Buttons -->
                    <div class="space-y-2 pt-2 border-t border-slate-800/80">
                        <a href="{{ route('minigame.editor.canvas', $level->id) }}" class="btn-gradient-yellow w-full py-3 rounded-2xl font-black text-sm flex items-center justify-center gap-2">
                            <iconify-icon icon="lucide:edit-3" class="text-lg"></iconify-icon>
                            <span>Buka Map Editor</span>
                        </a>
                        <a href="{{ route('minigame', ['level_id' => $level->id]) }}" class="btn-game-outline w-full py-2.5 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 text-slate-300 hover:text-white">
                            <iconify-icon icon="lucide:play" class="text-sm text-yellow-400"></iconify-icon>
                            <span>Uji Mainkan Level Ini</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center glass-card rounded-3xl p-8">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-3xl bg-yellow-400/10 border border-yellow-400/20 flex items-center justify-center text-yellow-400 text-4xl">
                        <iconify-icon icon="lucide:layers"></iconify-icon>
                    </div>
                    <h3 class="heading-font text-xl text-white mb-2">Belum Ada Level</h3>
                    <p class="text-sm text-slate-400 max-w-md mx-auto mb-6">Mulai dengan membuat level baru untuk menambahkan rintangan, platform tilemap, koin, dan pos NPC kuis.</p>
                    <button type="button" onclick="openCreateModal()" class="btn-gradient-yellow px-6 py-3 rounded-2xl font-bold text-sm inline-flex items-center gap-2">
                        <iconify-icon icon="lucide:plus" class="text-lg"></iconify-icon>
                        <span>Buat Level Sekarang</span>
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- MODAL: BUAT LEVEL BARU -->
    <div id="createModal" class="modal-overlay">
        <div class="modal-content w-full max-w-md p-6 m-4">
            <div class="flex items-center justify-between border-b border-slate-700/80 pb-3 mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-yellow-400/10 border border-yellow-400/30 flex items-center justify-center text-yellow-400 text-lg">
                        <iconify-icon icon="lucide:plus-circle"></iconify-icon>
                    </div>
                    <h3 class="heading-font text-lg text-white">Buat Level Baru</h3>
                </div>
                <button type="button" onclick="closeModal('createModal')" class="text-slate-400 hover:text-white p-1 rounded-lg">
                    <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                </button>
            </div>

            <form method="POST" action="{{ route('minigame.levels.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nama / Judul Level <span class="text-rose-400">*</span></label>
                        <input type="text" name="title" required placeholder="Contoh: Level {{ $levels->count() + 1 }}: Menuju Desa Oklik" 
                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 placeholder:text-slate-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Deskripsi Singkat (Opsional)</label>
                        <textarea name="description" rows="3" placeholder="Ceritakan rintangan atau latar belakang level ini..." 
                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 placeholder:text-slate-500 resize-none"></textarea>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-900/80 border border-slate-800 text-xs text-slate-400 flex items-start gap-2.5">
                        <iconify-icon icon="lucide:sparkles" class="text-yellow-400 text-base shrink-0 mt-0.5"></iconify-icon>
                        <span>Level baru akan otomatis diberi template peta awal dengan pulau tanah, koin beranimasi, dan penjaga gerbang kuis yang siap Anda kustomisasi.</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-700/80">
                    <button type="button" onclick="closeModal('createModal')" class="btn-game-outline px-4 py-2.5 rounded-xl font-bold text-xs">
                        Batal
                    </button>
                    <button type="submit" class="btn-gradient-yellow px-5 py-2.5 rounded-xl font-black text-xs flex items-center gap-2">
                        <iconify-icon icon="lucide:arrow-right" class="text-base"></iconify-icon>
                        <span>Buat & Buka Editor</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT INFO LEVEL -->
    <div id="editInfoModal" class="modal-overlay">
        <div class="modal-content w-full max-w-md p-6 m-4">
            <div class="flex items-center justify-between border-b border-slate-700/80 pb-3 mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-yellow-400/10 border border-yellow-400/30 flex items-center justify-center text-yellow-400 text-lg">
                        <iconify-icon icon="lucide:pencil"></iconify-icon>
                    </div>
                    <h3 class="heading-font text-lg text-white">Edit Informasi Level</h3>
                </div>
                <button type="button" onclick="closeModal('editInfoModal')" class="text-slate-400 hover:text-white p-1 rounded-lg">
                    <iconify-icon icon="lucide:x" class="text-xl"></iconify-icon>
                </button>
            </div>

            <form id="editInfoForm" method="POST" action="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Judul Level <span class="text-rose-400">*</span></label>
                        <input type="text" id="editTitleInput" name="title" required 
                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Deskripsi</label>
                        <textarea id="editDescInput" name="description" rows="3" 
                            class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 resize-none"></textarea>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-900/60 border border-slate-800">
                        <input type="checkbox" id="editActiveInput" name="is_active" value="1" class="w-4 h-4 rounded text-yellow-500 focus:ring-yellow-400 bg-slate-800 border-slate-600">
                        <label for="editActiveInput" class="text-xs font-semibold text-slate-300 cursor-pointer">
                            Level Aktif (Dapat dipilih dan dimainkan oleh user)
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-700/80">
                    <button type="button" onclick="closeModal('editInfoModal')" class="btn-game-outline px-4 py-2.5 rounded-xl font-bold text-xs">
                        Batal
                    </button>
                    <button type="submit" class="btn-gradient-yellow px-5 py-2.5 rounded-xl font-black text-xs flex items-center gap-2">
                        <iconify-icon icon="lucide:check" class="text-base"></iconify-icon>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.add('active');
        }

        function openEditInfoModal(id, title, desc, isActive) {
            const form = document.getElementById('editInfoForm');
            form.action = `/minigame/levels/${id}/info`;
            document.getElementById('editTitleInput').value = title;
            document.getElementById('editDescInput').value = desc || '';
            document.getElementById('editActiveInput').checked = !!isActive;
            document.getElementById('editInfoModal').classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        // Close modal on background click
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.remove('active');
            });
        });
    </script>
</body>
</html>
