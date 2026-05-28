<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Notification::where('user_id', $request->user()->id)->get()
        );
    }
    public function create(Request $request)
    {
        $notification = Notification::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'message' => $request->message,
            'is_read' => false
        ]);
        return response()->json($notification);

    }
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update([
            'is_read' => true
        ]);
        return response()->json([
            'message' => 'Notification marked as read'
        ]);
    }
}