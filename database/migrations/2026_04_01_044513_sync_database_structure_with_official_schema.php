<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Data Pendaftar (Sesuai Skema Anda)
            $table->string('nisn_pendaftar', 20)->nullable()->after('no_hp');
            $table->string('nama_pendaftar', 50)->nullable()->after('nisn_pendaftar');
            $table->date('tanggallahir_pendaftar')->nullable()->after('nama_pendaftar');
            $table->text('alamat_pendaftar')->nullable()->after('tanggallahir_pendaftar');
            $table->string('agama', 20)->nullable()->after('alamat_pendaftar');
            $table->text('prestasi')->nullable()->after('agama');

            // Data Orang Tua (Sesuai Skema Anda)
            $table->string('nama_ortu', 50)->nullable()->after('prestasi');
            $table->string('pekerjaan_ortu', 50)->nullable()->after('nama_ortu');
            $table->string('no_hp_ortu', 15)->nullable()->after('pekerjaan_ortu');
            $table->text('alamat_ortu')->nullable()->after('no_hp_ortu');

            // Data Nilai (Sesuai Skema Anda - FLOAT)
            $table->float('nilai_smt1')->nullable()->after('alamat_ortu');
            $table->float('nilai_smt2')->nullable()->after('nilai_smt1');
            $table->float('nilai_smt3')->nullable()->after('nilai_smt2');
            $table->float('nilai_smt4')->nullable()->after('nilai_smt3');
            $table->float('nilai_smt5')->nullable()->after('nilai_smt4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nisn_pendaftar', 'nama_pendaftar', 'tanggallahir_pendaftar', 'alamat_pendaftar', 'agama', 'prestasi',
                'nama_ortu', 'pekerjaan_ortu', 'no_hp_ortu', 'alamat_ortu',
                'nilai_smt1', 'nilai_smt2', 'nilai_smt3', 'nilai_smt4', 'nilai_smt5'
            ]);
        });
    }
};
