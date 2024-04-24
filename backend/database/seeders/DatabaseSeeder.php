<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'address' => '192.168.1.14',
            'email' => 'rheza@admin.com',
            'username' => 'apimikrotik',
            'password' => Hash::make('user'),
            'level' => 'admin', // Sesuaikan dengan level yang sesuai
        ]);
    }
}
