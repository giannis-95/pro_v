<?php

namespace App\Models\Relationships;

use App\Models\Course;
use App\Models\Message;

trait UserRelationship{
    public function courses(){
        return $this->belongsToMany(Course::class);
    }

    public function messages(){
        return $this->belongsToMany(Message::class);
    }
}

