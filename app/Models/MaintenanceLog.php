<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    protected $fillable = [
        'started_at',
        'ended_at',
        'started_by',
        'ended_by',
        'message',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function startedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'started_by');
    }

    public function endedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ended_by');
    }

    public function scopeOpen(Builder $query): void
    {
        $query->whereNull('ended_at');
    }

    public function scopeClosed(Builder $query): void
    {
        $query->whereNotNull('ended_at');
    }

    public function getDurationAttribute(): ?string
    {
        if (! $this->ended_at) {
            return null;
        }

        $minutes = (int) $this->started_at->diffInMinutes($this->ended_at);

        if ($minutes < 60) {
            return $minutes.' min';
        }

        $hours = floor($minutes / 60);
        $remaining = $minutes % 60;

        return $remaining > 0
            ? "{$hours}h {$remaining}min"
            : "{$hours}h";
    }

    public static function closeCurrent(int $userId): void
    {
        static::open()
            ->latest('started_at')
            ->first()
            ?->update(['ended_at' => now(), 'ended_by' => $userId]);
    }
}
