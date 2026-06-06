<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;

class AssignmentController extends Controller
{

    public function index()
    {
        $assignments = Assignment::withCount([
            'submissions as submitted_count'
        ])->get();

        return response()->json($assignments);
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
            'id' => 'required',
            'title' => 'required'
        ]);

        $assignment = Assignment::create([
            'id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Assignment created',
            'assignment' => $assignment
        ]);
    }
}