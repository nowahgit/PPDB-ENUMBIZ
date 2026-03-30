<?php
// app/Models/SelectionPeriod.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectionPeriod extends Model
{
    protected $table = 'selection_periods';

    protected $fillable = [
        'nama',
        'deskripsi',
        'tanggal_buka',
        'tanggal_tutup',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_buka'  => 'datetime',
            'tanggal_tutup' => 'datetime',
            'status'        => 'string',
        ];
    }

    // ─── Helper Methods ───────────────────────────────────

    public function isAktif(): bool
    {
        return $this->status === 'AKTIF';
    }

    public function isSelesai(): bool
    {
        return $this->status === 'SELESAI';
    }
}