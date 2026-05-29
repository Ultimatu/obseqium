<?php

namespace App\Models;

use Database\Factories\PricingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    /** @use HasFactory<PricingFactory> */
    use HasFactory;

    protected $fillable = [
        'key',
        'hero_title',
        'hero_description',
        'pricing_principle_title',
        'pricing_principle_content',
        'criteria',
        'example_total_amount',
        'example_duration_months',
        'payment_terms',
        'includes',
        'excludes',
        'process_steps',
        'offer_title',
        'offer_content',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'criteria' => 'array',
            'includes' => 'array',
            'excludes' => 'array',
            'process_steps' => 'array',
            'example_total_amount' => 'decimal:2',
            'example_duration_months' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getMonthlyAmountAttribute(): float
    {
        if ($this->example_duration_months <= 0) {
            return 0;
        }

        return $this->example_total_amount / $this->example_duration_months;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('key', 'default');
    }
}
