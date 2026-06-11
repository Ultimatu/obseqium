<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectTask extends Model
{
    protected $fillable = [
        'project_id', 'parent_id', 'assigned_to',
        'title', 'description', 'status',
        'weight', 'requires_deliverable',
        'due_date', 'order',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'requires_deliverable' => 'boolean',
            'weight' => 'integer',
            'order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $model): void {
            if ($model->parent_id && ! $model->project_id) {
                $model->project_id = static::find($model->parent_id)?->project_id;
            }
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProjectTask::class, 'parent_id');
    }

    /** @return HasMany<ProjectTask> */
    public function subtasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class, 'parent_id')->orderBy('order');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /** @return HasMany<TaskChecklist> */
    public function checklists(): HasMany
    {
        return $this->hasMany(TaskChecklist::class, 'task_id')->orderBy('order');
    }

    /** @return HasMany<TaskComment> */
    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class, 'task_id')->latest();
    }

    /** @return HasMany<TaskDeliverable> */
    public function deliverables(): HasMany
    {
        return $this->hasMany(TaskDeliverable::class, 'task_id');
    }

    /**
     * Progression des checklist items (0-100).
     */
    public function getChecklistProgressAttribute(): int
    {
        $total = $this->checklists()->count();
        if ($total === 0) {
            return 0;
        }

        $done = $this->checklists()->where('is_completed', true)->count();

        return (int) round(($done / $total) * 100);
    }

    public function hasUncompletedChecklists(): bool
    {
        return $this->checklists()->where('is_completed', false)->exists();
    }

    public function isMissingRequiredDeliverable(): bool
    {
        return $this->requires_deliverable && $this->deliverables()->count() === 0;
    }
}
