<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->char('id', 20)->primary();
            $table->string('username', 30)->nullable();
            $table->string('password', 30)->nullable();
            $table->integer('adminlevel')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
