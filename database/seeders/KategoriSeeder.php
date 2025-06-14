<?php

namespace Database\Seeders;

use App\Models\EproKategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriKursus = [
            ['kat_id' => 1, 'kat_keterangan' => 'Perkhidmatan'],
            ['kat_id' => 2, 'kat_keterangan' => 'Pengurusan Kewangan'],
            ['kat_id' => 3, 'kat_keterangan' => 'Peningkatan Kompetensi dan Kerjaya'],
            ['kat_id' => 4, 'kat_keterangan' => 'Penerapan Nilai-Nilai Murni'],
            ['kat_id' => 5, 'kat_keterangan' => 'Psikologi'],
        ];

        foreach ($kategoriKursus as $kategori) {
            EproKategori::create($kategori);
        }
    }
}
