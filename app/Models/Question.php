<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'tryout_id',
        'question_number',
        'question_text',
        'question_image',
        'explanation',
        'points',
    ];

    // Relasi ke Tryout
    public function tryout()
    {
        return $this->belongsTo(Tryout::class);
    }

    // Relasi ke Answers (A, B, C, D, E)
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    // Relasi ke User Answers
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    // Get correct answer
    public function getCorrectAnswer()
    {
        return $this->answers()->where('is_correct', true)->first();
    }

    // Get correct option (A/B/C/D/E)
    public function getCorrectOption()
    {
        $correct = $this->getCorrectAnswer();
        return $correct ? $correct->option : null;
    }
}