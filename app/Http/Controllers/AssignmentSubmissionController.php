<?php
namespace App\Http\Controllers;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
class AssignmentSubmissionController extends Controller
{
    public function submit(Request $request)
    {
        $submission = AssignmentSubmission::create([
            'assignment_id' => $request->assignment_id,
            'student_id' => $request->user()->id,
            'submission_text' => $request->submission_text
        ]);

        return response()->json([
            'message' => 'Assignment submitted successfully',
            'submission' => $submission
        ]);
    }
    public function grade(Request $request, $id)
    {
        $submission = AssignmentSubmission::findOrFail($id);
        $submission->update([
            'grade' => $request->grade
        ]);
        return response()->json([
            'message' => 'Assignment graded successfully',
            'submission' => $submission
        ]);
    }
}