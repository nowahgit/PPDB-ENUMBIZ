<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipSeleksi extends Model
{
    protected $table = 'arsip_seleksis';
    protected $primaryKey = 'id';

    /**
     * arsip_seleksis has only tanggal_arsip (no standard updated_at).
     * Disable Laravel's automatic timestamp management.
     */
    public $timestamps = false;

    protected $fillable = [
        'nama_periode',
        'deskripsi',
        'tanggal_buka',
        'tanggal_tutup',
        'total_pendaftar',
        'total_lulus',
        'total_tidak_lulus',
        'data_pendaftar',
        'tanggal_arsip',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_buka'    => 'datetime',
            'tanggal_tutup'   => 'datetime',
            'tanggal_arsip'   => 'datetime',
            'data_pendaftar'  => 'array',
        ];
    }

    public function detailPendaftar()
    {
        return $this->hasMany(ArsipPendaftar::class, 'arsip_seleksi_id', 'id');
    }
}