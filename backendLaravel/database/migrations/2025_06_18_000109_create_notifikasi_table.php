<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->char('penghuni_id', 30)->nullable();
            $table->string('judul', 200);
            $table->text('pesan');
            $table->enum('tipe', ['Tagihan', 'Pembayaran', 'Maintenance', 'Umum']);
            $table->enum('status', ['Belum Dibaca', 'Sudah Dibaca']);
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
