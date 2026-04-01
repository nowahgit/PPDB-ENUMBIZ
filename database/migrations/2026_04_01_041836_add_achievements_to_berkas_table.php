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
        Schema::table('berkas', function (Blueprint $table) {
            // Kita gunakan kolom terpisah untuk mempermudah pendaftaran 3 prestasi mandiri
            $table->string('prestasi_1', 255)->nullable()->after('file_skl');
            $table->string('prestasi_1_file', 255)->nullable()->after('prestasi_1');
            
            $table->string('prestasi_2', 255)->nullable()->after('prestasi_1_file');
            $table->string('prestasi_2_file', 255)->nullable()->after('prestasi_2');
            
            $table->string('prestasi_3', 255)->nullable()->after('prestasi_2_file');
            $table->string('prestasi_3_file', 255)->nullable()->after('prestasi_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropColumn([
                'prestasi_1', 'prestasi_1_file', 
                'prestasi_2', 'prestasi_2_file', 
                'prestasi_3', 'prestasi_3_file'
            ]);
        });
    }
};
