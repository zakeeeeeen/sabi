<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('page_contents')->updateOrInsert(
            ['slug' => 'soal-evaluasi'],
            [
                'title' => 'Soal Evaluasi',
                'body' => implode("\n", [
                    'Kamu akan mengerjakan 10 soal tentang pengetahuan Oklik.',
                    'Yuk buktikan seberapa jauh pemahamanmu!',
                    '',
                    'Selamat Mengerjakan!',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('page_contents')->where('slug', 'soal-evaluasi')->delete();
    }
};
