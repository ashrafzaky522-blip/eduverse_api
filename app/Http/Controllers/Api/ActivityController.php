<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityRegistration;

class ActivityController extends Controller
{
    public function index()
    {
        return response()->json(
            Activity::orderBy('event_date')->get()
        );
    }

    public function register($id)
    {
        $activity = Activity::findOrFail($id);

        ActivityRegistration::firstOrCreate([
            'activity_id' => $activity->id,
            'user_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Registered successfully'
        ]);
    }
}
