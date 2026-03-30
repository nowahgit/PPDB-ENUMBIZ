<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'role',
        'nomor_pendaftaran',
        'asal_sekolah',
        'email',
        'jenis_kelamin',
        'reset_token',
        'reset_token_expiry',
        'no_hp',
    ];

    protected $hidden = [
        'password',
        'reset_token',
    ];

    protected function casts(): array
    {
        return [
            'password'           => 'hashed',
            'reset_token_expiry' => 'datetime',
            'role'               => 'string',
        ];
    }

    // ─── Relasi ───────────────────────────────────────────

    /** Satu user bisa punya satu data panitia */
    public function admin(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }

    /** Satu user (pendaftar) punya satu berkas */
    public function berkas(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Berkas::class, 'user_id', 'id');
    }

    /** Satu user bisa punya banyak record seleksi */
    public function seleksis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Seleksi::class, 'user_id', 'id');
    }

    /** Audit logs yang dilakukan user ini (sebagai panitia) */
    public function auditLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AuditLog::class, 'panitia_id', 'id');
    }

    // ─── Helper Methods ───────────────────────────────────

    public function isPanitia(): bool
    {
        return $this->role === 'PANITIA';
    }

    public function isPendaftar(): bool
    {
        return $this->role === 'PENDAFTAR';
    }
}