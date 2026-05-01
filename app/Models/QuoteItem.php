<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $fillable = [
        'quote_id', 'description', 'details', 'quantity', 'unit', 'unit_price', 'total', 'order',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            $model->total = $model->quantity * $model->unit_price;
        });

        static::saved(function (self $model) {
            $model->quote->recalculateTotals();
        });

        static::deleted(function (self $model) {
            $model->quote->recalculateTotals();
        });
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
