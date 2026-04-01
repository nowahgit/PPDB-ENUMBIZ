<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // What happened
            $table->string('action', 100)->notNull();
            $table->string('entity_type', 100)->notNull();
            $table->bigInteger('entity_id')->notNull();  // signed BIGINT per spec

            // Optional before/after JSON snapshots for data-change auditing
            $table->longText('before')->nullable();   // LONGTEXT per spec
            $table->longText('after')->nullable();    // LONGTEXT per spec

            $table->text('keterangan')->nullable();

            // FK → users.id — nullable: system-generated logs have no panitia
            $table->foreignId('panitia_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Single timestamp; no updated_at since logs are immutable
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};