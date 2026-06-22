<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        // حفظ رسالة المستخدم
        ChatMessage::create([
            'user_id' => $request->user()->id,
            'sender' => 'user',
            'message' => $request->message
        ]);

        // رد البوت
        $botReply = $this->getSmartReply($request->message);

        // حفظ رد البوت
        ChatMessage::create([
            'user_id' => $request->user()->id,
            'sender' => 'bot',
            'message' => $botReply
        ]);

        return response()->json([
            'success' => true,
            'reply' => $botReply
        ]);
    }

    public function history(Request $request)
    {
        return response()->json(
            ChatMessage::where('user_id', $request->user()->id)
                ->orderBy('created_at')
                ->get()
        );
    }

    private function getSmartReply($message)
    {
        $message = strtolower($message);

        if (str_contains($message, 'hello')) {
            return 'Hello! How can I help you?';
        }

        if (str_contains($message, 'course')) {
            return 'You can view your courses from My Courses page.';
        }

        if (str_contains($message, 'assignment')) {
            return 'Please check the assignments section.';
        }

        return 'I understand your question. Please provide more details.';
    }
}