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
        $setting= Boot_setting::orderBy('address','ASC')->get();
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        return view('home', compact('setting','config'));
        }
        else {return view('welcome');}
    }

    public function version()
     {
         /**輸入版本判斷邏輯

         */
        LaravelSweetAlert::setMessage([
                        'title' => trans('server.latest_version'),
                        'type' => 'info',
                        'showConfirmButton' =>false
                    ]);
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
        $this->validate($request, [
            'ip' => 'ip',
            'domain' => 'url',
            'port' => 'integer',
            'path' => 'string',
            'key' => 'string|confirmed',      
    ]);
        $ip = $request -> get('ip');
        $domain = $request -> get('domain');
        $port = $request -> get('port');
        $path = $request -> get('path');
        $key = $request -> get('key');
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        $config['ip'] = $ip;
        $config['domain'] = $domain;
        $config['port'] = $port;
        $config['path'] = $path;
        $config['key'] = $key;
        $config = json_encode($config, true);
        Storage::delete('config.json');
        Storage::put('config.json', $config);
        LaravelSweetAlert::setMessageSuccess(trans('server.config_server_successful'));
        return redirect('/');
     }

     public function time(Request $request)
     {
        $this->validate($request, [
            'record_gap' => 'required|integer',
            'config_gap' => 'required|integer',
        ]);
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        $config['record_gap']=$request -> get('record_gap');
        $config['config_gap']=$request -> get('config_gap');
        if( $request->has('run') )
            {
        $config['isRUN']= true;
        }
        else {
        $config['isRUN']= false;
        }
        $config = json_encode($config, true);
        Storage::delete('config.json');
        Storage::put('config.json', $config);
        LaravelSweetAlert::setMessageSuccess(trans('server.config_server_successful'));
        return redirect('/');
     }
}
