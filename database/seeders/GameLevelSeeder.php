<?php

namespace Database\Seeders;

use App\Models\GameLevel;
use Illuminate\Database\Seeder;

class GameLevelSeeder extends Seeder
{
    public function run(): void
    {
        $defaultTileAssets = [
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
        ];

        $defaultNpcAssets = [
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
        ];

        // --- LEVEL 1 ---
        $grid1 = [];
        // Island 1
        for ($c = 0; $c < 28; $c++) {
            $grid1["{$c},14"] = 'dirt';
            $grid1["{$c},15"] = 'dirt2';
        }
        for ($c = 10; $c <= 14; $c++) $grid1["{$c},11"] = 'dirt';
        for ($c = 18; $c <= 22; $c++) $grid1["{$c},8"] = 'dirt';
        for ($c = 24; $c <= 27; $c++) $grid1["{$c},11"] = 'dirt';

        // Island 2
        for ($c = 34; $c < 60; $c++) {
            $grid1["{$c},14"] = 'dirt';
            $grid1["{$c},15"] = 'dirt2';
        }
        for ($c = 40; $c <= 44; $c++) $grid1["{$c},10"] = 'dirt';
        for ($c = 48; $c <= 52; $c++) $grid1["{$c},7"] = 'dirt';

        // Island 3 (Finish)
        for ($c = 66; $c < 105; $c++) {
            $grid1["{$c},14"] = 'dirt';
            $grid1["{$c},15"] = 'dirt2';
        }

        $map1 = [
            'levelLength' => 6000,
            'tileSize' => 40,
            'tileAssets' => $defaultTileAssets,
            'tileTypes' => ['dirt' => 'solid', 'dirt2' => 'solid'],
            'npcAssets' => $defaultNpcAssets,
            'gridMap' => $grid1,
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

        // --- LEVEL 2 ---
        $grid2 = [];
        // Island 1
        for ($c = 0; $c < 22; $c++) {
            $grid2["{$c},14"] = 'dirt';
            $grid2["{$c},15"] = 'dirt2';
        }
        // Stepping platforms 1
        for ($c = 8; $c <= 12; $c++) $grid2["{$c},11"] = 'dirt';
        for ($c = 15; $c <= 19; $c++) $grid2["{$c},8"] = 'dirt';

        // Island 2
        for ($c = 27; $c < 48; $c++) {
            $grid2["{$c},14"] = 'dirt';
            $grid2["{$c},15"] = 'dirt2';
        }
        for ($c = 32; $c <= 36; $c++) $grid2["{$c},10"] = 'dirt';
        for ($c = 39; $c <= 43; $c++) $grid2["{$c},6"] = 'dirt';
        for ($c = 45; $c <= 48; $c++) $grid2["{$c},9"] = 'dirt';

        // Floating bridges
        for ($c = 54; $c <= 59; $c++) $grid2["{$c},12"] = 'dirt';
        for ($c = 63; $c <= 68; $c++) $grid2["{$c},9"] = 'dirt';
        for ($c = 72; $c <= 77; $c++) $grid2["{$c},12"] = 'dirt';

        // Final Island
        for ($c = 82; $c < 115; $c++) {
            $grid2["{$c},14"] = 'dirt';
            $grid2["{$c},15"] = 'dirt2';
        }
        for ($c = 88; $c <= 92; $c++) $grid2["{$c},10"] = 'dirt';

        $map2 = [
            'levelLength' => 6500,
            'tileSize' => 40,
            'tileAssets' => $defaultTileAssets,
            'tileTypes' => ['dirt' => 'solid', 'dirt2' => 'solid'],
            'npcAssets' => $defaultNpcAssets,
            'gridMap' => $grid2,
            'spawnPoint' => ['x' => 100, 'y' => 400],
            'coins' => [
                ['x' => 400, 'y' => 380], ['x' => 460, 'y' => 380],
                ['x' => 680, 'y' => 260], ['x' => 740, 'y' => 260],
                ['x' => 1350, 'y' => 340], ['x' => 1620, 'y' => 180],
                ['x' => 2250, 'y' => 420], ['x' => 2600, 'y' => 300],
                ['x' => 2980, 'y' => 420], ['x' => 3500, 'y' => 500],
                ['x' => 3650, 'y' => 340], ['x' => 3800, 'y' => 500],
            ],
            'npcs' => [
                ['id' => 1, 'x' => 850, 'y' => 470, 'w' => 90, 'h' => 90, 'assetId' => 'npc_idle', 'questionIndex' => 1],
                ['id' => 2, 'x' => 1850, 'y' => 470, 'w' => 90, 'h' => 90, 'assetId' => 'npc_idle', 'questionIndex' => 2],
            ],
            'finishFlag' => ['x' => 4200, 'y' => 380, 'w' => 60, 'h' => 180],
        ];

        // --- LEVEL 3 ---
        $grid3 = [];
        // Island 1
        for ($c = 0; $c < 20; $c++) {
            $grid3["{$c},14"] = 'dirt';
            $grid3["{$c},15"] = 'dirt2';
        }
        for ($c = 6; $c <= 10; $c++) $grid3["{$c},11"] = 'dirt';
        for ($c = 13; $c <= 17; $c++) $grid3["{$c},8"] = 'dirt';

        // Floating island cluster 1
        for ($c = 24; $c <= 28; $c++) $grid3["{$c},13"] = 'dirt';
        for ($c = 31; $c <= 35; $c++) $grid3["{$c},10"] = 'dirt';
        for ($c = 38; $c <= 42; $c++) $grid3["{$c},7"] = 'dirt';
        for ($c = 45; $c <= 49; $c++) $grid3["{$c},10"] = 'dirt';

        // Mid Island
        for ($c = 54; $c < 75; $c++) {
            $grid3["{$c},14"] = 'dirt';
            $grid3["{$c},15"] = 'dirt2';
        }
        for ($c = 58; $c <= 62; $c++) $grid3["{$c},10"] = 'dirt';
        for ($c = 66; $c <= 70; $c++) $grid3["{$c},6"] = 'dirt';

        // High Pillars
        for ($c = 80; $c <= 84; $c++) $grid3["{$c},12"] = 'dirt';
        for ($c = 88; $c <= 92; $c++) $grid3["{$c},8"] = 'dirt';
        for ($c = 96; $c <= 100; $c++) $grid3["{$c},11"] = 'dirt';

        // Grand Finish Island
        for ($c = 105; $c < 135; $c++) {
            $grid3["{$c},14"] = 'dirt';
            $grid3["{$c},15"] = 'dirt2';
        }
        for ($c = 110; $c <= 115; $c++) $grid3["{$c},10"] = 'dirt';
        for ($c = 120; $c <= 125; $c++) $grid3["{$c},6"] = 'dirt';

        $map3 = [
            'levelLength' => 7500,
            'tileSize' => 40,
            'tileAssets' => $defaultTileAssets,
            'tileTypes' => ['dirt' => 'solid', 'dirt2' => 'solid'],
            'npcAssets' => $defaultNpcAssets,
            'gridMap' => $grid3,
            'spawnPoint' => ['x' => 100, 'y' => 400],
            'coins' => [
                ['x' => 320, 'y' => 380], ['x' => 580, 'y' => 260],
                ['x' => 1040, 'y' => 460], ['x' => 1320, 'y' => 340],
                ['x' => 1600, 'y' => 220], ['x' => 1880, 'y' => 340],
                ['x' => 2300, 'y' => 500], ['x' => 2400, 'y' => 340],
                ['x' => 2720, 'y' => 180], ['x' => 3280, 'y' => 420],
                ['x' => 3600, 'y' => 260], ['x' => 3920, 'y' => 380],
                ['x' => 4350, 'y' => 500], ['x' => 4500, 'y' => 340],
                ['x' => 4900, 'y' => 180],
            ],
            'npcs' => [
                ['id' => 1, 'x' => 750, 'y' => 470, 'w' => 90, 'h' => 90, 'assetId' => 'npc_idle', 'questionIndex' => 0],
                ['id' => 2, 'x' => 2950, 'y' => 470, 'w' => 90, 'h' => 90, 'assetId' => 'npc_idle', 'questionIndex' => 1],
                ['id' => 3, 'x' => 4700, 'y' => 470, 'w' => 90, 'h' => 90, 'assetId' => 'npc_idle', 'questionIndex' => 2],
            ],
            'finishFlag' => ['x' => 5100, 'y' => 380, 'w' => 60, 'h' => 180],
        ];

        // Seed or update Level 1
        GameLevel::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Level 1: Menuju Panggung Oklik',
                'description' => 'Petualangan perdana menelusuri rintangan dan menjawab kuis pengenalan Oklik.',
                'map_data' => $map1,
                'is_active' => true,
            ]
        );

        // Seed or update Level 2
        GameLevel::updateOrCreate(
            ['id' => 2],
            [
                'title' => 'Level 2: Rintangan Desa Budaya',
                'description' => 'Tantangan melompat antar platform mengambang dan menjawab kuis sejarah Oklik.',
                'map_data' => $map2,
                'is_active' => true,
            ]
        );

        // Seed or update Level 3
        GameLevel::updateOrCreate(
            ['id' => 3],
            [
                'title' => 'Level 3: Puncak Pentas Oklik',
                'description' => 'Tantangan pamungkas melompati platform tinggi dan menjawab kuis alat musik Oklik.',
                'map_data' => $map3,
                'is_active' => true,
            ]
        );
    }
}
