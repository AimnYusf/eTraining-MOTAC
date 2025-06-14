<?php

namespace Database\Seeders;

use App\Models\EproJabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanPegawai = [
            ['jab_id' => 1, 'jab_ketring' => 'MOTAC', 'jab_ketpenu' => 'Kementerian Pelancongan,  Seni dan Budaya Malaysia'],
            ['jab_id' => 2, 'jab_ketring' => 'TM', 'jab_ketpenu' => 'Tourism Malaysia'],
            ['jab_id' => 3, 'jab_ketring' => 'ARKIB', 'jab_ketpenu' => 'Arkib Negara Malaysia'],
            ['jab_id' => 4, 'jab_ketring' => 'PNM', 'jab_ketpenu' => 'Perpustakaan Negara Malaysia'],
            ['jab_id' => 5, 'jab_ketring' => 'JMM', 'jab_ketpenu' => 'Jabatan Muzium Malaysia'],
            ['jab_id' => 6, 'jab_ketring' => 'JWN', 'jab_ketpenu' => 'Jabatan Warisan Negara'],
            ['jab_id' => 7, 'jab_ketring' => 'JKKN', 'jab_ketpenu' => 'Jabatan Kebudayaan dan Kesenian Negara'],
            ['jab_id' => 8, 'jab_ketring' => 'IB', 'jab_ketpenu' => 'Istana Budaya'],
            ['jab_id' => 9, 'jab_ketring' => 'ASWARA', 'jab_ketpenu' => 'Akademi Seni Budaya dan Warisan Kebangsaan'],
            ['jab_id' => 10, 'jab_ketring' => 'KRAF', 'jab_ketpenu' => 'Perbadanan Kemajuan Kraftangan Malaysia'],
            ['jab_id' => 11, 'jab_ketring' => 'BSN', 'jab_ketpenu' => 'Balai Seni Negara'],
            ['jab_id' => 12, 'jab_ketring' => 'ITC', 'jab_ketpenu' => 'Islamic Tourism Centre'],
            ['jab_id' => 13, 'jab_ketring' => 'MYCEB', 'jab_ketpenu' => 'MyCEB'],
            ['jab_id' => 14, 'jab_ketring' => 'LAIN', 'jab_ketpenu' => 'Lain-Lain'],
        ];

        foreach ($jabatanPegawai as $jabatan) {
            EproJabatan::create($jabatan);
        }
    }
}
