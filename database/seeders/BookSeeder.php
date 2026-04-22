<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Matematika Kelas 12',
                'pengarang' => 'Sudirman',
                'tahun_terbit' => 2023,
                'penerbit' => 'Erlangga',
                'stok' => 5,
                'deskripsi' => 'Buku matematika untuk kelas 12 SMA',
                'status' => 'available',
            ],
            [
                'judul' => 'Fisika Dasar',
                'pengarang' => 'Halliday',
                'tahun_terbit' => 2022,
                'penerbit' => 'Gramedia',
                'stok' => 3,
                'deskripsi' => 'Buku fisika dasar untuk SMA',
                'status' => 'available',
            ],
            [
                'judul' => 'Biologi Modern',
                'pengarang' => 'Campbell',
                'tahun_terbit' => 2021,
                'penerbit' => 'Erlangga',
                'stok' => 2,
                'deskripsi' => 'Buku biologi lengkap',
                'status' => 'available',
            ],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(
                ['judul' => $book['judul']],
                $book
            );
        }

        $this->command->info('✅ 3 Buku contoh berhasil dibuat!');
    }
}