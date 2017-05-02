<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Riazxrazor\LaravelSweetAlert\LaravelSweetAlert;

class NetworkController extends Controller
{
    public function dhcp(Request $request)
    {
        $dns = $request -> get('dns');
        //資料夾路徑
        $python_dir=env("PYTHON_DIR", "/var/www/html/python");
        //驗證程式檔名
        $network=env("PYTHON_NETWORK", "network.py");
        //輸出
        $output = array();
        //執行驗證程式
        exec("echo '' | sudo -S python3 '{$python_dir}'/'{$network}'  dhcp '{$dns}' ", $output);
        $output=last($output);
        //開發環境跳過驗證設定
        if(env('APP_ENV', 'production') == 'local')
        {$output = 'done';}
        if($output == 'done')
            {   
            LaravelSweetAlert::setMessageSuccess(trans("network.sucess"));
        }
        else{
            LaravelSweetAlert::setMessageError(trans("network.error"));
        }
        return redirect('/');
    }

    public function wifi(Request $request)
    {
        $name = $request -> get('wifiname');
        $password = $request -> get('wifipassword');
        //資料夾路徑
        $python_dir=env("PYTHON_DIR", "/var/www/html/web/python");
        //驗證程式檔名
        $network=env("PYTHON_NETWORK", "network.py");
        //輸出
        $output = array();
        //執行驗證程式
        exec("echo '' | sudo -S python3 '{$python_dir}'/'{$network}'  wifi '{$name}' '{$password}' ", $output);
        $output=last($output);
        //開發環境跳過驗證設定
        if(env('APP_ENV', 'production') == 'local')
        {$output = 'done';}
        if($output == 'done')
            {
            LaravelSweetAlert::setMessageSuccess(trans("network.success"));
        }
        else{
            LaravelSweetAlert::setMessageError(trans("network.error"));
        }
        return redirect('/');
    }

    public function staticip(Request $request)
    {
        $wan = $request -> get('wan');
        $dns = $request -> get('dns');
        $gateway = $request -> get('gateway');
        $mask = $request -> get('mask');
        //資料夾路徑
        $python_dir=env("PYTHON_DIR", "/var/www/html/web/python");
        //驗證程式檔名
        $network=env("PYTHON_NETWORK", "network.py");
        //輸出
        $output = array();
        //執行驗證程式
        exec("echo '' | sudo -S python3 '{$python_dir}'/'{$network}'  staicip '{$wan}' '{$dns}' '{$gateway}' '{$mask}' ", $output);
        $output=last($output);
        //開發環境跳過驗證設定
        if(env('APP_ENV', 'production') == 'local')
        {$output = 'done';}
        if($output == 'done')
            {
            LaravelSweetAlert::setMessageSuccess(trans("network.error"));
        }
        else{
            LaravelSweetAlert::setMessageError(trans("network.error"));
        }
        return redirect('/');
    }
}
