<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'adminlevel' => 1,
        ]);

        Admin::create([
            'username' => 'superadmin',
            'password' => Hash::make('superadmin123'),
            'adminlevel' => 2,
        ]);
    }
}
