<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = ['email', 'name', 'is_active', 'token', 'subscribed_at', 'unsubscribed_at'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->token)) {
                $model->token = \Illuminate\Support\Str::random(64);
            }
            $model->subscribed_at = now();
        });
    }

    public function unsubscribe(): void
    {
        $this->update(['is_active' => false, 'unsubscribed_at' => now()]);
    }
}
