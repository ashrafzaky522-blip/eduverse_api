<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
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

        $students = \App\Models\User::where('role', 'student')->count();

        $pending = \App\Models\AssignmentSubmission::whereNull('grade')->count();

        $risk = \App\Models\Progress::where('progress', '<', 50)
            ->distinct('user_id')
            ->count();

        return response()->json([

            "total_students" => $students,

            "pending_grading" => $pending,

            "at_risk" => $risk

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
