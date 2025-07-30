<?php

namespace Database\Seeders;

use App\Models\EtraKumpulan;
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
            ['kum_id' => 1, 'kum_ketring' => 'JUSA', 'kum_ketpenu' => 'JUSA'],
            ['kum_id' => 2, 'kum_ketring' => 'P&P', 'kum_ketpenu' => 'Pengurusan & Profesional'],
            ['kum_id' => 3, 'kum_ketring' => null, 'kum_ketpenu' => 'Setiusaha Pejabat'],
            ['kum_id' => 4, 'kum_ketring' => null, 'kum_ketpenu' => 'Pembantu Setiusaha Pejabat'],
            ['kum_id' => 5, 'kum_ketring' => 'P', 'kum_ketpenu' => 'Pelaksana'],
            ['kum_id' => 6, 'kum_ketring' => null, 'kum_ketpenu' => 'Pekerja Sambilan Harian PSH'],
            ['kum_id' => 7, 'kum_ketring' => null, 'kum_ketpenu' => 'Lantikan Baharu'],
            ['kum_id' => 8, 'kum_ketring' => null, 'kum_ketpenu' => 'Ahli AKRAB'],
            ['kum_id' => 9, 'kum_ketring' => null, 'kum_ketpenu' => 'Terbuka'],
        ];

        foreach ($kumpulanKursus as $kumpulan) {
            EtraKumpulan::create($kumpulan);
        }
    }
}
