<?php

namespace Database\Seeders;

use App\Models\EtraStatus;
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
            ['stp_id' => 1, 'stp_keterangan' => 'Menunggu Sokongan Pegawai Penyelia', 'stp_class' => 'warning'],
            ['stp_id' => 2, 'stp_keterangan' => 'Menunggu Kelulusan Urusetia', 'stp_class' => 'warning'],
            ['stp_id' => 3, 'stp_keterangan' => 'Tidak Disokong', 'stp_class' => 'danger'],
            ['stp_id' => 4, 'stp_keterangan' => 'Berjaya', 'stp_class' => 'success'],
            ['stp_id' => 5, 'stp_keterangan' => 'Tidak Berjaya', 'stp_class' => 'danger'],
        ];

        foreach ($statusPermohonan as $status) {
            EtraStatus::create($status);
        }
    }
}
