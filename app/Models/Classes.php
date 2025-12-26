<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade_level',
        'class_number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke Users (students)
    public function students()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    // Relasi ke Tryouts (many-to-many)
    public function tryouts()
{
    return $this->belongsToMany(Tryout::class, 'class_tryout', 'class_id', 'tryout_id');
}

    // Relasi ke Modules (many-to-many)
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'class_module');
    }

    // Scope untuk filter active classes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk filter by grade level
    public function scopeByGrade($query, $grade)
    {
        return $query->where('grade_level', $grade);
    }

    // Get full name (e.g., "SMP 7A")
    public function getFullNameAttribute()
{
    return $this->grade_level . ' ' . $this->class_number . $this->name;
}
}