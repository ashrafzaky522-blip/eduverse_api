<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Enrollment;

class StudentController extends Controller
{
    // كورسات الطالب
    public function myCourses(Request $request)
    {
        $courses = Enrollment::where('student_id', $request->user()->id)
            ->with('course')
            ->get();

        return response()->json($courses);
    }

    // تسجيل في كورس
    public function enroll(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $enroll = Enrollment::create([
            'student_id' => $request->user()->id,
            'course_id' => $request->course_id
        ]);

        return response()->json([
            'message' => 'Enrolled successfully',
            'data' => $enroll
        ]);
    }

    // عرض كورس
    public function showCourse($id)
    {
        $course = Course::with('lessons')->findOrFail($id);

        return response()->json($course);
    }
}