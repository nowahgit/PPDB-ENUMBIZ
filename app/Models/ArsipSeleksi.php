<?php
// app/Models/ArsipSeleksi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipSeleksi extends Model
{
    protected $table = 'arsip_seleksis';

    // Hanya punya created_at (tanggal_arsip), tidak ada updated_at
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
            // Otomatis decode/encode JSON saat akses $arsip->data_pendaftar
            'data_pendaftar' => 'array',
            'tanggal_buka'   => 'datetime',
            'tanggal_tutup'  => 'datetime',
            'tanggal_arsip'  => 'datetime',
        ];
    }
}