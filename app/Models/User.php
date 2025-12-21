<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo',
        'grade_level',
        'class_number',
        'class_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi ke Class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    // Relasi ke Tryouts yang sudah dikerjakan (many-to-many)
    public function tryouts()
    {
        return $this->belongsToMany(Tryout::class, 'user_tryouts')
                    ->withPivot('status', 'score', 'started_at', 'finished_at')
                    ->withTimestamps();
    }

    // Relasi ke Tryouts yang dibuat (untuk tentor)
    public function createdTryouts()
    {
        return $this->hasMany(Tryout::class, 'created_by');
    }

    // Relasi ke Modules yang dibuat (untuk tentor)
    public function createdModules()
    {
        return $this->hasMany(Module::class, 'created_by');
    }

    // Check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Check if user is tentor
    public function isTentor()
    {
        return $this->role === 'tentor';
    }

    // Check if user is student
    public function isStudent()
    {
        return $this->role === 'student';
    }

    // Scope untuk filter by role
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Scope untuk students only
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    // Scope untuk tentors only
    public function scopeTentors($query)
    {
        return $query->where('role', 'tentor');
    }
}