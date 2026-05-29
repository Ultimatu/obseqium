<?php

namespace App\Models;

use Database\Factories\ProcessPhaseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessPhase extends Model
{
    /** @use HasFactory<ProcessPhaseFactory> */
    use HasFactory;

    protected $fillable = [
        'order',
        'title',
        'description',
        'badge',
        'highlights',
        'icon',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
