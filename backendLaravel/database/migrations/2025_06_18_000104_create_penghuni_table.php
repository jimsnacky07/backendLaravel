<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghuni', function (Blueprint $table) {
            $table->char('id', 30)->primary();
            $table->string('nama', 30)->nullable();
            $table->string('alamat', 30)->nullable();
            $table->char('nohp', 12)->nullable();
            $table->date('registrasi')->nullable();
            $table->char('kamar', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};
