<?php

namespace Database\Seeders;
use App\Enums\UserRole;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(BukuSeeder::class);
        // Buat Akun Admin
        // Buat Akun Admin
User::factory()->create([
    'name' => 'Administrator',
    'email' => 'admin@sipustaka.com',
    'role' => 'admin', // Ubah jadi string
    'password' => bcrypt('password'),
]);

// Buat Akun Anggota (User)
User::factory()->create([
    'name' => 'Anggota Biasa',
    'email' => 'user@sipustaka.com',
    'role' => 'user', // Ubah jadi string
    'password' => bcrypt('password'),
]);
    }
}