<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function gradeDistribution()
    {

        $ranges = [

            "A" => 0,
            "B" => 0,
            "C" => 0,
            "D" => 0,
            "F" => 0

        ];

        $grades = \App\Models\AssignmentSubmission::pluck('grade');

        foreach ($grades as $grade) {

            if ($grade >= 90) {

                $ranges["A"]++;

            } elseif ($grade >= 80) {

                $ranges["B"]++;

            } elseif ($grade >= 70) {

                $ranges["C"]++;

            } elseif ($grade >= 60) {

                $ranges["D"]++;

            } else {

                $ranges["F"]++;

            }

        }

        return response()->json([

            "success" => true,

            "distribution" => $ranges

        ]);

    }

    public function atRisk()
    {

        $students = \App\Models\User::where('role', 'student')->get();

        $result = [];

        foreach ($students as $student) {

            $progress = \App\Models\Progress::where('user_id', $student->id)
                ->avg('progress') ?? 0;

            if ($progress < 50) {

                $result[] = [

                    "id" => $student->id,

                    "name" => $student->name,

                    "email" => $student->email,

                    "section" => $student->section,

                    "progress" => $progress

                ];

            }

        }

        return response()->json([

            "percentage" => count($result) == 0 ? 0 :
                round((count($result) / $students->count()) * 100),

            "students" => $result

        ]);

    }

    public function performanceTrend(Request $request)
    {

        $period = $request->period ?? "week";

        if ($period == "week") {

            $data = [

                ["label" => "Week 1", "score" => 68],

                ["label" => "Week 2", "score" => 73],

                ["label" => "Week 3", "score" => 81],

                ["label" => "Week 4", "score" => 88]

            ];

        } elseif ($period == "month") {

            $data = [

                ["label" => "Jan", "score" => 72],

                ["label" => "Feb", "score" => 74],

                ["label" => "Mar", "score" => 83],

                ["label" => "Apr", "score" => 86]

            ];

        } else {

            $data = [

                ["label" => "Semester 1", "score" => 78],

                ["label" => "Semester 2", "score" => 84]

            ];

        }

        return response()->json([

            "success" => true,

            "period" => $period,

            "trend" => $data

        ]);

    }
}