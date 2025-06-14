<?php

namespace Database\Seeders;

use App\Models\EproStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusPermohonan = [
            ['stp_id' => 1, 'stp_ketring' => 'Baru', 'stp_ketpenu' => 'Permohonan Baru', 'stp_class' => 'info'],
            ['stp_id' => 2, 'stp_ketring' => 'Pengesahan', 'stp_ketpenu' => 'Permohonan Diluluskan Pegawai Penyokong', 'stp_class' => 'warning'],
            ['stp_id' => 3, 'stp_ketring' => 'Tidak Lulus', 'stp_ketpenu' => 'Permohonan Tidak Diluluskan Pegawai Penyokong', 'stp_class' => 'danger'],
            ['stp_id' => 4, 'stp_ketring' => 'Berjaya', 'stp_ketpenu' => 'Permohonan Berjaya', 'stp_class' => 'success'],
            ['stp_id' => 5, 'stp_ketring' => 'Tidak Berjaya', 'stp_ketpenu' => 'Permohonan Tidak Berjaya', 'stp_class' => 'danger'],
            ['stp_id' => 6, 'stp_ketring' => 'KIV', 'stp_ketpenu' => 'KIV', 'stp_class' => 'warning'],
        ];

        foreach ($statusPermohonan as $status) {
            EproStatus::create($status);
        }
    }
}
