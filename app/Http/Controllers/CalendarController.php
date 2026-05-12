<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Announcement;

class CalendarController extends Controller
{
    public function index(){
        $announcements = Announcement::with(['user','course'])->get();

        return Inertia::render('calendar/index', [
            'announcements' => $announcements
        ]);
    }
}
