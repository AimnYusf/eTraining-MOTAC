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
            ['kum_id' => 3, 'kum_keterangan' => 'Pelaksana', 'kum_order' => 3],
        ];

        foreach ($kumpulanKursus as $kumpulan) {
            EproKumpulan::create($kumpulan);
        }
    }
}