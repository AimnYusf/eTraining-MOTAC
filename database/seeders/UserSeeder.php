<?php

namespace Database\Seeders;

use App\Models\EproPengguna;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = \Faker\Factory::create('ms_MY');

        for ($i = 1; $i <= 20; $i++) {
            $name = $i === 1 ? 'Superadmin' : $faker->name;
            $email = $i === 1 ? 'superadmin@motac.gov.my' : $faker->unique()->safeEmail;

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('asd123'),
                'role' => $i === 1 ? 'superadmin' : 'user',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

            EproPengguna::create([
                'pen_idusers' => $user->id,
                'pen_nama' => $name,
                'pen_nokp' => $faker->numerify('##########'),
                'pen_jantina' => rand(1, 2),
                'pen_jawatan' => $faker->jobTitle,
                'pen_gred' => 'G' . rand(1, 52),
                'pen_idkumpulan' => rand(1, 9),
                'pen_idjabatan' => rand(1, 14),
                'pen_idbahagian' => rand(1, 25),
                'pen_jabatanlain' => $faker->company,
                'pen_emel' => $email,
                'pen_notel' => $faker->phoneNumber,
                'pen_nofaks' => $faker->phoneNumber,
                'pen_nohp' => $faker->phoneNumber,
                'pen_kjnama' => $faker->name,
                'pen_kjgelaran' => $faker->randomElement(['Setiausaha Bahagian (SUB)', 'Timbalan Setiausaha Bahagian']),
                'pen_kjemel' => $faker->email,
                'pen_ppnama' => $faker->name,
                'pen_ppemel' => $faker->email,
            ]);
        }
    }
}
