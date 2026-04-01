<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $table      = 'audit_logs';
    protected $primaryKey = 'id';

    /**
     * Audit logs are immutable — we manage created_at manually via
     * useCurrent() in the migration; updated_at does not exist.
     */
    public $timestamps = false;

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
            // JSON snapshots decoded to arrays automatically
            // We store as plain longText; cast to array handles decode/encode
            'before'     => 'array',
            'after'      => 'array',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /**
     * The panitia (admin user) who triggered this log entry.
     * Nullable — system-generated events have no panitia.
     */
    public function panitia(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'panitia_id');
    }
}