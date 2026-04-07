<?php

namespace App\Filters\History;

use Illuminate\Database\Eloquent\Builder;

class CourseHistoryFilter{
    protected $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function filterCourseHistory(Builder $query){
        $title = $this->request->title ?? null;
        $date_to = $this->request->date_to ?? null;
        $date_from = $this->request->date_from ?? null;
        $status = $this->request->status ?? null;

        return $query->when($title,
            fn($query) => $query->where('title','LIKE',"%$title%")
        )->when($date_to,
            fn($query) => $query->where('created_at' , '<=', $date_to)
        )->when($date_from,
            fn($query) => $query->where('created_at' , '>=', $date_from)
        )->when($status,
            fn($query) => $query->where('status' , '=', $status)
        );
    }
}
