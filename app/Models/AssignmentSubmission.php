<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id',
        'student_id',
        'submission_text',
        'file',
        'grade',
        'feedback'
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'student_id'
        );
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
