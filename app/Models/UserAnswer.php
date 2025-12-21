<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tryout_id',
        'question_id',
        'answer_id',
        'selected_option',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Tryout
    public function tryout()
    {
        return $this->belongsTo(Tryout::class);
    }

    // Relasi ke Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relasi ke Answer yang dipilih
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}