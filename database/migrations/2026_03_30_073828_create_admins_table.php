<?php
// database/migrations/xxxx_xx_xx_000002_create_admins_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('id_panitia');
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('nama_panitia', 50);
            $table->string('no_hp', 15)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};