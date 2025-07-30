<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30)->nullable();
            $table->string('password', 255)->nullable(); // Increased for hashed passwords
            $table->integer('adminlevel')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
