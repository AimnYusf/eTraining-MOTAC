<?php

namespace Database\Seeders;

use App\Models\EproKumpulan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KumpulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kumpulanKursus = [
            ['kum_id' => 1, 'kum_ketring' => 'JUSA', 'kum_ketpenu' => 'JUSA', 'kum_order' => 1],
            ['kum_id' => 2, 'kum_ketring' => 'P&P', 'kum_ketpenu' => 'Pengurusan & Profesional', 'kum_order' => 2],
            ['kum_id' => 3, 'kum_ketring' => null, 'kum_ketpenu' => 'Setiusaha Pejabat', 'kum_order' => 3],
            ['kum_id' => 4, 'kum_ketring' => null, 'kum_ketpenu' => 'Pembantu Setiusaha Pejabat', 'kum_order' => 4],
            ['kum_id' => 5, 'kum_ketring' => 'P', 'kum_ketpenu' => 'Pelaksana', 'kum_order' => 5],
            ['kum_id' => 6, 'kum_ketring' => null, 'kum_ketpenu' => 'Pekerja Sambilan Harian PSH', 'kum_order' => 6],
            ['kum_id' => 7, 'kum_ketring' => null, 'kum_ketpenu' => 'Lantikan Baharu', 'kum_order' => 7],
            ['kum_id' => 8, 'kum_ketring' => null, 'kum_ketpenu' => 'Ahli AKRAB', 'kum_order' => 8],
            ['kum_id' => 9, 'kum_ketring' => null, 'kum_ketpenu' => 'Terbuka', 'kum_order' => 9],
        ];

        foreach ($kumpulanKursus as $kumpulan) {
            EproKumpulan::create($kumpulan);
        }
    }
}
