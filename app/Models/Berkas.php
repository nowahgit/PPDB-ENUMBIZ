<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table      = 'berkas';
    protected $primaryKey = 'id_berkas';

    /** berkas table has no timestamps columns */
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nisn_pendaftar',
        'nama_pendaftar',
        'tanggallahir_pendaftar',
        'alamat_pendaftar',
        'agama',
        'prestasi',
        'nama_ortu',
        'pekerjaan_ortu',
        'no_hp_ortu',
        'alamat_ortu',
        'jenis_berkas',
        'file_path',
        'file_kk',
        'file_akte',
        'file_skl',
        'prestasi_1',
        'prestasi_1_file',
        'prestasi_2',
        'prestasi_2_file',
        'prestasi_3',
        'prestasi_3_file',
        'status_validasi',
        'catatan',
        'tanggal_validasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggallahir_pendaftar' => 'date',
            'tanggal_validasi'       => 'datetime',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /** The pendaftar (user) who owns these documents */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ─── Query Scopes ─────────────────────────────────────────────────────────

    /** Only berkas awaiting review */
    public function scopeMenunggu(Builder $query): Builder
    {
        return $query->where('status_validasi', 'MENUNGGU');
    }

    /** Only validated/approved berkas */
    public function scopeValid(Builder $query): Builder
    {
        return $query->where('status_validasi', 'VALID');
    }

    /** Only rejected berkas */
    public function scopeDitolak(Builder $query): Builder
    {
        return $query->where('status_validasi', 'DITOLAK');
    }
}