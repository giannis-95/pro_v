<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserFilter
{
    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function apply(Builder $query): Builder
    {
        $name = $this->request->name;
        $role = $this->request->role;
        $from = $this->request->from_date;
        $to = $this->request->to_date;

        return $query->when($name,
                fn($query) => $query->where('name', 'like', "%{$name}%")
            )
            ->when($role,
                fn($query) => $query->whereHas('roles', fn($query) => $query->where('name', $role))
            )
            ->when($from,
                fn($query) => $query->whereDate('created_at', '>=', $from)
            )
            ->when($to,
                fn($query) => $query->whereDate('created_at', '<=', $to)
            );
    }

}
