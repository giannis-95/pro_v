<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Relationships\AnnouncementRelationship;

class Announcement extends Model
{
    use AnnouncementRelationship;

    protected $fillable = [
        'title',
        'message',
        'file'
    ];
}
