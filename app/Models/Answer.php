<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'option',
        'answer_text',
        'answer_image',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // Relasi ke Question
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // Relasi ke User Answers
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}