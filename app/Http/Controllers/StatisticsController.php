<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Course;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index(){
       $users = User::selectRaw('DATE(created_at) as date, COUNT(*) AS total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return inertia::render('statistics/index',[
            'dates' => $users->pluck('date'),
            'totals' => $users->pluck('total'),
        ]);
    }

    public function courses(){
        $courses = Course::selectRaw('DATE(created_at) as date, COUNT(*) AS total')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

        return Inertia::render('statistics/courses',[
            'dates' => $courses->pluck('date'),
            'totals' => $courses->pluck('total')
        ]);
    }

    public function my_courses(){
        $courses = Course::query()
            ->whereHas('users', function ($query) {
                $query->where('users.id', Auth::id());
            })
            ->selectRaw('DATE(courses.created_at) as date, COUNT(courses.id) as total')
            ->groupByRaw('date')
            ->orderByRaw('date')
            ->get();

        return Inertia::render('statistics/my-courses',[
            'dates' => $courses->pluck('date'),
            'totals' => $courses->pluck('total')
        ]);
    }

    public function announcements(){
        $announcements = Announcement::selectRaw('DATE(created_at) as date, COUNT(*) AS total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return Inertia::render('statistics/announcements',[
            'dates' => $announcements->pluck('date'),
            'totals' => $announcements->pluck('total')
        ]);
    }
}
