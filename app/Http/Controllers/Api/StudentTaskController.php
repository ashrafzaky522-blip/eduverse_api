<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class StudentTaskController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date'
        ]);

        $task = Task::create([

            'user_id' => $request->user()->id,

            'title' => $request->title,
            'course_id' => $request->course_id,

            'description' => $request->description,

            'due_date' => $request->due_date,

            'status' => 'pending',

            'type' => 'personal'

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Task created successfully',

            'task' => $task

        ], 201);
    }
}