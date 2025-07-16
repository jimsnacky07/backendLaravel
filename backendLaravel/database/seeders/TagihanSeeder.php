<?php

namespace Database\Seeders;

use App\Models\Tagihan;
use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        Tagihan::create([
            'id_penghuni' => 'PH001',
            'bulan' => 'Juni',
            'tahun' => '2024',
            'tagihan' => 800000,
            'status' => 'Lunas',
            'tanggal' => '2024-06-01',
        ]);
        Tagihan::create([
            'id_penghuni' => 'PH002',
            'bulan' => 'Juni',
            'tahun' => '2024',
            'tagihan' => 800000,
            'status' => 'Lunas',
            'tanggal' => '2024-06-02',
        ]);
    }
}
