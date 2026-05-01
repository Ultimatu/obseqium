<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormationRegistration extends Model
{
    protected $fillable = [
        'formation_session_id', 'user_id',
        'guest_name', 'guest_email', 'guest_phone', 'guest_company',
        'status', 'notes', 'attestation_path', 'confirmed_at', 'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function session()
    {
        return $this->belongsTo(FormationSession::class, 'formation_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getParticipantNameAttribute(): string
    {
        return $this->user?->name ?? $this->guest_name ?? '';
    }

    public function getParticipantEmailAttribute(): string
    {
        return $this->user?->email ?? $this->guest_email ?? '';
    }
}
