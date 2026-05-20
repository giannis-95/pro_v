<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\Messages\StoreMessageRequest;

class MessageController extends Controller
{
    public function index(){
        return Inertia::render('messages/index', [
            'messages' => Message::with('user')->latest()->get()
        ]);
    }

    public function store(StoreMessageRequest $request){
        $data = $request->validated();

        $message = Message::create([
            'text' => $data['text'],
            'user_id' => Auth::id()
        ]);

        $message->load('user');

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
