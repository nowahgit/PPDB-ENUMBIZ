<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'role',
        'email',
        'asal_sekolah',
        'nomor_pendaftaran',
        'no_hp',
        'jenis_kelamin',
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
        'nilai_smt1',
        'nilai_smt2',
        'nilai_smt3',
        'nilai_smt4',
        'nilai_smt5',
        'reset_token',
        'reset_token_expiry',
    ];

    protected $hidden = [
        'password',
        'reset_token',
    ];

    protected function casts(): array
    {
        return [
            'password'               => 'hashed',
            'reset_token_expiry'     => 'datetime',
            'role'                   => 'string',
            'tanggallahir_pendaftar' => 'date',
            'nilai_smt1'             => 'float',
            'nilai_smt2'             => 'float',
            'nilai_smt3'             => 'float',
            'nilai_smt4'             => 'float',
            'nilai_smt5'             => 'float',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /** Admin/panitia profile linked to this user account */
    public function admin(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    /** Berkas (documents) submitted by this pendaftar */
    public function berkas(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Berkas::class, 'user_id');
    }

    /** All seleksi records for this pendaftar */
    public function seleksis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Seleksi::class, 'user_id');
    }

    /** Audit log entries created by this user (when acting as panitia) */
    public function auditLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AuditLog::class, 'panitia_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function isPanitia(): bool
    {
        return $this->role === 'PANITIA';
    }

    public function isPendaftar(): bool
    {
        return $this->role === 'PENDAFTAR';
    }
}