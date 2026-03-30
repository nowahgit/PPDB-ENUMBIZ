<?php
// database/migrations/xxxx_xx_xx_000004_create_selection_periods_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('selection_periods', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_buka');
            $table->dateTime('tanggal_tutup');
            $table->enum('status', ['AKTIF', 'SELESAI', 'DITUTUP'])
                  ->default('AKTIF');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('selection_periods');
    }
};