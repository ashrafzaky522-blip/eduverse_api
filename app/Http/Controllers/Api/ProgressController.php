<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progress;

class ProgressController extends Controller
{
    public function update(Request $request)
    {
        $progress = Progress::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'course_id' => $request->course_id
            ],
            [
                'progress' => $request->progress
            ]
        );

        return response()->json($progress);
    }

    public function myProgress(Request $request)
    {
        return response()->json(
            Progress::where('user_id', $request->user()->id)->get()
        );
    }
}