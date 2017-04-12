<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use App\Boot_setting;
use App\Code;

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
        return view('boot.create',compact('models'));
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
        return redirect('/')->with('success','設定新增成功!');
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
        $setting_id= $setting -> id ;
        $output = array();
        //驗證程式的資料夾路徑
        $python_dir=env("PYTHON_DIR", "~/work/");
        //驗證程式的檔名
        $vaild=env("PYTHON_VAILD", "vaild.py");
        //執行驗證程式
        exec("python3 '{$python_dir}''{$vaild}' '{$setting_id}' ", $output);
        $output=last($output);
        return redirect('/')->with('success',$output);
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
        return view('boot.edit',compact('setting','models'));
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
       return redirect('/')->with('success','開機設定已更新!');
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
        return redirect('/')->with('success','開機設定已刪除!');
    }
}
