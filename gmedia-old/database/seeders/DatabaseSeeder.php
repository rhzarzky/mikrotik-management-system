<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tambahkan data pengguna
        User::create([
            'email' => 'admin@gmail.com',
            'name' => 'Administrator',
            'password' => Hash::make('admin'),
            'role' => 'admin', // Sesuaikan dengan role yang sesuai
        ]);
    }
}
