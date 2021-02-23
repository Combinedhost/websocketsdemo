<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function broadcast(Request $request) {

        event(new NewChatMessage($request->message, $request->user));

        return response()->json([
            'message' => 'Message sent successfully'
        ], 200);
    }

}
