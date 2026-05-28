<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;

class QuizController extends Controller
{
    // Create Quiz
    public function create(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string'
        ]);

        $quiz = Quiz::create([
            'course_id' => $request->course_id,
            'title' => $request->title
        ]);

        return response()->json([
            'message' => 'Quiz created successfully',
            'quiz' => $quiz
        ]);
    }

    // Add Question
    public function addQuestion(Request $request, $quiz_id)
    {
        $question = Question::create([
            'quiz_id' => $quiz_id,
            'question' => $request->question,
            'answer' => $request->answer
        ]);
        return response()->json($question);

    }
    public function show($id)
    {
        return response()->json(
            Quiz::with('questions')->findOrFail($id)
        );
    }
}