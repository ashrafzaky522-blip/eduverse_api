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
            'title' => 'required',
            'event_date' => 'required|date',
            'time' => 'nullable',
            'location' => 'nullable|string'
        ]);

        $event = CalendarEvent::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'event_date' => $request->event_date,
            'time' => $request->time,
            'location' => $request->location
        ]);

        return response()->json($event);
    }
}