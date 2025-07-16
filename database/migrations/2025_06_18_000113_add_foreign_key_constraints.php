<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add foreign key constraint for penghuni.kamar -> kamar.id
        Schema::table('penghuni', function (Blueprint $table) {
            $table->foreign('kamar')->references('id')->on('kamar')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
        });

        // Add foreign key constraint for keuangan.id_penghuni -> penghuni.id
        Schema::table('keuangan', function (Blueprint $table) {
            $table->foreign('id_penghuni')->references('id')->on('penghuni')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });

        // Add foreign key constraint for tagihan.id_penghuni -> penghuni.id
        Schema::table('tagihan', function (Blueprint $table) {
            $table->foreign('id_penghuni')->references('id')->on('penghuni')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });

        // Add foreign key constraint for status_kamar.kamar_id -> kamar.id
        Schema::table('status_kamar', function (Blueprint $table) {
            $table->foreign('kamar_id')->references('id')->on('kamar')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });

        // Add foreign key constraint for fasilitas_kamar.kamar_id -> kamar.id
        Schema::table('fasilitas_kamar', function (Blueprint $table) {
            $table->foreign('kamar_id')->references('id')->on('kamar')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });

        // Add foreign key constraint for notifikasi.penghuni_id -> penghuni.id
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->foreign('penghuni_id')->references('id')->on('penghuni')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    public function down(): void
    {
        // Drop foreign key constraints
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropForeign(['penghuni_id']);
        });

        Schema::table('fasilitas_kamar', function (Blueprint $table) {
            $table->dropForeign(['kamar_id']);
        });

        Schema::table('status_kamar', function (Blueprint $table) {
            $table->dropForeign(['kamar_id']);
        });

        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropForeign(['id_penghuni']);
        });

        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropForeign(['id_penghuni']);
        });

        Schema::table('penghuni', function (Blueprint $table) {
            $table->dropForeign(['kamar']);
        });
    }
};
