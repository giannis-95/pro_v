<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CourseFilter{
    protected $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function filterCourses(Builder $query){
        $title = $this->request->title ?? null;
        $date_from = $this->request->date_from ?? null;
        $date_to = $this->request->date_to ?? null;

        return $query->when($title,
            fn($query) => $query->where('title','LIKE',"%$title%")
        )->when($date_from,
            fn($query) => $query->where('created_at','>=',$date_from)
        )->when($date_to,
            fn($query) => $query->where('created_at','<=',$date_to)
        );
    }
}
