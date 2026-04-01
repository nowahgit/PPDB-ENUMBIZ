<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            // Primary Key
            $table->id('id_panitia');

            // FK → users.id — one admin per user account
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('nama_panitia', 50)->notNull();
            $table->string('no_hp', 15)->notNull();
            // No timestamps — admin data rarely changes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};