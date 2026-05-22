<?php

namespace App\Notifications\Courses;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CourseCreatedNotification extends Notification implements ShouldQueue
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

    public function toDatabase(): array
    {
        return [
            'title' => $this->courseTitle,
            "message" => 'Νέο Μάθημα',
            'created_at' => now()->toDateTimeString(),
        ];
    }

    public function toBroadcast()
    {
        return new BroadcastMessage([
            'title' => $this->courseTitle,
            "message" => 'Νέο Μάθημα',
            'created_at' => now()->toDateTimeString(),
        ]);
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
     public function via()
    {
        return ['database', 'broadcast'];
    }
}
