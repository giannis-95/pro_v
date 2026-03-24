<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $fillable = [
        'name',
        'email',
        'role',
        'status'
    ];
}
