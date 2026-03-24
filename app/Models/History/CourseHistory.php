<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class CourseHistory extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description'
    ];
}
