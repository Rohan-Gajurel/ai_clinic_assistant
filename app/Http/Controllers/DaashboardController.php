<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaashboardController extends Controller
{
    //
    public static function index(){
        return view('backend.dashboard');
    }

    public function calender(){
        return view('backend.calendar');
    }
}
