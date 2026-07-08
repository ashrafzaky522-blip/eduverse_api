<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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

        $sessionId = Str::uuid()->toString();

        try {

            $response = Http::timeout(90)
                ->acceptJson()
                ->post(env('AI_SERVER_URL') . '/chat', [

                    "student_id" => (string) $request->user()->id,

                    "message" => $request->message,

                    "course_id" => "GENERAL",

                    "session_id" => $sessionId

                ]);

            if (!$response->successful()) {

                return response()->json([
                    "success" => false,
                    "error" => $response->body()
                ], 500);

            }

            $data = $response->json();

            $botReply = $data['reply'];

        } catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ], 500);

        }


        return response()->json([
            'student_id' => $request->user()->id,
            'name' => $request->user()->name,
            'role' => $request->user()->role,
        ]);

        // حفظ رد الـ AI
        ChatMessage::create([
            'user_id' => $request->user()->id,
            'sender' => 'bot',
            'message' => $botReply
        ]);

        return response()->json([

            "success" => true,

            "session_id" => $sessionId,

            "reply" => $botReply

        ]);
    }

    public function history(Request $request)
    {
        return response()->json([

            "success" => true,

            "messages" => ChatMessage::where('user_id', $request->user()->id)
                ->orderBy('created_at')
                ->get()

        ]);
    }
}