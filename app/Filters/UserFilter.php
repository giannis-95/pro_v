<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserFilter{
    protected $request;

    public function __construct(Request $request){
       $this->request = $request;
    }

    public function apply(Builder $query){
        $name = $this->request->name;
        $role = $this->request->role;
        $date_from = $this->request->date_from;
        $date_to = $this->request->date_to;

        return $query->when($name,
                fn($query) => $query->where('name' ,'like' ,"%$name%")
            )->when($role,
                fn($query) => $query->whereHas('roles', fn($query) =>
                    $query->where('name',$role))
            )->when($date_from,
                fn($query) => $query->where('created_at', '>=', $date_from)
            )->when($date_to,
                fn($query) => $query->where('created_at', '<=', $date_to)
            );
    }
}
