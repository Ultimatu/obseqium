<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Quote extends Model
{
    protected $fillable = [
        'reference', 'token', 'client_id', 'assigned_to', 'status',
        'client_name', 'client_email', 'client_phone', 'client_company', 'client_job_title',
        'service_type', 'sector', 'company_size', 'deadline', 'description', 'attachments',
        'subtotal', 'tax_rate', 'tax_amount', 'total',
        'notes', 'internal_notes', 'valid_until', 'pdf_path', 'approval_document',
        'sent_at', 'viewed_at', 'responded_at', 'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'valid_until' => 'date',
            'sent_at' => 'datetime',
            'viewed_at' => 'datetime',
            'responded_at' => 'datetime',
            'approved_at' => 'datetime',
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
                $model->reference = static::generateReference();
            }

            if (empty($model->token)) {
                $model->token = Str::random(48);
            }
        });
    }

    public static function generateReference(): string
    {
        $settings = SiteSetting::getAllCached();

        $prefix = $settings->get('quote_ref_prefix', 'DEV');
        $padding = (int) $settings->get('quote_ref_padding', 4);
        $includeYear = filter_var($settings->get('quote_ref_include_year', true), FILTER_VALIDATE_BOOLEAN);
        $includeMonth = filter_var($settings->get('quote_ref_include_month', false), FILTER_VALIDATE_BOOLEAN);

        $query = static::query();

        if ($includeYear && $includeMonth) {
            $query->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'));
        } elseif ($includeYear) {
            $query->whereYear('created_at', date('Y'));
        }

        $number = str_pad($query->count() + 1, $padding, '0', STR_PAD_LEFT);

        $parts = [$prefix];

        if ($includeYear) {
            $parts[] = date('Y');
        }

        if ($includeMonth) {
            $parts[] = date('m');
        }

        $parts[] = $number;

        return implode('-', $parts);
    }

    public function portalUrl(): string
    {
        return route('quotes.portal', $this->token);
    }

    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['sent', 'viewed']);
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
