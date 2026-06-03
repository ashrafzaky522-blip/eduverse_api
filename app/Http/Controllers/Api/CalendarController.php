<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            CalendarEvent::where('user_id', $request->user()->id)->get()
        );
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'event_date' => 'required|date'
        ]);

        $event = CalendarEvent::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'event_date' => $request->event_date
        ]);

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event
        ]);
    }
}