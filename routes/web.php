<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminInstrumentController;
use App\Http\Controllers\Admin\AdminPageContentController;
use App\Http\Controllers\Admin\AdminQuizQuestionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BisniskuController;
use App\Http\Controllers\MiniGameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/play', function () {
    if (Auth::check()) {
        return redirect()->route('menu');
    }

    return redirect()->route('login');
})->name('play');

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/menu', function () {
    return view('menu');
})->middleware('auth')->name('menu');

Route::middleware('auth')->group(function () {
    // Menu Utama Bisnisku
    Route::get('/bisnisku', [BisniskuController::class, 'index'])->name('bisnisku');
    
    // Sub-menu 1: Ide Bisnisku
    Route::get('/bisnisku/ide-bisnis', [BisniskuController::class, 'ideBisnis'])->name('bisnisku.ide-bisnis');
    Route::post('/bisnisku/ide-bisnis', [BisniskuController::class, 'submitIdeBisnis'])->name('bisnisku.ide-bisnis.submit');

    // Sub-menu 2: Rencana Keuangan
    Route::get('/bisnisku/rencana-keuangan', [BisniskuController::class, 'rencanaKeuangan'])->name('bisnisku.rencana-keuangan');
    Route::post('/bisnisku/rencana-keuangan/game', [BisniskuController::class, 'checkGameBelanja'])->name('bisnisku.rencana-keuangan.game');
    Route::post('/bisnisku/rencana-keuangan/hitung-modal', [BisniskuController::class, 'submitHitungModal'])->name('bisnisku.rencana-keuangan.hitung-modal');

    // Sub-menu 3: Pengembangan Bisnis
    Route::get('/bisnisku/pengembangan-bisnis', [BisniskuController::class, 'pengembanganBisnis'])->name('bisnisku.pengembangan-bisnis');
    Route::post('/bisnisku/pengembangan-bisnis/hitung-total', [BisniskuController::class, 'submitHitungTotalUsaha'])->name('bisnisku.pengembangan-bisnis.hitung-total');
    Route::post('/bisnisku/pengembangan-bisnis/tabungan', [BisniskuController::class, 'submitStudiKasusTabungan'])->name('bisnisku.pengembangan-bisnis.tabungan');
    Route::post('/bisnisku/pengembangan-bisnis/investasi', [BisniskuController::class, 'submitStudiKasusInvestasi'])->name('bisnisku.pengembangan-bisnis.investasi');

    Route::get('/petunjuk', function () {
        return view('petunjuk');
    })->name('petunjuk');

    Route::get('/minigame', [MiniGameController::class, 'index'])->name('minigame');
    
    // Level Selection & Management Dashboard (CRUD)
    Route::get('/minigame/editor', [MiniGameController::class, 'levelsIndex'])->name('minigame.editor');
    
    // Canvas Editor for Specific Level
    Route::get('/minigame/editor/{id}', [MiniGameController::class, 'editorCanvas'])->name('minigame.editor.canvas');
    
    // Level CRUD operations
    Route::post('/minigame/levels', [MiniGameController::class, 'storeLevel'])->name('minigame.levels.store');
    Route::post('/minigame/levels/{id}/info', [MiniGameController::class, 'updateLevelInfo'])->name('minigame.levels.updateInfo');
    Route::post('/minigame/levels/{id}/duplicate', [MiniGameController::class, 'duplicateLevel'])->name('minigame.levels.duplicate');
    Route::delete('/minigame/levels/{id}', [MiniGameController::class, 'deleteLevel'])->name('minigame.levels.delete');
    
    // Canvas Editor AJAX endpoints
    Route::post('/minigame/levels/save', [MiniGameController::class, 'saveLevel'])->name('minigame.levels.save');
    Route::get('/minigame/levels/{id}', [MiniGameController::class, 'loadLevel'])->name('minigame.levels.load');
    Route::post('/minigame/tilemaps/upload', [MiniGameController::class, 'uploadTilemap'])->name('minigame.tilemaps.upload');
    Route::post('/minigame/submit', [MiniGameController::class, 'submitScore'])->name('minigame.submit');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/quiz/start', [QuizController::class, 'start'])->name('quiz.start');
    Route::get('/quiz', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/quiz', [QuizController::class, 'answer'])->name('quiz.answer');
    Route::get('/quiz/result', [QuizController::class, 'result'])->name('quiz.result');
});

use App\Http\Controllers\Admin\AdminSpendingItemController;
use App\Http\Controllers\Admin\AdminSubmissionController;

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Submissions & Progres Siswa
    Route::get('/submissions', [AdminSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/export-excel', [AdminSubmissionController::class, 'exportExcel'])->name('submissions.export-excel');
    Route::post('/submissions/{id}/delete', [AdminSubmissionController::class, 'destroy'])->name('submissions.destroy');

    // Kelola Barang Belanja Game
    Route::get('/spending-items', [AdminSpendingItemController::class, 'index'])->name('spending-items.index');
    Route::get('/spending-items/create', [AdminSpendingItemController::class, 'create'])->name('spending-items.create');
    Route::post('/spending-items', [AdminSpendingItemController::class, 'store'])->name('spending-items.store');
    Route::get('/spending-items/{id}/edit', [AdminSpendingItemController::class, 'edit'])->name('spending-items.edit');
    Route::post('/spending-items/{id}', [AdminSpendingItemController::class, 'update'])->name('spending-items.update');
    Route::post('/spending-items/{id}/delete', [AdminSpendingItemController::class, 'destroy'])->name('spending-items.destroy');

    // Data Siswa
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/reset-progress', [AdminUserController::class, 'resetProgress'])->name('users.reset-progress');
    Route::post('/users/{id}/delete', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware('auth')->group(function () {

    Route::get('/page/{slug}', function (string $slug) {
        $allowed = [
            'asal-usul' => 'Asal Usul',
            'profil-seniman' => 'Profil Seniman',
            'alat-musik-oklik' => 'Alat Musik Oklik',
            'soal-evaluasi' => 'Soal Evaluasi',
            'tentang-media' => 'Tentang Media',
        ];

        abort_unless(array_key_exists($slug, $allowed), 404);

        $content = DB::table('page_contents')->where('slug', $slug)->first();
        $instruments = null;

        $assetVersioned = function (string $path): string {
            if (str_starts_with($path, 'data:') || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            if (str_starts_with($path, '/')) {
                return url($path);
            }

            $normalized = ltrim($path, '/');
            $full = public_path($normalized);
            $url = asset($normalized);

            if (file_exists($full)) {
                $url .= '?v='.filemtime($full).'-'.filesize($full);
            }

            return $url;
        };

        if ($slug === 'asal-usul' && Schema::hasTable('page_contents')) {
            if (! $content || ! is_string($content->body ?? null) || trim((string) $content->body) === '') {
                $slidesBody = json_encode([
                    'assets/slide1.png',
                    'assets/slide2.png',
                    'assets/slide3.png',
                    'assets/slide4.png',
                    'assets/slide5.png',
                ], JSON_UNESCAPED_SLASHES);

                $createdAt = DB::table('page_contents')->where('slug', $slug)->value('created_at') ?? now();

                DB::table('page_contents')->updateOrInsert(
                    ['slug' => $slug],
                    [
                        'title' => $content?->title ?? $allowed[$slug],
                        'body' => $slidesBody,
                        'updated_at' => now(),
                        'created_at' => $createdAt,
                    ]
                );

                $content = DB::table('page_contents')->where('slug', $slug)->first();
            }
        }

        $oklikSettings = null;
        if ($slug === 'alat-musik-oklik') {
            $oklikSettings = [];
            $decoded = null;
            if (is_string($content?->body ?? null) && trim((string) $content->body) !== '') {
                $decodedTmp = json_decode((string) $content->body, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedTmp)) {
                    $decoded = $decodedTmp;
                }
            }
            if (is_array($decoded)) {
                $oklikSettings = [
                    'sim_audio_a' => is_string($decoded['sim_audio_a'] ?? null) ? $decoded['sim_audio_a'] : null,
                    'sim_audio_b' => is_string($decoded['sim_audio_b'] ?? null) ? $decoded['sim_audio_b'] : null,
                    'sim_audio_c' => is_string($decoded['sim_audio_c'] ?? null) ? $decoded['sim_audio_c'] : null,
                    'sim_demo' => is_string($decoded['sim_demo'] ?? null) ? $decoded['sim_demo'] : null,
                ];
            }

            $resolveAudio = function (string $name, string $modelPath): ?string {
                $base = pathinfo($modelPath, PATHINFO_FILENAME);
                $lower = strtolower($name.' '.$base);

                $candidates = [
                    "assets/{$base}.m4a",
                    'assets/'.strtolower($base).'.m4a',
                ];

                if (str_contains($lower, 'kerep')) {
                    $candidates[] = 'assets/Kerep.m4a';
                }
                if (str_contains($lower, 'arang')) {
                    $candidates[] = 'assets/Arang.m4a';
                }
                if (str_contains($lower, 'gedhug') || str_contains($lower, 'gedhuh')) {
                    $candidates[] = 'assets/Gedhug.m4a';
                    $candidates[] = 'assets/Demo gedhuh.m4a';
                }

                foreach ($candidates as $path) {
                    $full = public_path($path);
                    if (file_exists($full)) {
                        $url = asset($path);
                        return $url.'?v='.filemtime($full).'-'.filesize($full);
                    }
                }

                return null;
            };

            $seed = [
                [
                    'page_slug' => 'alat-musik-oklik',
                    'position' => 1,
                    'name' => 'Klur',
                    'description' => implode("\n\n", [
                        'Klur merupakan bagian dari gedhug, jika tidak ada klur tidak ada gedhug.',
                    ]),
                    'model_path' => 'assets/klur.glb',
                ],
                [
                    'page_slug' => 'alat-musik-oklik',
                    'position' => 2,
                    'name' => 'Thintil Kerep',
                    'description' => implode("\n\n", [
                        'Thintil Kerep berperan sebagai pengisi ritme rapat yang membuat pola permainan terdengar lebih “rame” dan hidup.',
                        'Umumnya dimainkan pada bagian-bagian tertentu untuk memperkaya dinamika iringan.',
                    ]),
                    'model_path' => 'assets/thintilkerep.glb',
                ],
                [
                    'page_slug' => 'alat-musik-oklik',
                    'position' => 3,
                    'name' => 'Thintil Arang',
                    'description' => implode("\n\n", [
                        'Thintil Arang mengisi aksen ritme yang lebih renggang, sehingga memberi ruang pada ketukan dasar dan variasi instrumen lain.',
                        'Kombinasi pola rapat dan renggang membuat permainan Oklik terdengar seimbang.',
                    ]),
                    'model_path' => 'assets/thintilarang.glb',
                ],
                [
                    'page_slug' => 'alat-musik-oklik',
                    'position' => 4,
                    'name' => 'Gedhug',
                    'description' => implode("\n\n", [
                        'Gedhug bisa menghasilkan 3 suara yaitu nada A, B dan C.',
                        'Suara yang dihasilkan dari nada A sama dengan bunyi “thak” pada alat musik kendang.',
                        'Suara yang dihasilkan dari nada B sama dengan bunyi bass.',
                        'Suara yang dihasilkan nada C sama dengan bunyi klur.',
                    ]),
                    'model_path' => 'assets/gedhug.glb',
                ],
            ];

            if (Schema::hasTable('instrument_items')) {
                DB::table('instrument_items')
                    ->where('page_slug', $slug)
                    ->where('model_path', 'like', '%thur.glb')
                    ->update(['model_path' => 'assets/klur.glb']);

                $existingCount = (int) DB::table('instrument_items')->where('page_slug', $slug)->count();
                if ($existingCount === 0) {
                    foreach ($seed as $row) {
                        $payload = array_merge($row, [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        if (Schema::hasColumn('instrument_items', 'audio_path')) {
                            $payload['audio_path'] = null;
                        }
                        DB::table('instrument_items')->insert($payload);
                    }
                }

                $instruments = DB::table('instrument_items')
                    ->where('page_slug', $slug)
                    ->orderBy('position')
                    ->get()
                    ->map(function ($row) use ($assetVersioned, $resolveAudio) {
                        $modelPath = is_string($row->model_path ?? null) ? trim($row->model_path) : '';
                        $normalizedModelPath = ltrim($modelPath, '/');
                        if (str_ends_with($normalizedModelPath, 'thur.glb')) {
                            $normalizedModelPath = 'assets/klur.glb';
                        }

                        $audioPath = is_string($row->audio_path ?? null) ? trim((string) $row->audio_path) : '';
                        $audioUrl = $audioPath !== '' ? $assetVersioned($audioPath) : $resolveAudio($row->name, $normalizedModelPath);

                        return [
                            'name' => $row->name,
                            'description' => $row->description,
                            'src' => $assetVersioned($normalizedModelPath),
                            'audio' => $audioUrl,
                        ];
                    })
                    ->values();
            } else {
                $instruments = collect($seed)->map(fn ($row) => [
                    'name' => $row['name'],
                    'description' => $row['description'],
                    'src' => $assetVersioned($row['model_path']),
                    'audio' => $resolveAudio($row['name'], $row['model_path']),
                ])->values();
            }
        }

        return view('page', [
            'slug' => $slug,
            'title' => $content?->title ?? $allowed[$slug],
            'body' => $content?->body,
            'instruments' => $instruments,
            'oklikSettings' => $oklikSettings,
        ]);
    })->name('page');
});
