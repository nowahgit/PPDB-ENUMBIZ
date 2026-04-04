<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('selection_periods', function (Blueprint $table) {
            $table->id('id_periode');
            $table->string('nama_periode', 100);
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_buka');
            $table->dateTime('tanggal_tutup');
            $table->enum('status', ['AKTIF', 'TUTUP', 'ARSIP'])->default('AKTIF');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('selection_periods');
    }
};