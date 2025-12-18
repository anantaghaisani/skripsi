<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tryout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'description',
        'start_date',
        'end_date',
        'total_questions',
        'duration_minutes',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relasi dengan User melalui user_tryouts
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tryouts')
                    ->withPivot('status', 'score', 'started_at', 'finished_at')
                    ->withTimestamps();
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
