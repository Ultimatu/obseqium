<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'reference', 'client_id', 'assigned_to', 'status',
        'client_name', 'client_email', 'client_phone', 'client_company', 'client_job_title',
        'service_type', 'sector', 'company_size', 'deadline', 'description', 'attachments',
        'subtotal', 'tax_rate', 'tax_amount', 'total',
        'notes', 'internal_notes', 'valid_until', 'pdf_path',
        'sent_at', 'viewed_at', 'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'valid_until' => 'date',
            'sent_at' => 'datetime',
            'viewed_at' => 'datetime',
            'responded_at' => 'datetime',
            'subtotal' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->reference)) {
                $model->reference = 'DEV-' . date('Y') . '-' . str_pad(
                    static::whereYear('created_at', date('Y'))->count() + 1,
                    4, '0', STR_PAD_LEFT
                );
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function consultant()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class)->orderBy('order');
    }

    public function messages()
    {
        return $this->hasMany(QuoteMessage::class)->orderBy('created_at');
    }

    public function recalculateTotals(): void
    {
        $subtotal = $this->items()->sum('total');
        $taxAmount = $subtotal * ($this->tax_rate / 100);
        $this->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $subtotal + $taxAmount,
        ]);
    }
}
