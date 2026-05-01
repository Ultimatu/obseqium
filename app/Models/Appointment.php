<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'requester_id', 'consultant_id',
        'guest_name', 'guest_email', 'guest_phone', 'guest_company',
        'type', 'status', 'requested_date', 'confirmed_date', 'duration_minutes',
        'meeting_link', 'location', 'subject', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'requested_date' => 'datetime',
            'confirmed_date' => 'datetime',
        ];
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    public function getClientNameAttribute(): string
    {
        return $this->requester?->name ?? $this->guest_name ?? '';
    }

    public function getClientEmailAttribute(): string
    {
        return $this->requester?->email ?? $this->guest_email ?? '';
    }
}
