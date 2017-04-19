<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Riazxrazor\LaravelSweetAlert\LaravelSweetAlert;
use Illuminate\Support\Facades\Auth;
use App\Boot_setting;
use Illuminate\Support\Facades\Storage;

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

    public function version()
     {

        LaravelSweetAlert::setMessageSuccess(trans('home.check'));
        return redirect('/');
     }

    public function link(Request $request)
     {
        $ip = $request -> get('ip');
        $domain = $request -> get('domain');
        $port = $request -> get('port');
        $path = $request -> get('path');

        LaravelSweetAlert::setMessageSuccess(trans($path));
        return redirect('/');
     }

     public function time(Request $request)
     {
        $second = $request -> get('second');

        LaravelSweetAlert::setMessageSuccess(trans($second));
        return redirect('/');
     }
}
