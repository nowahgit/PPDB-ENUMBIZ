<?php
// app/Models/Berkas.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    protected $table      = 'berkas';
    protected $primaryKey = 'id_berkas';

    // Tabel berkas tidak punya timestamps (sesuai migration)
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
        'status_validasi',
        'catatan',
        'tanggal_validasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggallahir_pendaftar' => 'date',
            'tanggal_validasi'       => 'datetime',
            'status_validasi'        => 'string',
        ];
    }

    // ─── Relasi ───────────────────────────────────────────

    /** Berkas dimiliki oleh satu user (pendaftar) */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}