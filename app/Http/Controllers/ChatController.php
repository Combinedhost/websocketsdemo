<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function broadcast(Request $request)
    {
        try {
            event(new NewChatMessage($request->message, auth()->user()));

            return response()->json([
                'message' => 'Message sent successfully'
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Some error occurred'
            ], 500);
        }

    }

}
