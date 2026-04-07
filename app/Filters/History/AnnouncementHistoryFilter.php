<?php

namespace App\Filters\History;

use Illuminate\Database\Eloquent\Builder;

class AnnouncementHistoryFilter{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function filterAnnouncementHistory(Builder $query){
        $user = $this->request->user;
        $course = $this->request->course;
        $title = $this->request->title;
        $date_to = $this->request->date_to;
        $date_from = $this->request->date_from;
        $status = $this->request->status;

        return $query->when($user,
            fn($query) => $query->where('user','LIKE',"%$user%")
        )->when($course,
            fn($query) => $query->where('course','LIKE',"%$course%")
        )->when($title,
            fn($query) => $query->where('title','LIKE',"%$title%")
        )->when($date_to,
            fn($query) => $query->where('created_at','<=',"%$date_to%")
        )->when($status,
            fn($query) => $query->where('created_at','>=',"%$status%")
        )->when($status,
            fn($query) => $query->where('status','=',"%$status%")
        );
    }
}
