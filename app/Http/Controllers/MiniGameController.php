<?php

namespace App\Http\Controllers;

use App\Models\GameLevel;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MiniGameController extends Controller
{
    public function index(Request $request)
    {
        $questions = QuizQuestion::query()->orderBy('position')->get();

        if ($questions->isEmpty()) {
            $questions = collect([
                [
                    'id' => 1,
                    'question' => 'Kesenian Oklik berasal dari daerah ...',
                    'option_a' => 'Bojonegoro',
                    'option_b' => 'Tuban',
                    'option_c' => 'Lamongan',
                    'option_d' => 'Madiun',
                    'correct_option' => 'a',
                ],
                [
                    'id' => 2,
                    'question' => 'Peristiwa yang melatarbelakangi munculnya kesenian Oklik adalah ...',
                    'option_a' => 'Perang kemerdekaan',
                    'option_b' => 'Festival budaya',
                    'option_c' => 'Pagebluk dan pencurian',
                    'option_d' => 'Pembangunan desa',
                    'correct_option' => 'c',
                ],
                [
                    'id' => 3,
                    'question' => 'Bahan utama alat musik Oklik umumnya berasal dari ...',
                    'option_a' => 'Besi',
                    'option_b' => 'Kaca',
                    'option_c' => 'Kayu dan bambu',
                    'option_d' => 'Kulit hewan',
                    'correct_option' => 'c',
                ],
            ]);
        } else {
            $questions = $questions->map(function ($q) {
                return [
                    'id' => $q->id,
                    'question' => $q->question,
                    'option_a' => $q->option_a,
                    'option_b' => $q->option_b,
                    'option_c' => $q->option_c,
                    'option_d' => $q->option_d,
                    'correct_option' => strtolower($q->correct_option),
                ];
            });
        }

        $levels = GameLevel::where('is_active', true)->orderBy('id', 'asc')->get();

        // If no levels in DB, create initial default Level 1
        if ($levels->isEmpty()) {
            $defaultLevel = GameLevel::create([
                'title' => 'Level 1: Menuju Panggung Oklik',
                'description' => 'Petualangan perdana menelusuri rintangan dan menjawab kuis Oklik.',
                'map_data' => $this->getDefaultMapData('Level 1: Menuju Panggung Oklik'),
                'is_active' => true,
            ]);
            $levels = collect([$defaultLevel]);
        }

        $levelId = $request->query('level_id');
        $activeLevel = null;

        if ($levelId) {
            $activeLevel = GameLevel::find($levelId);
        } else {
            $activeLevel = $levels->first();
        }

        return view('minigame', [
            'questions' => $questions,
            'activeLevel' => $activeLevel ? $activeLevel->map_data : null,
            'currentLevelId' => $activeLevel?->id,
            'levels' => $levels,
            'isAdmin' => (bool) (Auth::user()?->is_admin),
        ]);
    }

    /**
     * Display Level Selection / CRUD Dashboard
     */
    public function levelsIndex()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('minigame')->with('error', 'Akses Map Editor hanya untuk Admin.');
        }

        $levels = GameLevel::orderBy('id', 'asc')->get();

        // If empty, seed default level
        if ($levels->isEmpty()) {
            $defaultLevel = GameLevel::create([
                'title' => 'Level 1: Menuju Panggung Oklik',
                'description' => 'Petualangan perdana menelusuri rintangan dan menjawab kuis Oklik.',
                'map_data' => $this->getDefaultMapData('Level 1: Menuju Panggung Oklik'),
                'is_active' => true,
            ]);
            $levels = collect([$defaultLevel]);
        }

        return view('minigame-levels', [
            'levels' => $levels,
        ]);
    }

    /**
     * Open Canvas Map Editor for a specific Level
     */
    public function editorCanvas($id = null)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('minigame')->with('error', 'Akses Map Editor hanya untuk Admin.');
        }

        $questions = QuizQuestion::query()->orderBy('position')->get();
        $levels = GameLevel::orderBy('id', 'asc')->get();

        if ($id) {
            $activeLevel = GameLevel::findOrFail($id);
        } else {
            $activeLevel = $levels->first();
            if (!$activeLevel) {
                $activeLevel = GameLevel::create([
                    'title' => 'Level 1: Menuju Panggung Oklik',
                    'description' => 'Petualangan perdana menelusuri rintangan dan menjawab kuis Oklik.',
                    'map_data' => $this->getDefaultMapData('Level 1: Menuju Panggung Oklik'),
                    'is_active' => true,
                ]);
                $levels = collect([$activeLevel]);
            }
        }

        return view('minigame-editor', [
            'questions' => $questions,
            'levels' => $levels,
            'activeLevel' => $activeLevel,
        ]);
    }

    /**
     * Create / Store a New Level
     */
    public function storeLevel(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('minigame')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $totalLevels = GameLevel::count();
        $title = $request->input('title') ?: 'Level ' . ($totalLevels + 1) . ': Petualangan Baru';

        $level = GameLevel::create([
            'title' => $title,
            'description' => $request->input('description') ?? 'Desain peta dan rintangan untuk level ini.',
            'map_data' => $this->getDefaultMapData($title),
            'is_active' => true,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'level' => $level,
                'redirect_url' => route('minigame.editor.canvas', $level->id),
            ]);
        }

        return redirect()->route('minigame.editor.canvas', $level->id)
            ->with('status', "Level \"{$level->title}\" berhasil dibuat! Silakan mulai merancang peta.");
    }

    /**
     * Update Level Metadata (Title, Description, Status)
     */
    public function updateLevelInfo(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('minigame')->with('error', 'Unauthorized');
        }

        $level = GameLevel::findOrFail($id);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable'],
        ]);

        $level->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'is_active' => $request->has('is_active') ? (bool) $request->input('is_active') : true,
        ]);

        return redirect()->route('minigame.editor')->with('status', "Informasi level \"{$level->title}\" berhasil diperbarui!");
    }

    /**
     * Duplicate a Level
     */
    public function duplicateLevel($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect()->route('minigame')->with('error', 'Unauthorized');
        }

        $source = GameLevel::findOrFail($id);

        $duplicate = GameLevel::create([
            'title' => 'Salinan - ' . $source->title,
            'description' => $source->description,
            'map_data' => $source->map_data,
            'is_active' => false,
        ]);

        return redirect()->route('minigame.editor')->with('status', "Level \"{$source->title}\" berhasil diduplikasi menjadi \"{$duplicate->title}\"!");
    }

    /**
     * Save Map Data from Canvas Editor
     */
    public function saveLevel(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'id' => ['nullable', 'integer', 'exists:game_levels,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'map_data' => ['required', 'array'],
        ]);

        $level = GameLevel::updateOrCreate(
            ['id' => $data['id'] ?? null],
            [
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'map_data' => $data['map_data'],
                'is_active' => true,
            ]
        );

        return response()->json([
            'status' => 'success',
            'level' => $level,
        ]);
    }

    public function loadLevel($id)
    {
        $level = GameLevel::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'level' => $level,
        ]);
    }

    public function deleteLevel(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
            }
            return redirect()->route('minigame')->with('error', 'Unauthorized');
        }

        $level = GameLevel::findOrFail($id);
        $title = $level->title;
        $level->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return redirect()->route('minigame.editor')->with('status', "Level \"{$title}\" berhasil dihapus.");
    }

    public function uploadTilemap(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:8192'],
        ]);

        $file = $request->file('image');
        $filename = 'tilemap_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads/tilemaps');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);
        $url = asset('uploads/tilemaps/' . $filename);

        return response()->json([
            'status' => 'success',
            'url' => $url,
        ]);
    }

    public function submitScore(Request $request)
    {
        $request->validate([
            'coins' => ['required', 'integer', 'min:0'],
            'quiz_correct' => ['required', 'integer', 'min:0'],
        ]);

        $coins = (int) $request->input('coins');
        $quizCorrect = (int) $request->input('quiz_correct');
        $earnedPoints = $coins + ($quizCorrect * 10);

        if (Auth::check()) {
            $user = Auth::user();
            $newPoints = ($user->quiz_points ?? 0) + $earnedPoints;
            $user->update(['quiz_points' => $newPoints]);
        }

        return response()->json([
            'status' => 'success',
            'earned_points' => $earnedPoints,
        ]);
    }

    /**
     * Default Template for New Maps
     */
    private function getDefaultMapData(string $title = 'Level Baru'): array
    {
        $grid = [];
        // First Island ground layer
        for ($c = 0; $c < 28; $c++) {
            $grid["{$c},14"] = 'dirt';
            $grid["{$c},15"] = 'dirt2';
        }
        for ($c = 10; $c <= 14; $c++) $grid["{$c},11"] = 'dirt';
        for ($c = 18; $c <= 22; $c++) $grid["{$c},8"] = 'dirt';
        for ($c = 24; $c <= 27; $c++) $grid["{$c},11"] = 'dirt';

        // Second island
        for ($c = 34; $c < 60; $c++) {
            $grid["{$c},14"] = 'dirt';
            $grid["{$c},15"] = 'dirt2';
        }
        for ($c = 40; $c <= 44; $c++) $grid["{$c},10"] = 'dirt';
        for ($c = 48; $c <= 52; $c++) $grid["{$c},7"] = 'dirt';

        // Final island
        for ($c = 66; $c < 105; $c++) {
            $grid["{$c},14"] = 'dirt';
            $grid["{$c},15"] = 'dirt2';
        }

        return [
            'levelLength' => 6000,
            'tileSize' => 40,
            'tileAssets' => [
                [
                    'id' => 'dirt',
                    'name' => 'Tanah 1 (Dirt)',
                    'url' => asset('assets/dirt.png'),
                    'type' => 'solid',
                    'isDefault' => true,
                ],
                [
                    'id' => 'dirt2',
                    'name' => 'Tanah 2 (Dirt 2)',
                    'url' => asset('assets/dirt2.png'),
                    'type' => 'solid',
                    'isDefault' => true,
                ],
            ],
            'tileTypes' => [
                'dirt' => 'solid',
                'dirt2' => 'solid',
            ],
            'npcAssets' => [
                [
                    'id' => 'npc_idle',
                    'name' => 'NPC Penjaga Gerbang (Animated)',
                    'url' => asset('assets/npcidle1.png'),
                    'isDefault' => true,
                ],
                [
                    'id' => 'npc_co',
                    'name' => 'Karakter Cowok',
                    'url' => asset('assets/karakterco.png'),
                    'isDefault' => true,
                ],
                [
                    'id' => 'npc_ce',
                    'name' => 'Karakter Cewek',
                    'url' => asset('assets/karakterce.png'),
                    'isDefault' => true,
                ],
            ],
            'gridMap' => $grid,
            'spawnPoint' => ['x' => 100, 'y' => 400],
            'coins' => [
                ['x' => 480, 'y' => 390], ['x' => 540, 'y' => 390],
                ['x' => 800, 'y' => 270], ['x' => 860, 'y' => 270],
                ['x' => 1700, 'y' => 350], ['x' => 1980, 'y' => 230],
                ['x' => 2800, 'y' => 500], ['x' => 3000, 'y' => 500],
            ],
            'npcs' => [
                ['id' => 1, 'x' => 1100, 'y' => 470, 'w' => 90, 'h' => 90, 'assetId' => 'npc_idle', 'questionIndex' => 0],
                ['id' => 2, 'x' => 2350, 'y' => 470, 'w' => 90, 'h' => 90, 'assetId' => 'npc_idle', 'questionIndex' => 1],
            ],
            'finishFlag' => ['x' => 3800, 'y' => 380, 'w' => 60, 'h' => 180],
        ];
    }
}
