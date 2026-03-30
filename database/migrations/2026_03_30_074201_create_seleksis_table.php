<?php
// database/migrations/xxxx_xx_xx_000006_create_seleksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seleksis', function (Blueprint $table) {
            $table->id('id_seleksi');

            // Relasi ke panitia yang menginput
            $table->unsignedBigInteger('id_panitia');
            $table->foreign('id_panitia')
                  ->references('id_panitia')
                  ->on('admins')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Relasi ke akun pendaftar
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->string('nama_seleksi', 50);

            // Nilai rapor per semester
            $table->float('nilai_smt1', 5, 2)->default(0);
            $table->float('nilai_smt2', 5, 2)->default(0);
            $table->float('nilai_smt3', 5, 2)->default(0);
            $table->float('nilai_smt4', 5, 2)->default(0);
            $table->float('nilai_smt5', 5, 2)->default(0);

            $table->enum('status_seleksi', ['MENUNGGU', 'LULUS', 'TIDAK_LULUS'])
                  ->default('MENUNGGU');
            $table->dateTime('waktu_seleksi');
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seleksis');
    }
};