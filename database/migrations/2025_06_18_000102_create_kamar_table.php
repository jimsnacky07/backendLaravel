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
            $table->text('fasilitas')->nullable(); // Changed to text for longer descriptions
            $table->double('tarif')->nullable();
            $table->integer('max_penghuni')->default(2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
