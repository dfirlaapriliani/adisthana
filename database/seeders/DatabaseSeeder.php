<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            FacilitySeeder::class,
        ]);
        
        $this->command->info('✅ Semua seeder berhasil dijalankan!');
        $this->command->info('📧 Admin: admin@adisthana.com / password123');
        $this->command->info('🏢 8 Fasilitas contoh sudah siap!');
    }
}