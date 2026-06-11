<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name', 'description', 'status',
        'quote_id', 'diagnostic_request_id', 'created_by',
        'start_date', 'due_date', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'due_date' => 'date',
            'completed_at' => 'date',
        ];
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function diagnosticRequest(): BelongsTo
    {
        return $this->belongsTo(DiagnosticRequest::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** @return HasMany<ProjectTask> */
    public function tasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class)->whereNull('parent_id')->orderBy('order');
    }

    /** @return HasMany<ProjectTask> */
    public function allTasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class);
    }

    /**
     * Calcule la progression en % basée sur les poids des tâches racines complétées.
     */
    public function getProgressAttribute(): int
    {
        $tasks = $this->allTasks()->whereNull('parent_id')->get();
        $totalWeight = $tasks->sum('weight');

        if ($totalWeight === 0) {
            return 0;
        }

        $completedWeight = $tasks->where('status', 'done')->sum('weight');

        return (int) round(($completedWeight / $totalWeight) * 100);
    }

    public function hasUnfinishedTasks(): bool
    {
        return $this->allTasks()->whereNull('parent_id')->where('status', '!=', 'done')->exists();
    }
}
