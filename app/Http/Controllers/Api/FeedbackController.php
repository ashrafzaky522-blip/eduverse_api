<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{

    public function send(Request $request)
    {

        $request->validate([

            'receiver_id' => 'required|exists:users,id',

            'message' => 'required'

        ]);

        $feedback = Feedback::create([

            'sender_id' => $request->user()->id,

            'receiver_id' => $request->receiver_id,

            'message' => $request->message,

            'type' => 'feedback'

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Feedback sent successfully',

            'feedback' => $feedback

        ]);

    }

}