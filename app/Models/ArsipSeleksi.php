<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipSeleksi extends Model
{
    protected $table = 'arsip_seleksis';
    protected $primaryKey = 'id_arsip';

    /**
     * arsip_seleksis has only tanggal_arsip (no standard updated_at).
     * Disable Laravel's automatic timestamp management.
     */
    public $timestamps = false;

    protected $fillable = [
        'nama_periode',
        'total_pendaftar',
        'total_lulus',
        'total_tidak_lulus',
        'data_pendaftar',
        'tanggal_arsip',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_arsip'   => 'datetime',
            // JSON column automatically decoded to / encoded from PHP array
            'data_pendaftar'  => 'array',
        ];
    }
}