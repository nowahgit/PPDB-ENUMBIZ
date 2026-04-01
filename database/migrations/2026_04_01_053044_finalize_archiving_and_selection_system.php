<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update Seleksis Table
        Schema::table('seleksis', function (Blueprint $table) {
            if (!Schema::hasColumn('seleksis', 'is_archived')) {
                $table->boolean('is_archived')->default(false)->after('status_seleksi');
            }
        });

        // 2. Ensure Arsip Seleksis has JSON field
        if (Schema::hasTable('arsip_seleksis')) {
            Schema::table('arsip_seleksis', function (Blueprint $table) {
                if (!Schema::hasColumn('arsip_seleksis', 'data_pendaftar')) {
                    $table->json('data_pendaftar')->nullable()->after('total_tidak_lulus');
                }
                if (!Schema::hasColumn('arsip_seleksis', 'nama_periode')) {
                    $table->string('nama_periode')->after('id_arsip');
                }
            });
        } else {
            Schema::create('arsip_seleksis', function (Blueprint $table) {
                $table->id('id_arsip');
                $table->string('nama_periode');
                $table->integer('total_pendaftar');
                $table->integer('total_lulus');
                $table->integer('total_tidak_lulus');
                $table->json('data_pendaftar');
                $table->timestamp('tanggal_arsip')->useCurrent();
            });
        }
        
        // 3. Ensure Selection Periods Table exists
        if (!Schema::hasTable('selection_periods')) {
            Schema::create('selection_periods', function (Blueprint $table) {
                $table->id('id_periode');
                $table->string('nama_periode');
                $table->text('deskripsi')->nullable();
                $table->date('tanggal_buka');
                $table->date('tanggal_tutup');
                $table->enum('status', ['AKTIF', 'TUTUP', 'ARSIP'])->default('AKTIF');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::table('seleksis', function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });
        // We don't drop arsip tables usually
    }
};
