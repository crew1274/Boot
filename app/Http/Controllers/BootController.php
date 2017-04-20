<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Storage;
use App\Boot_setting;
use App\Code;

use Riazxrazor\LaravelSweetAlert\LaravelSweetAlert;

class BootController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = Boot_setting::orderBy('circuit','ASC');
        return view('boot.index',compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models= Code::pluck('model', 'model');
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        return view('boot.create',compact('models','config'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'bail|required|string',
            'address' => 'bail|required|integer|min:1|max:255',
            'ch' => 'bail|required|integer|min:1|max:15',
            'speed' => 'bail|required|integer',
            'circuit' => 'bail|required|integer|min:1|max:72|unique:boot_settings,circuit',
        ]);
        Boot_Setting::create($request->all());
        LaravelSweetAlert::setMessageSuccess(trans('boot.create_success'));
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = Boot_setting::find($id);
        $setting_id= $setting->id;
        $output = array();
        //資料夾路徑
        $python_dir=env("PYTHON_DIR", "~/work/");
        //驗證程式檔名
        $vaild=env("PYTHON_VAILD", "vaild.py");
        //執行驗證程式
        exec("python3 '{$python_dir}''{$vaild}' '{$setting_id}' ", $output);
        $output=last($output);

        //開發環境跳過驗證設定
        if(env('APP_ENV', 'production') == 'local')
        {$output = 'done';}

        if($output == 'done')
        {
        $setting = Boot_setting::find($id);
        $setting -> vaild = '1';
        $setting-> save();
        LaravelSweetAlert::setMessageSuccess(trans('boot.valid_success'));
        }
        else{
            LaravelSweetAlert::setMessageError("boot.valid_error");
        }
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $models= Code::pluck('model', 'model');
        $setting = Boot_setting::find($id);
        $config = Storage::get('config.json');
        $config = json_decode($config, true);
        return view('boot.edit',compact('setting','models','config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
         'model' => 'bail|required',
         'address' => 'bail|required|integer|min:1|max:255',
         'ch' => 'bail|required|integer|min:1|max:15',
         'speed' => 'bail|required',
         'circuit' => 'bail|required|integer|min:1|max:72|unique:boot_settings,circuit,'.$id,
       ]);
       Boot_setting::find($id)->update($request->all());
       $token = Boot_setting::find($id);
       $token-> vaild = '0';
       $token -> save();
       LaravelSweetAlert::setMessageSuccess(trans('boot.edit_success'));
       return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Boot_setting::find($id)->delete();
        LaravelSweetAlert::setMessageSuccess(trans('boot.delete_success'));
        return redirect('/');
    }
}
