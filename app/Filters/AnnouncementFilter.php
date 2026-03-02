<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AnnouncementFilter{
    protected $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function filterAnnouncement(Builder $query){
        $title = $this->request->title;
        $course = $this->request->course;
        $user = $this->request->user;
        $date_form = $this->request->date_from;
        $date_to = $this->request->date_to;

        return $query->when($title,
                fn($query) => $query->where('title', 'LIKE',"%$title%")
            )->when($date_form,
                fn($query) => $query->where('created_at', '>=', $date_form)
            )->when($date_to,
                fn($query) => $query->where('created_at', '<=', $date_to)
            )->when($course,
                fn($query) => $query->whereHas('course', function($query) use ($course){
                    $query->where('id',$course);
                })
            )->when($user,
                fn($query) => $query->whereHas('user', function ($query) use ($user){
                    $query->where('id',$user);
                })
            );
    }
}
