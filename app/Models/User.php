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
        'photo',
        'grade_level', // TAMBAH
        'class_number', // TAMBAH
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi dengan Tryout melalui user_tryouts
    public function tryouts()
    {
        return $this->belongsToMany(Tryout::class, 'user_tryouts')
                    ->withPivot('status', 'score', 'started_at', 'finished_at')
                    ->withTimestamps();
    }
}
