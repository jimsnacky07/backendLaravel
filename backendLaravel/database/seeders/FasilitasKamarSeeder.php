<?php

namespace Database\Seeders;

use App\Models\FasilitasKamar;
use Illuminate\Database\Seeder;

class FasilitasKamarSeeder extends Seeder
{
    public function run(): void
    {
        FasilitasKamar::create([
            'kamar_id' => 'A101',
            'nama_fasilitas' => 'AC',
            'deskripsi' => 'AC dingin, merek Panasonic',
            'status' => 'Aktif',
        ]);
        FasilitasKamar::create([
            'kamar_id' => 'A102',
            'nama_fasilitas' => 'Kamar Mandi Dalam',
            'deskripsi' => 'Kamar mandi dengan shower air panas',
            'status' => 'Aktif',
        ]);
    }
}
