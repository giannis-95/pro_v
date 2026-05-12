<?php

namespace App\Notifications\Courses;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CourseDeletedNotification extends Notification implements ShouldQueue
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

    public function toDatabase() :array
    {
        return[
            'message' => "Διαγράφηκε το μάθημα ",
            'title' => $this->courseTitle,
            'created_at' => now()->toDateTimeString()
        ];
    }

    public function toBroadcast()
    {
       return new BroadcastMessage([
            'message' => "Διαγράφηκε το μάθημα ",
            'title' => $this->courseTitle,
            'created_at' => now()->toDateTimeString()
       ]);
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
