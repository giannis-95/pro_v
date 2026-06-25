<?php

namespace App\Http\Controllers\History;

use App\Exports\History\UserHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\History\UserHistory;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $user_histories  = QueryBuilder::for(UserHistory::query())
            ->allowedFilters(
                AllowedFilter::partial('name'),
                AllowedFilter::callback('date_to', function($query,$date_to){
                    $query->whereDate('created_at', '<=', $date_to);
                }),
                AllowedFilter::callback('date_from' , function($query,$date_from){
                    $query->whereDate('created_at', '>=' ,$date_from);
                }),
                AllowedFilter::exact('role'),
                AllowedFilter::exact('status')
            )
            ->paginate(10)
            ->withQueryString();

        return inertia::render('user-histories/index',[
            'user_histories' => $user_histories
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserHistory $userHistory)
    {
        return inertia::render('user-histories/show',[
            'user_history' => $userHistory
        ]);
    }

    public function export_excel(){
        return Excel::download(new UserHistoryExport(),'users-history.xls');
    }

    public function export_pdf(){
        $user_histories = UserHistory::all();
        $pdf = Pdf::loadView('pdf.history.user-history',compact('user_histories'));
        return $pdf->download('user-history.pdf');
    }
}
