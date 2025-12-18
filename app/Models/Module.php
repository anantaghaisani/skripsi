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
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }
}