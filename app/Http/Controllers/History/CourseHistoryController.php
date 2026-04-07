<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use App\Models\History\CourseHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Filters\History\CourseHistoryFilter;

class CourseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $course_history_class = new CourseHistoryFilter($request);

        $course_histories = $course_history_class->filterCourseHistory(CourseHistory::query())->paginate(8)->withQueryString();

        return inertia::render('course-histories/index',[
            'course_histories' => $course_histories
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseHistory $courseHistory)
    {
        return Inertia::render('course-histories/show',[
            'course_history' => $courseHistory
        ]);
    }
}
