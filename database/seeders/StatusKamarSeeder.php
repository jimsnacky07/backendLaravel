<?php

namespace Database\Seeders;

use App\Models\StatusKamar;
use Illuminate\Database\Seeder;

class StatusKamarSeeder extends Seeder
{
    public function run(): void
    {
        StatusKamar::create([
            'kamar_id' => 'A101',
            'status' => 'Terisi',
            'keterangan' => 'Dihuni oleh Budi Santoso',
        ]);
        StatusKamar::create([
            'kamar_id' => 'A102',
            'status' => 'Terisi',
            'keterangan' => 'Dihuni oleh Siti Aminah',
        ]);
    }
}
