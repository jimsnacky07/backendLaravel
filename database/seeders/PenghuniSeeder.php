<?php

namespace Database\Seeders;

use App\Models\Penghuni;
use Illuminate\Database\Seeder;

class PenghuniSeeder extends Seeder
{
    public function run(): void
    {
        Penghuni::create([
            'id' => 'PH001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Melati No. 10, Bandung',
            'nohp' => '081234567890',
            'registrasi' => '2024-06-01',
            'kamar' => 'A101',
        ]);
        Penghuni::create([
            'id' => 'PH002',
            'nama' => 'Siti Aminah',
            'alamat' => 'Jl. Kenanga No. 5, Bandung',
            'nohp' => '081298765432',
            'registrasi' => '2024-06-02',
            'kamar' => 'A102',
        ]);
    }
}
