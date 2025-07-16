<?php

namespace Database\Seeders;

use App\Models\Kamar;
use App\Models\StatusKamar;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        // Lantai 1
        $kamar1 = Kamar::create([
            'id' => 'A101',
            'lantai' => 1,
            'kapasitas' => '2 Orang',
            'fasilitas' => 'AC, Kamar Mandi Dalam',
            'tarif' => 800000,
            'max_penghuni' => 2,
        ]);

        StatusKamar::create([
            'kamar_id' => $kamar1->id,
            'status' => 'Tersedia',
            'keterangan' => 'Kamar baru siap huni'
        ]);

        $kamar2 = Kamar::create([
            'id' => 'A102',
            'lantai' => 1,
            'kapasitas' => '2 Orang',
            'fasilitas' => 'AC, Kamar Mandi Dalam',
            'tarif' => 800000,
            'max_penghuni' => 2,
        ]);

        StatusKamar::create([
            'kamar_id' => $kamar2->id,
            'status' => 'Tersedia',
            'keterangan' => 'Kamar baru siap huni'
        ]);

        // Lantai 2
        $kamar3 = Kamar::create([
            'id' => 'A201',
            'lantai' => 2,
            'kapasitas' => '2 Orang',
            'fasilitas' => 'AC, Kamar Mandi Dalam, Balkon',
            'tarif' => 900000,
            'max_penghuni' => 2,
        ]);

        StatusKamar::create([
            'kamar_id' => $kamar3->id,
            'status' => 'Tersedia',
            'keterangan' => 'Kamar premium dengan balkon'
        ]);

        $kamar4 = Kamar::create([
            'id' => 'A202',
            'lantai' => 2,
            'kapasitas' => '2 Orang',
            'fasilitas' => 'AC, Kamar Mandi Dalam, Balkon',
            'tarif' => 900000,
            'max_penghuni' => 2,
        ]);

        StatusKamar::create([
            'kamar_id' => $kamar4->id,
            'status' => 'Tersedia',
            'keterangan' => 'Kamar premium dengan balkon'
        ]);

        // Lantai 3
        $kamar5 = Kamar::create([
            'id' => 'A301',
            'lantai' => 3,
            'kapasitas' => '2 Orang',
            'fasilitas' => 'AC, Kamar Mandi Dalam, Balkon, View Kota',
            'tarif' => 1000000,
            'max_penghuni' => 2,
        ]);

        StatusKamar::create([
            'kamar_id' => $kamar5->id,
            'status' => 'Tersedia',
            'keterangan' => 'Kamar VIP dengan view kota'
        ]);
    }
}
