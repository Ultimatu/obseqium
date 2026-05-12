<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $fillable = [
        'reference', 'quote_id', 'client_id', 'assigned_to', 'status',
        'client_name', 'client_email', 'client_phone', 'client_company', 'client_address',
        'subtotal', 'tax_rate', 'tax_amount', 'total',
        'notes', 'issued_at', 'due_at', 'sent_at', 'paid_at', 'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'due_at' => 'date',
            'sent_at' => 'datetime',
            'paid_at' => 'datetime',
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
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $model->reference = 'FAC-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('order');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'sent')->where('due_at', '<', today());
    }

    public static function fromQuote(Quote $quote): self
    {
        $invoice = self::create([
            'quote_id' => $quote->id,
            'client_id' => $quote->client_id,
            'assigned_to' => $quote->assigned_to,
            'client_name' => $quote->client_name,
            'client_email' => $quote->client_email,
            'client_phone' => $quote->client_phone,
            'client_company' => $quote->client_company,
            'subtotal' => $quote->subtotal,
            'tax_rate' => $quote->tax_rate,
            'tax_amount' => $quote->tax_amount,
            'total' => $quote->total,
            'notes' => $quote->notes,
            'issued_at' => today(),
            'due_at' => today()->addDays(30),
        ]);

        foreach ($quote->items as $item) {
            $invoice->items()->create([
                'description' => $item->description,
                'details' => $item->details,
                'quantity' => $item->quantity,
                'unit' => $item->unit,
                'unit_price' => $item->unit_price,
                'total' => $item->total,
                'order' => $item->order,
            ]);
        }

        return $invoice;
    }
}
