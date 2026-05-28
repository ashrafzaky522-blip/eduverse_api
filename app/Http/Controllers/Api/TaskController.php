<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(Task::all());
    }
    public function createTask(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);
        $task = Task::create($request->all());


        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ]);
    }
    public function submit($id)
    {
        return response()->json([
            'message' => 'Task submitted successfully',
            'task_id' => $id
        ]);
    }
}
