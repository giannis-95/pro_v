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
            'messages' => Message::with('user')->orderBy('created_at')->get()
        ]);
    }

    public function store(StoreMessageRequest $request){
        $data = $request->validated();
        $user =  Auth::id();

        $message = new Message([
            'text' => $data['text']
        ]);

        $message->user()->associate($user);
        $message->save();
        $message->load('user');

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
