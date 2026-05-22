<?php

namespace App\Notifications\Courses;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseRestoreNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $courseTile;

    public function __construct($course)
    {
        $this->courseTile = $course->title;
    }

    public function toBroadcast()
    {
        return new BroadcastMessage([
            'title' => $this->courseTile,
            'message' => 'Εγινε επαναφορα του μαθήματος',
            'created_at' => now()->toDateTimeString()
        ]);
    }

    public function toDatabase(){
        return[
            'title' => $this->courseTile,
            'message' => 'Εγινε επαναφορα του μαθήματος',
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
