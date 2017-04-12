<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//支援auth
use Illuminate\Support\Facades\Auth;
use App\Boot_setting;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) 
        {
        $setting= Boot_setting::orderBy('circuit','ASC')->get();
        return view('home', compact('setting'));
        }
        else {return view('welcome');}
    }
}
