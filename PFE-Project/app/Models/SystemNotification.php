<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemNotification extends Model
{
    protected $fillable = [
        'title',
        'body',
        'type',        // 'info' | 'success' | 'warning' | 'error'
        'target',      // 'all' | 'admin' | 'client'
        'is_read',
        'link',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /* ── Scopes ── */
    public function scopeForRole($query, string $role)
    {
        return $query->where(function ($q) use ($role) {
            $q->where('target', 'all')->orWhere('target', $role);
        });
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /* ── Helper to broadcast a notification ── */
    public static function broadcast(string $title, string $body, string $type = 'info', string $target = 'all', ?string $link = null): self
    {
        return self::create([
            'title'   => $title,
            'body'    => $body,
            'type'    => $type,
            'target'  => $target,
            'is_read' => false,
            'link'    => $link,
        ]);
    }
}
