<?php

namespace Database\Seeders;

use App\Models\EproBahagian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BahagianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahagianPegawai = [
            ['bah_id' => 1, 'bah_ketring' => 'YBM', 'bah_ketpenu' => 'Pejabat Menteri'],
            ['bah_id' => 2, 'bah_ketring' => 'YBTM', 'bah_ketpenu' => 'Pejabat Timbalan Menteri'],
            ['bah_id' => 3, 'bah_ketring' => 'KSU', 'bah_ketpenu' => 'Pejabat Ketua Setiausaha'],
            ['bah_id' => 4, 'bah_ketring' => 'TKSUK', 'bah_ketpenu' => 'Pejabat Timbalan Ketua Setiausaha Kebudayaan'],
            ['bah_id' => 5, 'bah_ketring' => 'TKSUPL', 'bah_ketpenu' => 'Pejabat Timbalan Ketua Setiausaha Pelancongan'],
            ['bah_id' => 6, 'bah_ketring' => 'TKSUP', 'bah_ketpenu' => 'Pejabat Setiausaha Bahagian Kanan Pengurusan'],
            ['bah_id' => 7, 'bah_ketring' => 'DPL', 'bah_ketpenu' => 'Bahagian Dasar Pelancongan dan Hubungan Antarabangsa'],
            ['bah_id' => 8, 'bah_ketring' => 'DK', 'bah_ketpenu' => 'Bahagian Dasar Kebudayaan'],
            ['bah_id' => 9, 'bah_ketring' => 'HAK', 'bah_ketpenu' => 'Bahagian Hubungan Antarabangsa Kebudayaan'],
            ['bah_id' => 10, 'bah_ketring' => 'PI', 'bah_ketpenu' => 'Bahagian Pembangunan Industri'],
            ['bah_id' => 11, 'bah_ketring' => 'BPA', 'bah_ketpenu' => 'Bahagian Pengurusan Acara'],
            ['bah_id' => 12, 'bah_ketring' => 'BK', 'bah_ketpenu' => 'Bahagian Kewangan'],
            ['bah_id' => 13, 'bah_ketring' => 'BT', 'bah_ketpenu' => 'Bahagian Pentadbiran'],
            ['bah_id' => 14, 'bah_ketring' => 'BA', 'bah_ketpenu' => 'Bahagian Akaun'],
            ['bah_id' => 15, 'bah_ketring' => 'BPLN', 'bah_ketpenu' => 'Bahagian Pelesenan dan Penguatkuasaan Pelancongan'],
            ['bah_id' => 16, 'bah_ketring' => 'BPM', 'bah_ketpenu' => 'Bahagian Pengurusan Maklumat'],
            ['bah_id' => 17, 'bah_ketring' => 'BPSM', 'bah_ketpenu' => 'Bahagian Pengurusan Sumber Manusia'],
            ['bah_id' => 18, 'bah_ketring' => 'PP', 'bah_ketpenu' => 'Bahagian Pembangunan Prasarana'],
            ['bah_id' => 19, 'bah_ketring' => 'MATIC', 'bah_ketpenu' => 'Pusat Pelancongan Malaysia MaTiC'],
            ['bah_id' => 20, 'bah_ketring' => 'MM2H', 'bah_ketpenu' => 'Pusat Malaysia Rumah Keduaku MM2H'],
            ['bah_id' => 21, 'bah_ketring' => 'UKK', 'bah_ketpenu' => 'Unit Komunikasi Korporat'],
            ['bah_id' => 22, 'bah_ketring' => 'UP', 'bah_ketpenu' => 'Unit Perundangan'],
            ['bah_id' => 23, 'bah_ketring' => 'UAD', 'bah_ketpenu' => 'Unit Audit Dalam'],
            ['bah_id' => 24, 'bah_ketring' => 'UI', 'bah_ketpenu' => 'Unit Integriti'],
            ['bah_id' => 25, 'bah_ketring' => 'KPI', 'bah_ketpenu' => 'Unit Petunjuk Prestasi Utama KPI'],
            ['bah_id' => 26, 'bah_ketring' => 'Perlis', 'bah_ketpenu' => 'MOTAC Perlis'],
            ['bah_id' => 27, 'bah_ketring' => 'Kedah', 'bah_ketpenu' => 'MOTAC Kedah'],
            ['bah_id' => 28, 'bah_ketring' => 'Penang', 'bah_ketpenu' => 'MOTAC Pulau Pinang'],
            ['bah_id' => 29, 'bah_ketring' => 'Perak', 'bah_ketpenu' => 'MOTAC Perak'],
            ['bah_id' => 30, 'bah_ketring' => 'Selangor', 'bah_ketpenu' => 'MOTAC Selangor'],
            ['bah_id' => 31, 'bah_ketring' => 'Melaka', 'bah_ketpenu' => 'MOTAC Melaka'],
            ['bah_id' => 32, 'bah_ketring' => 'Negeri Sembilan', 'bah_ketpenu' => 'MOTAC Negeri Sembilan'],
            ['bah_id' => 33, 'bah_ketring' => 'Johor', 'bah_ketpenu' => 'MOTAC Johor'],
            ['bah_id' => 34, 'bah_ketring' => 'Kelantan', 'bah_ketpenu' => 'MOTAC Kelantan'],
            ['bah_id' => 35, 'bah_ketring' => 'Terengganu', 'bah_ketpenu' => 'MOTAC Terengganu'],
            ['bah_id' => 36, 'bah_ketring' => 'Pahang', 'bah_ketpenu' => 'MOTAC Pahang'],
            ['bah_id' => 37, 'bah_ketring' => 'Sarawak', 'bah_ketpenu' => 'MOTAC Sarawak'],
            ['bah_id' => 38, 'bah_ketring' => 'Sabah', 'bah_ketpenu' => 'MOTAC Sabah'],
            ['bah_id' => 39, 'bah_ketring' => 'KL/Putrajaya', 'bah_ketpenu' => 'MOTAC Kuala Lumpur/Putrajaya'],
            ['bah_id' => 40, 'bah_ketring' => 'Labuan', 'bah_ketpenu' => 'MOTAC Labuan'],
            ['bah_id' => 41, 'bah_ketring' => 'UKCOVID19', 'bah_ketpenu' => 'Unit Khas COVID-19'],
        ];

        foreach ($bahagianPegawai as $bahagian) {
            EproBahagian::create($bahagian);
        }
    }
}
