<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index(){
        $notifications = auth()->user()->unreadNotifications()->latest()->paginate(10);

        return inertia::render('notifications/index',[
            'notifications' => $notifications
        ]);
    }

    public function send(){
        return auth()->user()->unreadNotifications()->latest()->get();
    }

    public function mark_as_read($id){
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if($notification){
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    public function mark_all_as_read(){
        // auth()->user()->unreadNotifications->markAsRead();

        // return back();
    }

    public function destroy($id){
        $notification = auth()->user()->notifications()->where('id',$id)->firstOrFail();
        $notification->delete();
        return redirect()->back()->withSuccess('Η ειδοποιήση διαγράφηκε με επιτυχία.');
    }
}
