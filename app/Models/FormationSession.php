<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormationSession extends Model
{
    protected $fillable = [
        'formation_id', 'start_date', 'end_date', 'location', 'city',
        'max_participants', 'current_participants', 'status', 'is_published', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function registrations()
    {
        return $this->hasMany(FormationRegistration::class);
    }

    public function getAvailableSpotsAttribute(): int
    {
        return max(0, $this->max_participants - $this->current_participants);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('status', 'open');
    }
}
