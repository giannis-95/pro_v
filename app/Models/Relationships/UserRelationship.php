<?php

namespace App\Models\Relationships;

use App\Models\Course;

trait UserRelationship{
    public function courses(){
        return $this->belongsToMany(Course::class);
    }
}

