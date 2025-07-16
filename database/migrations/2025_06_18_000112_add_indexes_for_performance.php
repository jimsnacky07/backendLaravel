<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add indexes to kamar table
        Schema::table('kamar', function (Blueprint $table) {
            $table->index('lantai');
            $table->index('max_penghuni');
        });

        // Add indexes to penghuni table
        Schema::table('penghuni', function (Blueprint $table) {
            $table->index('kamar');
            $table->index('registrasi');
            $table->index('nama');
        });

        // Add indexes to keuangan table
        Schema::table('keuangan', function (Blueprint $table) {
            $table->index('id_penghuni');
            $table->index('tgl_bayar');
        });

        // Add indexes to tagihan table
        Schema::table('tagihan', function (Blueprint $table) {
            $table->index('id_penghuni');
            $table->index('status');
            $table->index('tanggal');
            $table->index(['bulan', 'tahun']);
        });

        // Add indexes to status_kamar table
        Schema::table('status_kamar', function (Blueprint $table) {
            $table->index('kamar_id');
            $table->index('status');
        });

        // Add indexes to fasilitas_kamar table
        Schema::table('fasilitas_kamar', function (Blueprint $table) {
            $table->index('kamar_id');
            $table->index('status');
        });

        // Add indexes to notifikasi table
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->index('penghuni_id');
            $table->index('status');
            $table->index('tipe');
        });
    }

    public function down(): void
    {
        // Drop indexes from kamar table
        Schema::table('kamar', function (Blueprint $table) {
            $table->dropIndex(['lantai']);
            $table->dropIndex(['max_penghuni']);
        });

        // Drop indexes from penghuni table
        Schema::table('penghuni', function (Blueprint $table) {
            $table->dropIndex(['kamar']);
            $table->dropIndex(['registrasi']);
            $table->dropIndex(['nama']);
        });

        // Drop indexes from keuangan table
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropIndex(['id_penghuni']);
            $table->dropIndex(['tgl_bayar']);
        });

        // Drop indexes from tagihan table
        Schema::table('tagihan', function (Blueprint $table) {
            $table->dropIndex(['id_penghuni']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['bulan', 'tahun']);
        });

        // Drop indexes from status_kamar table
        Schema::table('status_kamar', function (Blueprint $table) {
            $table->dropIndex(['kamar_id']);
            $table->dropIndex(['status']);
        });

        // Drop indexes from fasilitas_kamar table
        Schema::table('fasilitas_kamar', function (Blueprint $table) {
            $table->dropIndex(['kamar_id']);
            $table->dropIndex(['status']);
        });

        // Drop indexes from notifikasi table
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropIndex(['penghuni_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tipe']);
        });
    }
};
