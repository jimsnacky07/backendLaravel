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
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('password');
        });
        Schema::table('admin', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('password');
        });
        Schema::table('penghuni', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('user_id');
        });
        Schema::table('kamar', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('max_penghuni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
        Schema::table('admin', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
        Schema::table('penghuni', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
        Schema::table('kamar', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
