<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
class AnalyticsController extends Controller
{
    public function dashboard()
    {
        return response()->json([
            'users' => User::count(),
            'courses' => Course::count()
        ]);
    }

    public function atRiskStudents()
    {
        return response()->json([
            'message' => 'At risk students list'
        ]);
    }
}