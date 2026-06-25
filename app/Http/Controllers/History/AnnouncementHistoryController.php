<?php

namespace App\Http\Controllers\History;

use App\Exports\History\AnnouncementHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\History\AnnouncementHistory;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AnnouncementHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $announcement_histories = QueryBuilder::for(AnnouncementHistory::query())
            ->allowedFilters(
                AllowedFilter::partial('user'),
                AllowedFilter::partial('course'),
                AllowedFilter::partial('title'),
                AllowedFilter::callback('date_to' ,function($query,$date_to){
                    $query->whereDate('created_at', '<=',$date_to);
                }),
                AllowedFilter::callback('date_from', function($query,$date_from){
                    $query->whereDate('created_at' , '>=' , $date_from);
                }),
                AllowedFilter::exact('status')
            )
            ->paginate(10)
            ->withQueryString();

            $instructor_admins = User::withoutTrashed()->role(['Καθηγητής','Διαχειριστής'])->get();
            $courses = Course::withoutTrashed()->get();

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

    public function export_excel(){
        return Excel::download(new AnnouncementHistoryExport,'announcement_history.xlsx');
    }

    public function export_pdf(){
        $announcement_histories = AnnouncementHistory::all();

        $pdf = Pdf::loadView('pdf.history.announcement-history',compact('announcement_histories'));

        return $pdf->download('announcement_history.pdf');
    }
}
