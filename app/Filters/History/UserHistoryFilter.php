<?php

namespace App\Filters\History;

use Illuminate\Database\Eloquent\Builder;

class UserHistoryFilter{
    protected $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function filterUserHistory(Builder $query){

        $name = $this->request->name;
        $role = $this->request->role;
        $date_to = $this->request->date_to;
        $status = $this->request->status;
        $date_from = $this->request->date_from;
        $status = $this->request->status;

        $query->when($name,
            fn($query) => $query->where('name' , 'LIKE' , "%$name%")
        )->when($date_to,
            fn($query) => $query->where('created_at','>=',$date_to)
        )->when($date_from,
            fn($query) => $query->where('created_at','<=',$date_from)
        )->when($role,
            fn($query) => $query->where('role','=',$role)
        )->when($status,
            fn($query) => $query->where('status','=',$status)
        );
    }
}
