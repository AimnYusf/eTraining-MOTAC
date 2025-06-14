<?php

namespace Database\Seeders;

use App\Models\EproPenganjur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenganjurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penganjurKursus = [
            ['pjr_id' => 1, 'pjr_keterangan' => 'BPSM, MOTAC']
        ];

        foreach ($penganjurKursus as $penganjur) {
            EproPenganjur::create($penganjur);
        }
    }
}
