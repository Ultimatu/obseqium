<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteMessage extends Model
{
    protected $fillable = ['quote_id', 'user_id', 'content', 'is_internal', 'read_at'];

    protected function casts(): array
    {
        return [
            'is_internal' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
