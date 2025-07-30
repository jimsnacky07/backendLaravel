<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('keterangan');
            $table->unsignedInteger('tagihan_id')->nullable()->after('id_penghuni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropColumn(['foto', 'tagihan_id']);
        });
    }
}; 