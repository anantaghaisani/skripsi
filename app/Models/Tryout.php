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
    // ✅ GANTI METHOD INI
    // Get students who completed this tryout (WITH PIVOT DATA)
    public function getCompletedStudents()
    {
        // Get all students from assigned classes
        $allStudents = User::where('role', 'student')
            ->whereHas('class', function($query) {
                $query->whereIn('classes.id', $this->classes->pluck('id'));
            })
            ->with('class')
            ->get();

        // Filter only completed students and attach pivot data
        $completedStudents = collect();

        foreach ($allStudents as $student) {
            $userTryout = $this->users()
                ->where('users.id', $student->id)
                ->wherePivot('status', 'sudah_dikerjakan')
                ->first();

            if ($userTryout) {
                // Attach pivot data to student object
                $student->pivot = $userTryout->pivot;
                $completedStudents->push($student);
            }
        }

        return $completedStudents;
    }

    // ✅ GANTI METHOD INI
    // Get students who haven't done this tryout yet
    public function getPendingStudents()
    {
        // Get all students from assigned classes
        $allStudents = User::where('role', 'student')
            ->whereHas('class', function($query) {
                $query->whereIn('classes.id', $this->classes->pluck('id'));
            })
            ->with('class')
            ->get();

        // Filter only pending students (not completed)
        $pendingStudents = collect();

        foreach ($allStudents as $student) {
            $userTryout = $this->users()
                ->where('users.id', $student->id)
                ->wherePivot('status', 'sudah_dikerjakan')
                ->first();

            if (!$userTryout) {
                // This student has NOT completed the tryout
                $pendingStudents->push($student);
            }
        }

        return $pendingStudents;
    }

    // ✅ UPDATE METHOD INI JUGA
    // Get average score
    public function getAverageScore()
    {
        $completedStudents = $this->getCompletedStudents();
        
        if ($completedStudents->isEmpty()) {
            return 0;
        }

        return $completedStudents->avg('pivot.score') ?? 0;
    }

    // ✅ UPDATE METHOD INI JUGA
    // Get completion rate
    public function getCompletionRate()
    {
        $completed = $this->getCompletedStudents()->count();
        $pending = $this->getPendingStudents()->count();
        $total = $completed + $pending;

        if ($total === 0) {
            return 0;
        }

        return round(($completed / $total) * 100, 1);
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