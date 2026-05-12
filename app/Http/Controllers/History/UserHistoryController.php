<?php

namespace App\Http\Controllers\History;

use App\Exports\History\UserHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\History\UserHistory;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Filters\History\UserHistoryFilter;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UserHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_history_class = new UserHistoryFilter($request);

        $user_histories = $user_history_class->filterUserHistory(UserHistory::query())->paginate(10)->withQueryString();

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
