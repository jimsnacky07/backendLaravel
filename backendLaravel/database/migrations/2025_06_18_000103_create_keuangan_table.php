<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->char('id', 10)->primary();
            $table->char('id_penghuni', 10)->nullable();
            $table->date('tgl_bayar')->nullable();
            $table->double('bayar')->nullable();
            $table->string('keterangan', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
