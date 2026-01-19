<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        $notifications = auth()->user()->notifications()->paginate(20);

        return Inertia::render('Notifications/Index', [
            'title' => 'Ειδοποιήσεις',
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Request $request, $id){
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back();
    }

    public function markAllAsRead(){
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }
}
