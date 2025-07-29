<?php

namespace Database\Seeders;

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
    public function run(): void
    {
        User::create([
            'name' => 'Muhammad Aiman Yusuf',
            'email' => 'admin@mail.com',
            'password' => Hash::make('asd123'),
            'role' => '1',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
