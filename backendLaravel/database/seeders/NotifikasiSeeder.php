<?php

namespace Database\Seeders;

use App\Models\Notifikasi;
use Illuminate\Database\Seeder;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        Notifikasi::create([
            'penghuni_id' => 'PH001',
            'judul' => 'Tagihan Bulanan',
            'pesan' => 'Tagihan bulan Juni sudah dibayar. Terima kasih.',
            'tipe' => 'Tagihan',
            'status' => 'Sudah Dibaca',
            'dibaca_pada' => now(),
        ]);
        Notifikasi::create([
            'penghuni_id' => 'PH002',
            'judul' => 'Informasi Maintenance',
            'pesan' => 'Akan ada maintenance listrik pada 10 Juni 2024.',
            'tipe' => 'Maintenance',
            'status' => 'Belum Dibaca',
            'dibaca_pada' => null,
        ]);
    }
}
