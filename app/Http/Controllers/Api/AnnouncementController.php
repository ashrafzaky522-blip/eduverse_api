<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'announcements' => Announcement::latest()->get()
        ]);
    }
}
