<?php

namespace App\Models\Relationships;

use App\Models\User;
use App\Models\Course;

trait AnnouncementRelationship{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
