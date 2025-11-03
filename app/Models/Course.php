<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relationships\CourseRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use CourseRelationship,SoftDeletes;

    protected $fillable = [
        'title',
        'image',
        'description'
    ];
}
