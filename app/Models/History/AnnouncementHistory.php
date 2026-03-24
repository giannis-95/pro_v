<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class AnnouncementHistory extends Model
{
    protected $fillable = [
        'title',
        'message',
        'file'
    ];
}
