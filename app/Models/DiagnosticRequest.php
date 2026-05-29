<?php

namespace App\Models;

use Database\Factories\DiagnosticRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagnosticRequest extends Model
{
    /** @use HasFactory<DiagnosticRequestFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'client_name',
        'client_email',
        'client_phone',
        'client_company',
        'client_address',
        'sector',
        'company_size',
        'requested_standards',
        'requested_date',
        'scheduled_date',
        'completed_date',
        'status',
        'assigned_to',
        'report_path',
        'gaps_identified',
        'recommendations',
        'overall_gap_level',
        'converted_to_quote_id',
        'converted_at',
        'notes',
        'internal_notes',
    ];

    protected $casts = [
        'requested_date' => 'date',
        'scheduled_date' => 'date',
        'completed_date' => 'date',
        'converted_at' => 'datetime',
        'requested_standards' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $diagnostic) {
            if (empty($diagnostic->reference)) {
                $diagnostic->reference = 'DIAG-'.now()->format('Y').'-'.str_pad((static::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class, 'converted_to_quote_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'requested');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeToPlan($query)
    {
        return $query->whereIn('status', ['requested', 'scheduled']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeConverted($query)
    {
        return $query->whereNotNull('converted_to_quote_id');
    }

    public function isConverted(): bool
    {
        return $this->converted_to_quote_id !== null;
    }

    public function canBeConverted(): bool
    {
        return in_array($this->status, ['completed']) && ! $this->isConverted();
    }
}
