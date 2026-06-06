<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;

class AssignmentController extends Controller
{

    public function index()
    {
        $assignments = Assignment::withCount('submissions')
            ->with('submissions')
            ->get();

        $data = $assignments->map(function ($assignment) {

            $average = $assignment->submissions->avg('grade');

            return [
                'id' => $assignment->id,
                'title' => $assignment->title,
                'description' => $assignment->description,
                'course_id' => $assignment->course_id,
                'due_date' => $assignment->due_date,
                'total_points' => $assignment->total_points,
                'allow_late' => $assignment->allow_late,

                'submitted' => $assignment->submissions_count,
                'average_grade' => round($average, 2)
            ];
        });

        return response()->json($data);
    }

    public function show($id)
    {
        $assignment = Assignment::with([
            'course',
            'submissions'
        ])->findOrFail($id);

        return response()->json($assignment);
    }
    public function create(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'total_points' => 'nullable|integer',
            'allow_late' => 'nullable|boolean'
        ]);

        $assignment = Assignment::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'total_points' => $request->total_points ?? 100,
            'allow_late' => $request->allow_late ?? false
        ]);

        return response()->json([
            'message' => 'Assignment created successfully',
            'assignment' => $assignment
        ]);
    }
}