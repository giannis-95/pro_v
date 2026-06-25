<?php

namespace App\Http\Controllers\History;

use App\Exports\History\CourseHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\History\CourseHistory;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CourseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $course_histories = QueryBuilder::for(CourseHistory::query())
            ->allowedFilters(
                AllowedFilter::partial('title'),
                AllowedFilter::callback('date_to', function($query,$date_to){
                    $query->whereDate('created_at' ,'>=' , $date_to);
                }),
                AllowedFilter::callback('date_from' , function($query,$date_from){
                    $query->whereDate('created_at' ,'<=' , $date_from);
                }),
                AllowedFilter::exact('status')
            )
            ->paginate(12)
            ->withQueryString();

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
