<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Task;
use App\Models\Assignment;

class InstructorController extends Controller
{
    // عرض كورسات المدرس
    public function myCourses(Request $request)
    {
        $courses = Course::where('user_id', $request->user()->id)->get();

        return response()->json($courses);
    }

    // إضافة كورس
    public function addCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'price' => 'nullable|numeric|min:0'
        ]);

        $course = Course::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $request->thumbnail,
            'price' => $request->price
        ]);

        return response()->json([
            'message' => 'Course created successfully',
            'course' => $course
        ]);
    }

    // تعديل كورس
    public function updateCourse(Request $request, $id)
    {
        $course = Course::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $course->update(
            $request->only('title', 'description', 'thumbnail', 'price')
        );

        return response()->json([
            'message' => 'Course updated successfully',
            'course' => $course
        ]);
    }

    // حذف كورس
    public function deleteCourse(Request $request, $id)
    {
        $course = Course::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $course->delete();

        return response()->json([
            'message' => 'Course deleted successfully'
        ]);
    }

    // إضافة درس
    public function addLesson(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'video_url' => 'nullable|string',
            'content' => 'nullable|string'
        ]);

        $lesson = Lesson::create([
            'course_id' => $id,
            'title' => $request->title,
            'video_url' => $request->video_url,
            'content' => $request->content
        ]);

        return response()->json([
            'message' => 'Lesson added successfully',
            'lesson' => $lesson
        ]);
    }

    // إنشاء Task
    public function createTask(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        $task = Task::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ]);
    }

    // إنشاء Assignment
    public function createAssignment(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $assignment = Assignment::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Assignment created successfully',
            'assignment' => $assignment
        ]);
    }
}