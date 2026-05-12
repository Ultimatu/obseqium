<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'action',
        'subject_type',
        'subject_id',
        'description',
        'properties',
        'causer_id',
    ];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public static function record(
        string $action,
        string $description,
        ?Model $subject = null,
        array $properties = [],
    ): self {
        return self::create([
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->getKey(),
            'properties' => $properties ?: null,
            'causer_id' => auth()->id(),
        ]);
    }
}
