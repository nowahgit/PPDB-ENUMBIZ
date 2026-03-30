<?php
// database/migrations/xxxx_xx_xx_000005_create_arsip_seleksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip_seleksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode', 100);
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_buka');
            $table->dateTime('tanggal_tutup');
            $table->unsignedInteger('total_pendaftar')->default(0);
            $table->unsignedInteger('total_lulus')->default(0);
            $table->unsignedInteger('total_tidak_lulus')->default(0);
            // Menyimpan snapshot data pendaftar dalam format JSON
            $table->json('data_pendaftar');
            $table->timestamp('tanggal_arsip')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_seleksis');
    }
};