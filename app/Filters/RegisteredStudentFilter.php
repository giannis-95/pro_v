<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RegisteredStudentFilter{
    protected $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function filterRegisteredStudents(Builder|BelongsToMany $query){
        $name = $this->request->name ?? null;
        $email = $this->request->email ?? null;
        $date_from = $this->request->date_from ?? null;
        $date_to = $this->request->date_to ?? null;

        return $query->when($name,
            fn($query) => $query->where('name','LIKE',"%$name%")
        )->when($email,
            fn($query) => $query->where('email','LIKE',"%$email%")
        )->when($date_from,
            fn($query) => $query->where('created_at','>=',$date_from)
        )->when($date_to,
            fn($query) => $query->where('created_at','<=',$date_to)
        );
    }
}
