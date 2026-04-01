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
        Schema::table('berkas', function (Blueprint $blueprint) {
            // Menghapus kolom file_path lama jika ada (dan tidak digunakan lagi)
            // Kami biarkan untuk berjaga-jaga, tapi kami tambah file spesifik
            $blueprint->string('file_kk', 255)->nullable()->after('jenis_berkas');
            $blueprint->string('file_akte', 255)->nullable()->after('file_kk');
            $blueprint->string('file_skl', 255)->nullable()->after('file_akte');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['file_kk', 'file_akte', 'file_skl']);
        });
    }
};
