<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'icon', 'image', 'description', 'content',
        'methodology', 'deliverables', 'type', 'order', 'is_active',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'methodology' => 'array',
            'deliverables' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->orderByRaw("CASE WHEN type = 'strategic' THEN 0 ELSE 1 END")
            ->orderBy('order');
    }
}
