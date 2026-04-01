<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
            'waktu_seleksi' => 'datetime',
            'is_archived'   => 'boolean',
            'nilai_smt1'    => 'float',
            'nilai_smt2'    => 'float',
            'nilai_smt3'    => 'float',
            'nilai_smt4'    => 'float',
            'nilai_smt5'    => 'float',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /** The pendaftar this seleksi record belongs to */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** The panitia who entered this seleksi record */
    public function panitia(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_panitia', 'id_panitia');
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Average academic score across all 5 semesters, rounded to 2 decimal places.
     * Usage: $seleksi->rata_rata
     */
    protected function rataRata(): Attribute
    {
        return Attribute::make(
            get: fn () => round(
                ($this->nilai_smt1 + $this->nilai_smt2 + $this->nilai_smt3
                    + $this->nilai_smt4 + $this->nilai_smt5) / 5,
                2
            )
        );
    }
}