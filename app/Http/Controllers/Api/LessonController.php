<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
class LessonController extends Controller
{
    public function show($id)
    {
        return response()->json(Lesson::findOrFail($id));
    }
}