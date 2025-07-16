<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas_kamar', function (Blueprint $table) {
            $table->id();
            $table->char('kamar_id', 30);
            $table->string('nama_fasilitas', 100);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Aktif', 'Rusak', 'Maintenance']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas_kamar');
    }
};
