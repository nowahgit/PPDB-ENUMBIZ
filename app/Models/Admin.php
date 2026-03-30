<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table      = 'admins';
    protected $primaryKey = 'id_panitia';

    // Tabel admins tidak punya timestamps (sesuai migration)
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama_panitia',
        'no_hp',
    ];

    // ─── Relasi ───────────────────────────────────────────

    /** Admin berasal dari satu user */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /** Satu panitia bisa menginput banyak record seleksi */
    public function seleksis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Seleksi::class, 'id_panitia', 'id_panitia');
    }
}