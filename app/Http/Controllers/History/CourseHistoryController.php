<?php

namespace App\Http\Controllers\History;

use App\Exports\History\CourseHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\History\CourseHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Filters\History\CourseHistoryFilter;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class CourseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $course_history_class = new CourseHistoryFilter($request);

        $course_histories = $course_history_class->filterCourseHistory(CourseHistory::query())->paginate(12)->withQueryString();

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

    public function export_excel(){
        return Excel::download(new CourseHistoryExport,'course-histories.xlsx');
    }

    public function export_pdf(){
        $course_histories = CourseHistory::all();

        $pdf = Pdf::loadView('pdf.history.course-history',compact('course_histories'));
        return $pdf->download('course-histories.pdf');
    }
}
