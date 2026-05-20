<?php

namespace App\Models\Relationships;

use App\Models\User;

trait MessageRelationship{
    public function user(){
        return $this->belongsTo(User::class);
    }
}
