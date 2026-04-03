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
        Schema::create('arsip_pendaftars', function (Blueprint $table) {
            $table->id('id_arsip_pendaftar');
            $table->foreignId('arsip_seleksi_id')->constrained('arsip_seleksis', 'id_arsip')->onDelete('cascade');
            $table->string('nomor_pendaftaran', 20);
            $table->string('nama', 100);
            $table->string('nisn', 20);
            $table->float('rata_rata_nilai');
            $table->string('status_seleksi', 20);
            $table->timestamps();
        });
        
        // Hapus kolom JSON yang statis dari tabel induk agar tidak redundan
        Schema::table('arsip_seleksis', function (Blueprint $table) {
            if (Schema::hasColumn('arsip_seleksis', 'data_pendaftar')) {
                $table->dropColumn('data_pendaftar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip_seleksis', function (Blueprint $table) {
            $table->json('data_pendaftar')->nullable()->after('total_tidak_lulus');
        });
        Schema::dropIfExists('arsip_pendaftars');
    }
};
