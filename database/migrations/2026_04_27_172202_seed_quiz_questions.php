<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $rows = [
            [
                'position' => 1,
                'question' => 'Peristiwa yang melatarbelakangi munculnya kesenian Oklik di Desa Sobontoro adalah ...',
                'option_a' => 'Perang kemerdekaan',
                'option_b' => 'Festival budaya',
                'option_c' => 'Pagebluk dan pencurian',
                'option_d' => 'Pembangunan desa',
                'correct_option' => 'c',
            ],
            [
                'position' => 2,
                'question' => 'Oklik termasuk ke dalam jenis kesenian ...',
                'option_a' => 'Tari tradisional',
                'option_b' => 'Musik tradisional',
                'option_c' => 'Teater rakyat',
                'option_d' => 'Seni rupa',
                'correct_option' => 'b',
            ],
            [
                'position' => 3,
                'question' => 'Nama “Oklik” berasal dari bunyi alat yang dimainkan, yaitu ...',
                'option_a' => 'Kletek-kletek',
                'option_b' => 'Oklik-oklik',
                'option_c' => 'Dung-dung',
                'option_d' => 'Prak-prak',
                'correct_option' => 'b',
            ],
            [
                'position' => 4,
                'question' => 'Bahan utama alat musik Oklik umumnya berasal dari ...',
                'option_a' => 'Besi',
                'option_b' => 'Kaca',
                'option_c' => 'Kayu dan bambu',
                'option_d' => 'Kulit hewan',
                'correct_option' => 'c',
            ],
            [
                'position' => 5,
                'question' => 'Kesenian Oklik berasal dari daerah ...',
                'option_a' => 'Bojonegoro',
                'option_b' => 'Tuban',
                'option_c' => 'Lamongan',
                'option_d' => 'Madiun',
                'correct_option' => 'a',
            ],
            [
                'position' => 6,
                'question' => 'Fungsi awal kesenian Oklik di masyarakat adalah untuk ...',
                'option_a' => 'Hiburan panggung modern',
                'option_b' => 'Menjaga keamanan kampung',
                'option_c' => 'Perayaan ulang tahun',
                'option_d' => 'Pertandingan olahraga',
                'correct_option' => 'b',
            ],
            [
                'position' => 7,
                'question' => 'Dalam pertunjukan Oklik, pemain biasanya berjumlah ...',
                'option_a' => '1–2 orang',
                'option_b' => '3–5 orang',
                'option_c' => '6–10 orang',
                'option_d' => 'Lebih dari 30 orang',
                'correct_option' => 'c',
            ],
            [
                'position' => 8,
                'question' => 'Oklik dimainkan dengan cara ...',
                'option_a' => 'Dipetik',
                'option_b' => 'Digesek',
                'option_c' => 'Ditiup',
                'option_d' => 'Dipukul',
                'correct_option' => 'd',
            ],
            [
                'position' => 9,
                'question' => 'Salah satu tujuan pembelajaran pada media Sinau Oklik adalah ...',
                'option_a' => 'Belajar memasak',
                'option_b' => 'Belajar seni budaya lokal',
                'option_c' => 'Belajar matematika',
                'option_d' => 'Belajar bahasa asing',
                'correct_option' => 'b',
            ],
            [
                'position' => 10,
                'question' => 'Soal evaluasi pada media ini bertujuan untuk ...',
                'option_a' => 'Menguji pemahaman tentang Oklik',
                'option_b' => 'Menentukan pemenang lomba',
                'option_c' => 'Menghitung nilai rapor',
                'option_d' => 'Menentukan jadwal latihan',
                'correct_option' => 'a',
            ],
        ];

        foreach ($rows as $row) {
            DB::table('quiz_questions')->updateOrInsert(
                ['position' => $row['position']],
                array_merge($row, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    public function down(): void
    {
        DB::table('quiz_questions')->truncate();
    }
};
