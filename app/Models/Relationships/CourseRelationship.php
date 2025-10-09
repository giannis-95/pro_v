<?php

namespace App\Models\Relationships;

use App\Models\User;

trait CourseRelationship{
    public function users(){
        return $this->belongsToMany(User::class);
    }
}

