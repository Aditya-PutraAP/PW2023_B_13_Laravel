<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rekening;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Rekening::create([
            'nama' => 'Admin',
            'nik' => '1122334455',
            'alamat' => 'Yogyakarta',
            'tempat_lahir' => 'Yogyakarta',
            'tgl_lahir' => '16-12-2023',
            'jenis_kelamin' => 'Laki-laki',
            'no_rek' => '202312161',
            'saldo' => '500000000',
            'jenis_kartu' => 'Gold',
        ]);

        User::create([
            'id_rekening' => 1,
            'username' => 'Admin',
            'password' => 'Admin',
            'email' => 'Admin@gmail.com',
            'no_telp' => '08123456789',
            'verify_key' => 'abc123',
            'email_verified_at' => now(),
            'active' => 1,
        ]);
    }
}
