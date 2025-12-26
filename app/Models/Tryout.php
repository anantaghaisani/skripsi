<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tryout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'token',
        'description',
        'start_date',
        'end_date',
        'total_questions',
        'duration_minutes',
        'status',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Auto generate token saat create
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($tryout) {
            if (empty($tryout->token)) {
                $tryout->token = self::generateUniqueToken();
            }
        });
    }

    // Generate unique 6-digit token
    public static function generateUniqueToken()
    {
        do {
            $token = strtoupper(Str::random(6));
        } while (self::where('token', $token)->exists());
        
        return $token;
    }

    // Relasi ke Users yang sudah mengerjakan (many-to-many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tryouts')
                    ->withPivot('status', 'score', 'started_at', 'finished_at')
                    ->withTimestamps();
    }

    // Relasi ke Creator (tentor yang membuat)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke Classes (many-to-many)
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'class_tryout', 'tryout_id', 'class_id');
    }

    // Relasi ke Questions
    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('question_number');
    }

    // Relasi ke User Answers
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    // Scope untuk tryout aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk tryout by creator
    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    // Scope untuk tryout by class
    public function scopeForClass($query, $classId)
{
    return $query->whereHas('classes', function($q) use ($classId) {
        $q->where('classes.id', $classId);
    });
}

    // Get students who completed this tryout
    public function getCompletedStudents()
    {
        return $this->users()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->orderByPivot('finished_at', 'desc')
            ->get();
    }

    // Get students who haven't done this tryout yet
    public function getPendingStudents()
    {
        $classIds = $this->classes->pluck('id');
        $completedUserIds = $this->users()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->pluck('users.id');
        
        return User::students()
            ->whereIn('class_id', $classIds)
            ->whereNotIn('id', $completedUserIds)
            ->get();
    }

    // Get average score
    public function getAverageScore()
    {
        return $this->users()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->avg('user_tryouts.score');
    }

    // Get completion rate
    public function getCompletionRate()
    {
        $totalStudents = User::students()
            ->whereIn('class_id', $this->classes->pluck('id'))
            ->count();
        
        if ($totalStudents == 0) return 0;
        
        $completedStudents = $this->users()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->count();
        
        return round(($completedStudents / $totalStudents) * 100, 1);
    }

    // Check if tryout has questions
    public function hasQuestions()
{
    return $this->questions()->count() > 0;
}

    // Get question count
    public function getQuestionCount()
    {
        return $this->questions()->count();
    }
}