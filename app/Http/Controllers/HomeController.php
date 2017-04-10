<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Boot_setting;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) 
        {
        $settings = Boot_setting::orderBy('circuit','ASC');
        return view('home',compact('settings'));
        }
        else {return view('welcome');}
    }
}
