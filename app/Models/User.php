<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ العلاقة مع جدول Enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // ✅ العلاقة مع الكورسات اللي بيملكها لو كان مدرس
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // ✅ العلاقة مع الإشعارات
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
   
}