<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
class AnalyticsController extends Controller
{
    public function dashboard()
    {
        return response()->json([
            'students' => User::where('role', 'student')->count(),
            'courses' => Course::count(),
            'enrollments' => Enrollment::count(),
            'assignments' => Assignment::count()
        ]);
    }

    public function atRiskStudents()
    {
        $students = User::where('role', 'student')
            ->withCount('enrollments')
            ->get();

        return response()->json($students);
    }
}