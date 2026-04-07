<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use App\Models\History\UserHistory;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Filters\History\UserHistoryFilter;

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
}
