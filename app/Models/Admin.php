<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table      = 'admins';
    protected $primaryKey = 'id_panitia';

    /** admins table has no timestamps columns */
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama_panitia',
        'no_hp',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    /** The user account this admin profile belongs to */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** All seleksi records entered by this admin */
    public function seleksis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Seleksi::class, 'id_panitia', 'id_panitia');
    }
}