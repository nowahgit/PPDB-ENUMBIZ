<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipPendaftar extends Model
{
    protected $table = 'arsip_pendaftars';
    protected $primaryKey = 'id_arsip_pendaftar';

    protected $fillable = [
        'arsip_seleksi_id',
        'nomor_pendaftaran',
        'nama',
        'nisn',
        'rata_rata_nilai',
        'status_seleksi',
    ];

    public function arsipInduk()
    {
        return $this->belongsTo(ArsipSeleksi::class, 'arsip_seleksi_id', 'id');
    }
}
