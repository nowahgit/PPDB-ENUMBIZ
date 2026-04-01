<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('selection_periods', function (Blueprint $table) {
            if (Schema::hasColumn('selection_periods', 'id') && !Schema::hasColumn('selection_periods', 'id_periode')) {
                $table->renameColumn('id', 'id_periode');
            }
            if (Schema::hasColumn('selection_periods', 'nama') && !Schema::hasColumn('selection_periods', 'nama_periode')) {
                $table->renameColumn('nama', 'nama_periode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('selection_periods', function (Blueprint $table) {
            $table->renameColumn('id_periode', 'id');
            $table->renameColumn('nama_periode', 'nama');
        });
    }
};
