<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Laboratorium IPA',
                'type' => 'Laboratorium',
                'location' => 'Gedung A Lantai 2, Ruang 201',
                'capacity' => 40,
                'description' => 'Laboratorium IPA lengkap dengan mikroskop, tabung reaksi, dan peralatan praktikum Biologi, Fisika, dan Kimia.',
                'status' => 'available',
            ],
            [
                'name' => 'Laboratorium Komputer',
                'type' => 'Laboratorium',
                'location' => 'Gedung B Lantai 1, Ruang 101',
                'capacity' => 36,
                'description' => 'Laboratorium komputer dengan 36 unit PC terbaru, AC, proyektor, dan koneksi internet fiber optic.',
                'status' => 'available',
            ],
            [
                'name' => 'Aula Serbaguna',
                'type' => 'Aula',
                'location' => 'Gedung Serbaguna',
                'capacity' => 300,
                'description' => 'Aula serbaguna dengan panggung, sound system, AC, dan kapasitas 300 orang. Cocok untuk seminar, wisuda, atau acara besar.',
                'status' => 'available',
            ],
            [
                'name' => 'Perpustakaan',
                'type' => 'Perpustakaan',
                'location' => 'Gedung C Lantai 1',
                'capacity' => 60,
                'description' => 'Perpustakaan dengan koleksi 5000+ buku, ruang baca, area diskusi, dan akses internet gratis.',
                'status' => 'available',
            ],
            [
                'name' => 'Lapangan Basket',
                'type' => 'Lapangan Olahraga',
                'location' => 'Area Belakang Sekolah',
                'capacity' => 50,
                'description' => 'Lapangan basket outdoor dengan lantai beton, ring standar, dan pencahayaan untuk malam hari.',
                'status' => 'available',
            ],
            [
                'name' => 'Ruang Multimedia',
                'type' => 'Ruang Kelas',
                'location' => 'Gedung B Lantai 2, Ruang 205',
                'capacity' => 40,
                'description' => 'Ruang multimedia dengan smart TV 75 inch, sound system, AC, dan kursi ergonomis.',
                'status' => 'available',
            ],
            [
                'name' => 'Studio Musik',
                'type' => 'Studio',
                'location' => 'Gedung Kesenian Lantai 1',
                'capacity' => 15,
                'description' => 'Studio musik kedap suara dengan drum, gitar, keyboard, dan peralatan band lengkap.',
                'status' => 'available',
            ],
            [
                'name' => 'Ruang Rapat',
                'type' => 'Ruang Meeting',
                'location' => 'Gedung Utama Lantai 1',
                'capacity' => 20,
                'description' => 'Ruang rapat dengan meja meeting, kursi eksekutif, AC, dan smart TV untuk presentasi.',
                'status' => 'available',
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::firstOrCreate(
                ['name' => $facility['name']],
                $facility
            );
        }

        $this->command->info('✅ ' . count($facilities) . ' fasilitas berhasil dibuat!');
        $this->command->info('🏢 Fasilitas yang tersedia:');
        foreach ($facilities as $facility) {
            $this->command->info('   • ' . $facility['name'] . ' (' . $facility['type'] . ')');
        }
    }
}