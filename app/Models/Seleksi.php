<?php
// app/Models/Seleksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seleksi extends Model
{
    protected $table      = 'seleksis';
    protected $primaryKey = 'id_seleksi';

    protected $fillable = [
        'id_panitia',
        'user_id',
        'nama_seleksi',
        'nilai_smt1',
        'nilai_smt2',
        'nilai_smt3',
        'nilai_smt4',
        'nilai_smt5',
        'status_seleksi',
        'waktu_seleksi',
        'is_archived',
    ];

    protected function casts(): array
    {
        return [
            'nilai_smt1'     => 'float',
            'nilai_smt2'     => 'float',
            'nilai_smt3'     => 'float',
            'nilai_smt4'     => 'float',
            'nilai_smt5'     => 'float',
            'waktu_seleksi'  => 'datetime',
            'is_archived'    => 'boolean',
            'status_seleksi' => 'string',
        ];
    }

    // ─── Relasi ───────────────────────────────────────────

    /** Seleksi dilakukan terhadap satu pendaftar (user) */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /** Seleksi diinput oleh satu panitia */
    public function panitia(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_panitia', 'id_panitia');
    }

    // ─── Helper / Computed ────────────────────────────────

    /** Rata-rata nilai dari 5 semester */
    public function getRataRataNilaiAttribute(): float
    {
        return ($this->nilai_smt1 + $this->nilai_smt2 + $this->nilai_smt3
              + $this->nilai_smt4 + $this->nilai_smt5) / 5;
    }
}