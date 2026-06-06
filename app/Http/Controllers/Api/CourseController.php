<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::all());
    }

    public function show($id)
    {
        $course = Course::with('lessons')->findOrFail($id);

        return response()->json($course);
    }
    public function lessons($id)
    {
        $course = Course::with('lessons')->findOrFail($id);

        return response()->json($course->lessons);
    }
}