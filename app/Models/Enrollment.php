<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;
class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id'
    ];

    public function myCourses(Request $request)
    {
        $courses = Course::whereIn(
            'id',
            Enrollment::where(
                'user_id',
                $request->user()->id
            )->pluck('course_id')
        )->get();

        return response()->json($courses);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}