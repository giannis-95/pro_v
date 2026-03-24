<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Course;

class CourseCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('courses'),
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->course->id,
            'title' => $this->course->title,
            'created_at' => $this->course->created_at->toDateTimeString(),
        ];
    }
}
