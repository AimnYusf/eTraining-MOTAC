<?php

namespace Database\Seeders;

use App\Models\EtraPeranan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perananSistem = [
            ['prn_id' => 1, 'prn_keterangan' => 'Baru', 'prn_class' => 'info'],
            ['prn_id' => 2, 'prn_keterangan' => 'Pengguna', 'prn_class' => 'success'],
            ['prn_id' => 3, 'prn_keterangan' => 'Pentadbir Latihan Bahagian', 'prn_class' => 'warning'],
            ['prn_id' => 4, 'prn_keterangan' => 'Urus Setia', 'prn_class' => 'primary'],
            ['prn_id' => 5, 'prn_keterangan' => 'Pentadbir Sistem', 'prn_class' => 'danger'],
        ];

        foreach ($perananSistem as $peranan) {
            EtraPeranan::create($peranan);
        }
    }
}
