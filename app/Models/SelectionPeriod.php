<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelectionPeriod extends Model
{
    protected $table = 'selection_periods';
    protected $primaryKey = 'id_periode';

    protected $fillable = [
        'nama_periode',
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
        ];
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /** Whether this period is currently accepting registrations */
    public function isAktif(): bool
    {
        return $this->status === 'AKTIF'
            && now()->between($this->tanggal_buka, $this->tanggal_tutup);
    }
}