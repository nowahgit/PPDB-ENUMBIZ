<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seleksis', function (Blueprint $table) {
            $table->id('id_seleksi');

            // ── FK: Panitia yang menginput (admins.id_panitia) ───────
            // Must use manual FK — foreignId() assumes column = id
            $table->unsignedBigInteger('id_panitia')->notNull();
            $table->foreign('id_panitia')
                  ->references('id_panitia')
                  ->on('admins')
                  ->onDelete('restrict');

            // ── FK: Pendaftar (users.id) ─────────────────────────────
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('nama_seleksi', 50)->notNull();

            // ── Nilai 5 Semester ─────────────────────────────────────
            // DECIMAL(5,2): max value 999.99, precision for academic scores
            $table->decimal('nilai_smt1', 5, 2)->notNull();
            $table->decimal('nilai_smt2', 5, 2)->notNull();
            $table->decimal('nilai_smt3', 5, 2)->notNull();
            $table->decimal('nilai_smt4', 5, 2)->notNull();
            $table->decimal('nilai_smt5', 5, 2)->notNull();

            $table->enum('status_seleksi', ['MENUNGGU', 'LULUS', 'TIDAK_LULUS'])
                  ->default('MENUNGGU');
            $table->dateTime('waktu_seleksi')->notNull();
            $table->boolean('is_archived')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seleksis');
    }
};