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
            ['kum_id' => 1, 'kum_keterangan' => 'JUSA', 'kum_order' => 1],
            ['kum_id' => 2, 'kum_keterangan' => 'Pengurusan & Profesional', 'kum_order' => 2],
            ['kum_id' => 3, 'kum_keterangan' => 'Pelaksana', 'kum_order' => 5],
            ['kum_id' => 4, 'kum_keterangan' => 'Terbuka', 'kum_order' => 6],
            ['kum_id' => 5, 'kum_keterangan' => 'Pekerja Sambilan Harian PSH', 'kum_order' => 9],
            ['kum_id' => 6, 'kum_keterangan' => 'Ahli AKRAB', 'kum_order' => 7],
            ['kum_id' => 7, 'kum_keterangan' => 'Lantikan Baharu', 'kum_order' => 8],
            ['kum_id' => 8, 'kum_keterangan' => 'Setiusaha Pejabat', 'kum_order' => 3],
            ['kum_id' => 9, 'kum_keterangan' => 'Pembantu Setiusaha Pejabat', 'kum_order' => 4],
        ];

        foreach ($kumpulanKursus as $kumpulan) {
            EproKumpulan::create($kumpulan);
        }
    }
}
