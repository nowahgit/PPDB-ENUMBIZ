<?php
// database/migrations/xxxx_xx_xx_000007_create_audit_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action', 100);
            $table->string('entity_type', 100);
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->text('before')->nullable();  // snapshot JSON sebelum perubahan
            $table->text('after')->nullable();   // snapshot JSON sesudah perubahan
            $table->text('keterangan')->nullable();

            // Panitia yang melakukan aksi (nullable: bisa aksi sistem)
            $table->foreignId('panitia_id')
                  ->nullable()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};