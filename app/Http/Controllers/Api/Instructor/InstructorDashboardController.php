<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\AssignmentSubmission;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Http\Request;

class InstructorDashboardController extends Controller
{
    public function students(Request $request)
    {
        $students = \App\Models\User::where('role', 'student')
            ->select(
                'id',
                'name',
                'email',
                'section',
                'attendance'
            )
            ->get()
            ->map(function ($student) {

                $progress = \App\Models\Progress::where('user_id', $student->id)
                    ->avg('progress') ?? 0;

                return [

                    'student_id' => $student->id,

                    'name' => $student->name,

                    'email' => $student->email,

                    'section' => $student->section,

                    'attendance' => $student->attendance,

                    'at_risk' => $progress < 50

                ];

            });

        return response()->json([

            'success' => true,

            'students' => $students

        ]);
    }
    public function stats()
    {

        $totalStudents = User::where('role', 'student')->count();

        $pending = AssignmentSubmission::whereNull('grade')->count();

        $atRisk = Progress::where('progress', '<', 50)
            ->distinct('user_id')
            ->count();

        $graded = AssignmentSubmission::whereNotNull('grade');

        $passingRate = $graded->count()
            ? round(($graded->where('grade', '>=', 60)->count() / $graded->count()) * 100, 2)
            : 0;

        $classAverage = round(
            AssignmentSubmission::avg('grade') ?? 0,
            2
        );

        $completionRate = round(
            Progress::avg('progress') ?? 0,
            2
        );

        return response()->json([

            "total_students" => $totalStudents,

            "pending_grading" => $pending,

            "at_risk" => $atRisk,

            "passing_rate" => $passingRate,

            "class_average" => $classAverage,

            "completion_rate" => $completionRate

        ]);

    }
    public function tas()
    {

        $tas = \App\Models\User::where('role', 'ta')

            ->get()

            ->map(function ($ta) {

                return [

                    "id" => $ta->id,

                    "name" => $ta->name,

                    "email" => $ta->email,

                    "section" => $ta->section,

                    "students" => \App\Models\Enrollment::where('ta_id', $ta->id)->count(),

                    "performance" => rand(80, 100)

                ];

            });

        return response()->json([

            "success" => true,

            "tas" => $tas

        ]);

    }
}
