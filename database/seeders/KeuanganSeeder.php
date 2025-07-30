<?php

namespace Database\Seeders;

use App\Models\Keuangan;
use Illuminate\Database\Seeder;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        Keuangan::create([
            
            'id_penghuni' => 'PH001',
            'tgl_bayar' => '2024-06-05',
            'bayar' => 800000,
            'keterangan' => 'Pembayaran bulan Juni',
        ]);
        Keuangan::create([
            'id_penghuni' => 'PH002',
            'tgl_bayar' => '2024-06-06',
            'bayar' => 800000,
            'keterangan' => 'Pembayaran bulan Juni',
        ]);
    }
}
