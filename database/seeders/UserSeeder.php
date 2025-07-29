<?php

namespace Database\Seeders;

use App\Models\EproPengguna;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the User record
        User::create([
            'name' => 'MUHAMMAD AIMAN YUSUF',
            'email' => 'yusuf.noor@motac.gov.my',
            'password' => Hash::make('asd123'),
            'role' => 2,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Create the EproPengguna record
        EproPengguna::create([
            'pen_id' => 1,
            'pen_idusers' => 1,
            'pen_nama' => 'MUHAMMAD AIMAN YUSUF',
            'pen_nokp' => '010710050109',
            'pen_jantina' => 1,
            'pen_emel' => 'admin@motac.gov.my',
            'pen_notel' => '7677',
            'pen_nohp' => '01117175349',
            'pen_idbahagian' => 16,
            'pen_bahagianlain' => null,
            'pen_jawatan' => 'MySTEP',
            'pen_gred' => 'FT1',
            'pen_idkumpulan' => 5,
            'pen_idjabatan' => 1,
            'pen_ppnama' => 'MUHAMMAD AIMAN YUSUF',
            'pen_ppemel' => 'yusuf.noor@motac.gov.my',
            'pen_ppgred' => '9',
            'created_at' => Carbon::parse('2025-07-28 21:52:57'),
            'updated_at' => Carbon::parse('2025-07-28 21:52:57'),
        ]);
    }
}
