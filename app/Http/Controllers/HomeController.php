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
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        return view('home', compact('setting','config'));
        }
        else {return view('welcome');}
    }

    public function version()
     {

        LaravelSweetAlert::setMessageSuccess(trans('home.check'));
        return redirect('/');
     }

     public function getlink()
     {
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        return view('server.link', compact('config'));
     }

     public function gettime()
     {
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        return view('server.time', compact('config'));
     }

    public function link(Request $request)
     {
        $ip = $request -> get('ip');
        $domain = $request -> get('domain');
        $port = $request -> get('port');
        $path = $request -> get('path');
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        $config['ip'] = $ip;
        $config['domain'] = $domain;
        $config['port'] = $port;
        $config['path'] = $path;
        $config = json_encode($config, true);
        Storage::delete('config.json');
        Storage::put('config.json', $config);
        LaravelSweetAlert::setMessageSuccess(trans('home.config_server_successful'));
        return redirect('/');
     }

     public function time(Request $request)
     {
        $gap = $request -> get('gap');
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        $config['gap']=$gap;
        $config = json_encode($config, true);
        Storage::delete('config.json');
        Storage::put('config.json', $config);
        LaravelSweetAlert::setMessageSuccess(trans('home.config_gap_successful'));
        return redirect('/');
     }
}
