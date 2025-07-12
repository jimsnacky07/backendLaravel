<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_kamar', function (Blueprint $table) {
            $table->id();
            $table->char('kamar_id', 30);
            $table->enum('status', ['Tersedia', 'Terisi', 'Maintenance', 'Reserved']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_kamar');
    }
};
