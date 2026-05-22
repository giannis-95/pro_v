<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $userName;

    public function __construct($user)
    {
        $this->userName = $user->name;
    }

    public function toBroadcast(){
        return new BroadcastMessage([
            'title' => $this->userName,
            'message' => 'Ενημερώθηκε ο χρήστης',
            'created_at' => now()->toDateTimeString(),
        ]);
    }

    public function toDatabase(){
        return[
            'title' => $this->userName,
            'message' => 'Ενημερώθηκε ο χρήστης',
            'created_at' => now()->toDateTimeString()
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['database','broadcast'];
    }
}
