<?php
// database/migrations/xxxx_xx_xx_000003_create_berkas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id('id_berkas');
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // Data Pendaftar
            $table->string('nisn_pendaftar', 20);
            $table->string('nama_pendaftar', 100);
            $table->date('tanggallahir_pendaftar');
            $table->text('alamat_pendaftar');
            $table->string('agama', 20);
            $table->text('prestasi')->nullable();

            // Data Orang Tua / Wali
            $table->string('nama_ortu', 50);
            $table->string('pekerjaan_ortu', 50)->nullable();
            $table->string('no_hp_ortu', 15);
            $table->text('alamat_ortu');

            // Berkas Dokumen
            $table->string('jenis_berkas', 50);
            $table->string('file_path', 255);

            // Status & Validasi
            $table->enum('status_validasi', ['MENUNGGU', 'VALID', 'DITOLAK'])
                  ->default('MENUNGGU');
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_validasi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};