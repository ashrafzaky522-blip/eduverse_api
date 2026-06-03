<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
class EnrollmentController extends Controller
{
    public function enroll(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);
        $enroll = Enrollment::create([
            'user_id' => $request->user()->id,
            'course_id' => $request->course_id
        ]);


        return response()->json([
            'message' => 'Enrolled successfully',
            'data' => $enroll
        ]);
    }
    public function myCourses(Request $request)
    {
        return response()->json(
            Enrollment::where('user_id', $request->user()->id)->get()
        );
    }
}