<?php

namespace Database\Seeders;

use App\Models\EproKursus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class KursusSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('ms_MY');

        for ($i = 1; $i <= 30; $i++) {
            $startDate = Carbon::now()->subDays(60)->addDays($i); // slowly increasing date
            $endDate = (clone $startDate)->addDays(rand(1, 3));
            $openDate = (clone $startDate)->subDays(rand(15, 30));
            $closeDate = (clone $startDate)->subDays(rand(1, 10));
            $replyDate = (clone $closeDate)->addDays(rand(1, 3));

            EproKursus::create([
                'kur_nama' => 'Kursus ' . $faker->words(2, true),
                'kur_objektif' => $faker->paragraph,
                'kur_idkategori' => rand(1, 5),
                'kur_idpenganjur' => 1,
                'kur_tkhmula' => $startDate->format('Y-m-d'),
                'kur_msamula' => $faker->time('H:i'),
                'kur_tkhtamat' => $endDate->format('Y-m-d'),
                'kur_msatamat' => $faker->time('H:i'),
                'kur_bilhari' => abs($endDate->diffInDays($startDate)) + 1,
                'kur_idtempat' => rand(1, 29),
                'kur_tkhbuka' => $openDate->format('Y-m-d'),
                'kur_tkhtutup' => $closeDate->format('Y-m-d'),
                'kur_bilpeserta' => rand(10, 100),
                'kur_idkumpulan' => rand(1, 9),
                'kur_poster' => '/poster/no-image.jpg',
                'kur_status' => rand(0, 1),
                'created_at' => $startDate,
                'updated_at' => $startDate,
            ]);
        }
    }
}
