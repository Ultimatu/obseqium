<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthentication;
use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthenticationRecovery;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthenticationRecovery;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAppAuthentication, HasAppAuthenticationRecovery
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    use InteractsWithAppAuthentication, InteractsWithAppAuthenticationRecovery;

    public function canAccessPanel(Panel $panel): bool
    {
        // return $this->is_active && in_array($this->role, ['admin', 'consultant']);
        return true;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'company',
        'job_title',
        'role',
        'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function scopeConsultants(Builder $query): Builder
    {
        return $query->where('role', '!=', 'client');
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'client_id');
    }

    public function assignedQuotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'assigned_to');
    }

    public function quoteMessages(): HasMany
    {
        return $this->hasMany(QuoteMessage::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'requester_id');
    }

    public function consultantAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'consultant_id');
    }

    public function formationRegistrations(): HasMany
    {
        return $this->hasMany(FormationRegistration::class);
    }

    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }
}
