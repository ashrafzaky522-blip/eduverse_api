<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Enrollment;
use App\Models\Quiz;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;

class AdminController extends Controller
{
    // 📋 عرض جميع المستخدمين (منسقة بدون Password)
    public function users()
    {
        return response()->json(
            User::select('id', 'name', 'email', 'role', 'created_at')->get()
        );
    }

    // 🗑️ حذف مستخدم
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user', 'details' => $e->getMessage()], 500);
        }
    }

    // 📚 عرض جميع الكورسات (مع المدرس والدروس)
    public function courses()
    {
        return response()->json(\App\Models\Course::with('instructor')->get());
    }

    // 🗑️ حذف كورس
    public function deleteCourse($id)
    {
        $course = \App\Models\Course::findOrFail($id);
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully']);
    }

    // 📊 لوحة الإحصائيات
    public function dashboards()
    {
        return response()->json([
            'total_users' => \App\Models\User::count(),
            'total_courses' => \App\Models\Course::count(),
            'total_enrollments' => \App\Models\Enrollment::count(),
        ]);
    }
    public function dashboard()
    {
        return response()->json([
            'total_students' => User::where('role', 'student')->count(),
            'total_instructors' => User::where('role', 'instructor')->count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
        ]);
    }
    public function reports()
    {
        return response()->json([
            'users' => User::count(),
            'students' => User::where('role', 'student')->count(),
            'instructors' => User::where('role', 'instructor')->count(),
            'courses' => Course::count(),
            'enrollments' => Enrollment::count(),
            'assignments' => Assignment::count(),
            'quizzes' => Quiz::count()
        ]);
    }

    public function atRiskStudents()
    {
        return response()->json([
            'students' => [
                'Ahmed',
                'Ali'
            ]
        ]);
    }
}