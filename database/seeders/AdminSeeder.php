<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@adisthana.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'class_code' => 'ADMIN-001', // ← TAMBAHKAN INI
                'phone' => '0812-0000-0000',
                'room_location' => 'Ruang Tata Usaha',
                'office_hours' => 'Senin - Jumat, 07.00 - 15.00',
            ]
        );

        $this->command->info('✅ Admin berhasil dibuat!');
        $this->command->info('📧 Email: admin@adisthana.com');
        $this->command->info('🔑 Password: password123');
    }
}