<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relationships\MessageRelationship;

class Message extends Model
{
    use MessageRelationship;

    protected $fillable = [
        'text'
    ];
}
