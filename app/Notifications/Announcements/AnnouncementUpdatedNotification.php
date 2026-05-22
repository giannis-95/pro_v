<?php

namespace App\Notifications\Announcements;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AnnouncementUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $announcementTitle;

    public function __construct($announcement)
    {
        $this->announcementTitle = $announcement->title;
    }

    public function toBroadcast(){
        return new BroadcastMessage([
            'title' => $this->announcementTitle,
            'message' => 'Ενημερώθηκε η ανακοίνωση',
            'created_at' => now()->toDateTimeString()
        ]);
    }

    public function toDatabase(){
        return[
            'title' => $this->announcementTitle,
            'message' => 'Ενημερώθηκε η ανακοίνωση',
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
