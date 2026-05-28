<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'title' => 'required'
        ]);

        $assignment = Assignment::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Assignment created',
            'assignment' => $assignment
        ]);
    }
}