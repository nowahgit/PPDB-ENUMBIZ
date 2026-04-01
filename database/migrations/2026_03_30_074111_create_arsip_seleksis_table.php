<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip_seleksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_periode', 100)->notNull();
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_buka')->notNull();
            $table->dateTime('tanggal_tutup')->notNull();

            // Aggregate counters — INT (not unsigned int) per spec
            $table->integer('total_pendaftar')->notNull()->default(0);
            $table->integer('total_lulus')->notNull()->default(0);
            $table->integer('total_tidak_lulus')->notNull()->default(0);

            // Frozen JSON snapshot of all applicant data at archive time
            $table->json('data_pendaftar')->notNull();

            // Auto-set to NOW() on insert; no updated_at needed
            $table->timestamp('tanggal_arsip')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_seleksis');
    }
};