<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->char('id', 30)->primary();
            $table->integer('lantai')->nullable();
            $table->string('kapasitas', 30)->nullable();
            $table->string('fasilitas', 30)->nullable();
            $table->double('tarif')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
