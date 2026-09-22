<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->timestamps();
        });

        DB::table('page_contents')->updateOrInsert(
            ['slug' => 'tentang-media'],
            [
                'title' => 'Tentang Media',
                'body' => implode("\n\n", [
                    "'Sinau Oklik' merupakan media berbasis web app interaktif yang dikembangkan untuk mendukung pembelajaran seni budaya, khususnya pada materi seni musik tradisional Oklik.",
                    'Media ini dirancang sebagai sarana belajar yang menarik, mudah diakses, dan mampu meningkatkan minat serta pemahaman siswa terhadap budaya lokal.',
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
        Schema::dropIfExists('page_contents');
    }
};
