<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;

class CalendarController extends Controller
{
    public function index()
    {
        return response()->json(CalendarEvent::all());
    }
    public function create(Request $request)
    {
        $calendar = CalendarEvent::create([
            'title' => $request->title,
            'event_date' => $request->event_date
        ]);

        return response()->json($calendar);
    }
}
