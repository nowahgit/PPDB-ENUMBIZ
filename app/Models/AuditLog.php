<?php
// app/Models/AuditLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    // Hanya punya created_at, tidak ada updated_at
    public $timestamps  = false;
    const  CREATED_AT   = 'created_at';

    protected $fillable = [
        'action',
        'entity_type',
        'entity_id',
        'before',
        'after',
        'keterangan',
        'panitia_id',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'entity_id'  => 'integer',
        ];
    }

    // ─── Relasi ───────────────────────────────────────────

    /** Log dibuat oleh panitia tertentu (nullable) */
    public function panitia(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'panitia_id', 'id');
    }
}