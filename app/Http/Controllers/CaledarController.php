<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class CaledarController extends Controller
{
    public function index(){
        return Inertia::render('caledar/index');
    }
}
