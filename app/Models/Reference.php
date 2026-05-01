<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable = [
        'title', 'slug', 'client_name', 'client_logo', 'sector',
        'challenge', 'solution', 'results', 'key_figures', 'cover_image',
        'is_featured', 'show_client_name', 'order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'key_figures' => 'array',
            'is_featured' => 'boolean',
            'show_client_name' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
