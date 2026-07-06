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

    public function download($id)
{
    $lesson = Lesson::findOrFail($id);

    return response()->json([
        'download_url'=>asset('storage/'.$lesson->file_path)
    ]);
}
}