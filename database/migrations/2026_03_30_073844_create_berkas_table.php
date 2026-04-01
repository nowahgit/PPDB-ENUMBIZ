<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            // Primary Key
            $table->id('id_berkas');

            // FK → users.id — one berkas per user
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onDelete('cascade');

            // ── Data Pendaftar ────────────────────────────────────────
            $table->string('nisn_pendaftar', 20)->notNull()->index();
            $table->string('nama_pendaftar', 50)->notNull()->index();
            $table->date('tanggallahir_pendaftar')->notNull();
            $table->text('alamat_pendaftar')->notNull();
            $table->string('agama', 20)->notNull();
            // prestasi: NOT NULL, stored as VARCHAR to allow a default value.
            // MySQL does not permit DEFAULT on TEXT/BLOB columns.
            $table->string('prestasi', 1000)->default('');

            // ── Data Orang Tua / Wali ─────────────────────────────────
            $table->string('nama_ortu', 50)->notNull();
            $table->string('pekerjaan_ortu', 50)->notNull();
            $table->string('no_hp_ortu', 15)->notNull();
            $table->text('alamat_ortu')->notNull();

            // ── Berkas Dokumen ────────────────────────────────────────
            $table->string('jenis_berkas', 50)->notNull();
            // Default empty — filled after file upload
            $table->string('file_path', 255)->default('');

            // ── Validasi & Status ─────────────────────────────────────
            $table->enum('status_validasi', ['MENUNGGU', 'VALID', 'DITOLAK'])
                  ->default('MENUNGGU')
                  ->index();
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_validasi')->nullable();

            // No timestamps — avoid ambiguity with tanggal_validasi
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};