<?php

namespace Database\Seeders;

use App\Models\EproTempat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TempatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tempatKursus = [
            ['tem_id' => "1", 'tem_keterangan' => " Dewan Sanggar Pujangga, MOTAC", 'tem_alamat' => " Kementerian Pelancongan, Seni dan Budaya Malaysia,\r\nNo. 2, Menara 1, Jalan P5/6, Presint 5, 62200 PUTRAJAYA", 'tem_gmaps' => ""],
            ['tem_id' => "2", 'tem_keterangan' => " Makmal ICT BPM", 'tem_alamat' => " BPM MOTAC Aras 5", 'tem_gmaps' => ""],
            ['tem_id' => "3", 'tem_keterangan' => " Bilik Latihan BPSM", 'tem_alamat' => " BPSM MOTAC", 'tem_gmaps' => ""],
            ['tem_id' => "4", 'tem_keterangan' => " Serene Resort & Training Centre, Janda Baik, Pahang", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "5", 'tem_keterangan' => " SECARA ONLINE", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "6", 'tem_keterangan' => " Hotel Seri Malaysia Melaka ", 'tem_alamat' => " Lot PT 12332, Lebuh Ayer Keroh, 75760 Ayer Keroh, Malacca", 'tem_gmaps' => ""],
            ['tem_id' => "7", 'tem_keterangan' => " Hotel Seri Malaysia Port Dickson", 'tem_alamat' => " Hotel Seri Malaysia, 49, Jalan Pantai, Taman Dato Haji Abdul Samad, 71050 Port Dickson, Negeri Sembilan", 'tem_gmaps' => ""],
            ['tem_id' => "8", 'tem_keterangan' => " Hotel Seri Malaysia Ipoh", 'tem_alamat' => " Jalan Sturrock, 31350 Ipoh, Negeri Perak", 'tem_gmaps' => ""],
            ['tem_id' => "9", 'tem_keterangan' => " Terengganu", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "10", 'tem_keterangan' => " Hotel Seri Malaysia Genting Highland", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "11", 'tem_keterangan' => " Surau Mutmainnah, Aras 1, MOTAC", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "12", 'tem_keterangan' => " Hotel Seri Malaysia Mersing", 'tem_alamat' => " Jalan Ismail, Mersing Kechil, 86800 Mersing, Johor", 'tem_gmaps' => ""],
            ['tem_id' => "13", 'tem_keterangan' => " INTAN KAMPUS WILAYAH UTARA INTURA", 'tem_alamat' => " INTAN KAMPUS WILAYAH UTARA INTURA\r\nPETI SURAT 94\r\n08007 SUNGAI PETANI\r\nKEDAH", 'tem_gmaps' => ""],
            ['tem_id' => "14", 'tem_keterangan' => " Melaka", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "15", 'tem_keterangan' => " Dewan Zaaba KPT", 'tem_alamat' => " Kementerian Pendidikan Tinggi\r\nNo. 2, Menara 2,\r\nJalan P5/6, Presint 5,\r\n62200 Putrajaya, Malaysia", 'tem_gmaps' => ""],
            ['tem_id' => "16", 'tem_keterangan' => " Negeri Sembilan ", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "17", 'tem_keterangan' => " Grand Kampar Hotel, Perak", 'tem_alamat' => " 2188, Jalan Timah, Bandar Baru, 31900 Kampar, Perak", 'tem_gmaps' => ""],
            ['tem_id' => "18", 'tem_keterangan' => " Makmal Komputer, BPSM", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "19", 'tem_keterangan' => " Perak", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "20", 'tem_keterangan' => " Pulau Pinang", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "21", 'tem_keterangan' => " Hotel akan dimaklum kemudian", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "22", 'tem_keterangan' => " Bilik Latihan KPT", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "23", 'tem_keterangan' => " Pahang", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "24", 'tem_keterangan' => " Kuala Lumpur", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "25", 'tem_keterangan' => " Selangor", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "26", 'tem_keterangan' => " SURAU AL-MUNAWWARAH", 'tem_alamat' => " KUARTERS 5R3, PRESINT 5 PUTRAJAYA", 'tem_gmaps' => ""],
            ['tem_id' => "27", 'tem_keterangan' => " Solesor Kampong Beach Resort, Port Dickson", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "28", 'tem_keterangan' => " Bilik Latihan ICT, Tourism Malaysia", 'tem_alamat' => " ", 'tem_gmaps' => ""],
            ['tem_id' => "29", 'tem_keterangan' => " DEWAN DAMAR SARI, KOMPLEKS F", 'tem_alamat' => "  BLOK F8, KOMPLEKS F, PUTRAJAYA", 'tem_gmaps' => ""],
        ];

        foreach ($tempatKursus as $tempat) {
            EproTempat::create($tempat);
        }
    }
}
