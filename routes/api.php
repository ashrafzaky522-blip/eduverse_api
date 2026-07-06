<?php

use App\Http\Controllers\Api\Instructor\InstructorDashboardController;
use App\Http\Controllers\Api\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\CalendarController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ProgressController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\AssignmentController;

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Instructor\InstructorController;
use App\Http\Controllers\Api\Student\StudentController;

use App\Http\Controllers\AssignmentSubmissionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/user', [AuthController::class, 'user']);

    Route::put('/profile', [AuthController::class, 'updateProfile']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/activities/{id}/register', [ActivityController::class, 'register']);

    /*
    |--------------------------------------------------------------------------
    | Student Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:student')->prefix('student')->group(function () {

        // My Courses
        Route::get('/my-courses', [StudentController::class, 'myCourses']);

        // Enroll Course
        Route::post('/enroll', [StudentController::class, 'enroll']);

        // Show Course
        Route::get('/courses/{id}', [StudentController::class, 'showCourse']);
    });

    /*
    |--------------------------------------------------------------------------
    | Instructor Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:instructor')->prefix('instructor')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Courses
        |--------------------------------------------------------------------------
        */

        Route::get('/my-courses', [InstructorController::class, 'myCourses']);

        Route::post('/courses', [InstructorController::class, 'addCourse']);

        Route::put('/courses/{id}', [InstructorController::class, 'updateCourse']);

        Route::delete('/courses/{id}', [InstructorController::class, 'deleteCourse']);

        Route::get('/reports', [InstructorController::class, 'reports']);

        Route::get(
            '/student',
            [InstructorController::class, 'students']
        );

        /*
        |--------------------------------------------------------------------------
        | Lessons
        |--------------------------------------------------------------------------
        */

        Route::post('/courses/{id}/lessons', [InstructorController::class, 'addLesson']);

        Route::put('/lessons/{id}', [InstructorController::class, 'updateLesson']);

        Route::delete('/lessons/{id}', [InstructorController::class, 'deleteLesson']);

        /*
        |--------------------------------------------------------------------------
        | Tasks
        |--------------------------------------------------------------------------
        */

        Route::post('/tasks/create', [InstructorController::class, 'createTask']);

        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::post('/notifications/create', [NotificationController::class, 'create']);

        /*
        |--------------------------------------------------------------------------
        | Assignments
        |--------------------------------------------------------------------------
        */

        Route::post('/assignments/create', [AssignmentController::class, 'create']);

        Route::get('/assignments', [AssignmentController::class, 'index']);

        Route::get('/assignments/{id}', [AssignmentController::class, 'show']);

        /*
        |--------------------------------------------------------------------------
        | Quiz
        |--------------------------------------------------------------------------
        */

        Route::post('/quiz/create', [QuizController::class, 'create']);

        Route::post('/quiz/{quiz_id}/question', [QuizController::class, 'addQuestion']);

        Route::put('/quiz/{id}', [QuizController::class, 'update']);

        Route::delete('/quiz/{id}', [QuizController::class, 'delete']);

        /*
        |--------------------------------------------------------------------------
        | Assignment Grading
        |--------------------------------------------------------------------------
        */

        Route::post('/assignments/grade/{id}', [AssignmentSubmissionController::class, 'grade']);

        Route::get('/assignments/{id}/submissions', [AssignmentSubmissionController::class, 'index']);

        Route::get('/students', [InstructorDashboardController::class, 'students']);

        Route::get('/stats', [InstructorDashboardController::class, 'stats']);

        Route::get('/tas', [InstructorDashboardController::class, 'tas']);


        Route::get('/grade-distribution', [AnalyticsController::class, 'gradeDistribution']);

        Route::get('/at-risk', [AnalyticsController::class, 'atRisk']);

        Route::get('/performance-trend', [AnalyticsController::class, 'performanceTrend']);


    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->prefix('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [AdminController::class, 'users']);

        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

        /*
        |--------------------------------------------------------------------------
        | Courses
        |--------------------------------------------------------------------------
        */

        Route::get('/courses', [AdminController::class, 'courses']);

        Route::delete('/courses/{id}', [AdminController::class, 'deleteCourse']);

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminController::class, 'dashboard']);

        /*
        |--------------------------------------------------------------------------
        | Analytics
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/analytics/dashboard',
            [AnalyticsController::class, 'dashboard']
        );

        Route::get(
            '/analytics/risk',
            [AnalyticsController::class, 'atRiskStudents']
        );

        Route::get('/reports', [AdminController::class, 'reports']);

        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::post('/notifications/create', [NotificationController::class, 'create']);
    });

    /*
    |--------------------------------------------------------------------------
    | General Authenticated Routes
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Courses
    |--------------------------------------------------------------------------
    */

    Route::get('/courses', [CourseController::class, 'index']);

    Route::get('/courses/{id}/lessons', [CourseController::class, 'lessons']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | Lessons
    |--------------------------------------------------------------------------
    */

    Route::get('/lessons/{id}', [LessonController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | Enrollment
    |--------------------------------------------------------------------------
    */

    Route::post('/enroll', [EnrollmentController::class, 'enroll']);

    Route::get('/my-courses', [EnrollmentController::class, 'myCourses']);

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::get('/notifications', [NotificationController::class, 'index']);

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    /*
    |--------------------------------------------------------------------------
    | Calendar
    |--------------------------------------------------------------------------
    */

    Route::get('/calendar', [CalendarController::class, 'index']);

    Route::post('/calendar', [CalendarController::class, 'create']);

    /*
    |--------------------------------------------------------------------------
    | Tasks
    |--------------------------------------------------------------------------
    */

    Route::get('/tasks', [TaskController::class, 'index']);

    Route::get('/tasks/{id}', [TaskController::class, 'show']);

    Route::post('/tasks/{id}/submit', [TaskController::class, 'submit']);

    /*
    |--------------------------------------------------------------------------
    | Chatbot
    |--------------------------------------------------------------------------
    */

    Route::post('/chat', [ChatController::class, 'sendMessage']);

    Route::get('/chat/history', [ChatController::class, 'history']);

    /*
    |--------------------------------------------------------------------------
    | Assignments
    |--------------------------------------------------------------------------
    */

    Route::post('/assignments/submit', [AssignmentSubmissionController::class, 'submit']);

    /*
    |--------------------------------------------------------------------------
    | Quiz
    |--------------------------------------------------------------------------
    */

    Route::get('/quiz/{id}', [QuizController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | Progress
    |--------------------------------------------------------------------------
    */

    Route::post('/progress/update', [ProgressController::class, 'update']);

    Route::get('/progress', [ProgressController::class, 'myProgress']);
});

Route::get('/announcements', [AnnouncementController::class, 'index']);

Route::get('/activities', [ActivityController::class, 'index']);
Route::post(
    '/upload',
    [UploadController::class, 'upload']
)
    ->middleware('auth:sanctum');


Route::get(
    '/lessons/{id}/download',
    [LessonController::class, 'download']
);


/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return response()->json([
        'message' => 'Route Not Found'
    ], 404);
});