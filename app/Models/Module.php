<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'pdf_file',
        'grade_level',
        'subject',
        'class_number',
        'views',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke Creator (tentor yang membuat)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke Classes (many-to-many)
    public function classes()
{
    return $this->belongsToMany(Classes::class, 'class_module', 'module_id', 'class_id');
}

    // Scope untuk filter berdasarkan jenjang
    public function scopeByGrade($query, $grade)
    {
        return $query->where('grade_level', $grade);
    }

    // Scope untuk filter berdasarkan kelas
    public function scopeByClass($query, $classNumber)
    {
        return $query->where('class_number', $classNumber);
    }

    // Scope hanya yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk module by creator
    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    // Scope untuk module by class
    public function scopeForClass($query, $classId)
    {
        return $query->whereHas('classes', function($q) use ($classId) {
            $q->where('classes.id', $classId);
        });
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }
}