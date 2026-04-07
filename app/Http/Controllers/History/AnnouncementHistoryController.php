<?php

namespace App\Http\Controllers\History;

use App\Filters\History\AnnouncementHistoryFilter;
use App\Http\Controllers\Controller;
use App\Models\History\AnnouncementHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Course;

class AnnouncementHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $announcement_history_class = new AnnouncementHistoryFilter($request);

        $announcement_histories = $announcement_history_class->filterAnnouncementHistory(AnnouncementHistory::query())->paginate(10)->withQueryString();
        $instructor_admins = User::withoutTrashed()->role(['Καθηγητής','Διαχειριστής'])->get();
        $courses = Course::withoutTrashed();

        return inertia::render('announcement-histories/index',[
            'announcement_histories' => $announcement_histories,
            'instructor_admins' => $instructor_admins,
            'courses' => $courses
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AnnouncementHistory $announcementHistory)
    {
        return inertia::render('announcement-histories/show',[
            'announcementHistory' => $announcementHistory
        ]);
    }
}
