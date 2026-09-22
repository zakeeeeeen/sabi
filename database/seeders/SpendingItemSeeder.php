<?php

namespace Database\Seeders;

use App\Models\SpendingItem;
use Illuminate\Database\Seeder;

class SpendingItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset old items to ensure clean order and structure
        SpendingItem::truncate();

        $items = [
            [
                'name' => 'Menyewa mesin produksi canggih selama satu kali produksi.',
                'price' => 750000,
                'category' => 'pendukung',
                'is_correct' => false,
                'order_num' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Mengundang artis untuk promosi produk sebanyak satu kali.',
                'price' => 400000,
                'category' => 'pendukung',
                'is_correct' => false,
                'order_num' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Kulit kerang dari pemasok, lem, tali, dan kemasan normal.',
                'price' => 250000,
                'category' => 'utama',
                'is_correct' => true,
                'order_num' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Gaji dua pegawai untuk satu kali produksi.',
                'price' => 300000,
                'category' => 'utama',
                'is_correct' => true,
                'order_num' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Promosi pengembangan usaha 3 kali dalam satu bulan.',
                'price' => 150000,
                'category' => 'utama',
                'is_correct' => true,
                'order_num' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            SpendingItem::create($item);
        }
    }
}
