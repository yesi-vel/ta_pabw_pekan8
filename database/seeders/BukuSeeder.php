<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Buku\Models\Buku; // Sesuaikan dengan namespace model buku kamu

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Buku::insert([
            [
                'judul' => 'Pemrograman Web Laravel',
                'penulis' => 'Budi Santoso',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2023,
                'stok' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Belajar Flutter & Dart',
                'penulis' => 'Siti Aminah',
                'penerbit' => 'Media Kita',
                'tahun_terbit' => 2024,
                'stok' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}