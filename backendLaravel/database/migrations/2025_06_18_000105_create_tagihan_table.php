<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->increments('id');
            $table->char('id_penghuni', 30)->nullable();
            $table->string('bulan', 20)->nullable();
            $table->string('tahun', 4)->nullable();
            $table->decimal('tagihan', 10, 2)->nullable();
            $table->enum('status', ['Lunas', 'Belum Lunas'])->nullable();
            $table->date('tanggal')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
