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
            'address' => '192.168.1.50',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'level' => 'admin', // Sesuaikan dengan level yang sesuai
        ]);
    }
}
