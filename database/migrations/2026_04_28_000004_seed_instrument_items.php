<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
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

        foreach ($rows as $row) {
            DB::table('instrument_items')->updateOrInsert(
                [
                    'page_slug' => $row['page_slug'],
                    'position' => $row['position'],
                ],
                array_merge($row, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    public function down(): void
    {
        DB::table('instrument_items')->where('page_slug', 'alat-musik-oklik')->delete();
    }
};
