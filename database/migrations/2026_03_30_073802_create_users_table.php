<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Credentials
            $table->string('username', 20)->unique()->notNull();
            $table->string('password', 255)->notNull();

            // Role
            $table->enum('role', ['PENDAFTAR', 'PANITIA'])->default('PENDAFTAR');

            // Pendaftar-specific fields
            $table->string('nomor_pendaftaran', 20)->unique()->nullable();
            $table->string('asal_sekolah', 100)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('no_hp', 15)->nullable();

            // Password Reset
            $table->string('reset_token', 255)->nullable();
            $table->timestamp('reset_token_expiry')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};