<?php

namespace App\Notifications\Courses;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CourseFinalDeletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $courseTitle;

    public function __construct($course)
    {
        $this->courseTitle = $course->title;
    }

    public function toBroadcast(){
        return new BroadcastMessage([
            'title' => $this->courseTitle,
            'message' => 'Το μάθημα διαγράφηκε οριστικά',
            'created_at' => now()->toDateTimeString()
        ]);
    }

    public function toDatabase(){
        return[
            'title' => $this->courseTitle,
            'message' => 'Το μάθημα διαγράφηκε οριστικά',
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
