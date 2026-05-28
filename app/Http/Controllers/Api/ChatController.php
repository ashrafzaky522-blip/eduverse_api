<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // 🔹 إرسال رسالة للذكاء الاصطناعي
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $user = $request->user();
        $userMessage = $request->message;

        // حفظ رسالة المستخدم
        ChatMessage::create([
            'user_id' => $user->id,
            'sender' => 'user',
            'message' => $userMessage
        ]);

        // ✅ الرد الذكي (في التطبيق الحقيقي نربطه بـ OpenAI API)
        // هنا هنحاكي الرد بشكل مبدئي:
        $botReply = $this->getSmartReply($userMessage);

        // حفظ رد البوت
        ChatMessage::create([
            'user_id' => $user->id,
            'sender' => 'bot',
            'message' => $botReply
        ]);

        return response()->json([
            'reply' => $botReply,
            'message' => 'Response generated successfully.'
        ]);
    }

    // 🔹 استرجاع المحادثة السابقة
    public function history(Request $request)
    {
        $messages = ChatMessage::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // 🔹 رد ذكي بسيط (mock)
    private function getSmartReply($text)
    {
        $text = strtolower($text);

        if (str_contains($text, 'course') || str_contains($text, 'learn')) {
            return "You can explore your available courses in the 'Courses' section 📚";
        }

        if (str_contains($text, 'schedule') || str_contains($text, 'calendar')) {
            return "Here’s your upcoming study schedule 🗓️";
        }

        if (str_contains($text, 'hello') || str_contains($text, 'hi')) {
            return "Hello there! 👋 How can I help you today?";
        }

        return "I’m not sure about that yet 🤔, but I’ll help you find the right answer soon!";
    }
}
