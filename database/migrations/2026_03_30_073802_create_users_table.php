<?php
// database/migrations/xxxx_xx_xx_000001_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 20)->unique();
            $table->string('password');
            $table->enum('role', ['PENDAFTAR', 'PANITIA'])->default('PENDAFTAR');
            $table->string('nomor_pendaftaran')->nullable()->unique();
            $table->string('asal_sekolah')->nullable();
            $table->string('email')->unique();
            $table->string('jenis_kelamin', 20)->nullable();
            $table->string('reset_token')->nullable();
            $table->dateTime('reset_token_expiry')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};