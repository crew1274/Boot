<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'HomeController@index');

//更新檢查
Route::get('/version', 'HomeController@version');

//開機設定路徑
Route::resource('boot','BootController');

Route::get('/type',['uses' =>'ApiController@type','as'=>'type']);

//更換語系路徑
Route::get('lang/{lang}', ['as'=>'lang.switch', 'uses'=>'LanguageController@switchLang']);

//網路設定路徑
Route::group(['prefix' => 'network'], function () {
    //wifi
    Route::post('wifi', ['as' => 'network/wifi', 'uses' => 'NetworkController@wifi']);
    //固定ip
    Route::post('staticip', ['as' => 'network/staticip', 'uses' => 'NetworkController@staticip']);
    //DHCP
    Route::post('dhcp', ['as' => 'network/dhcp', 'uses' => 'NetworkController@dhcp']);
    Route::get('/', 'NetworkController@index');
});
//server ip & domain update
Route::get('/link', 'HomeController@getlink');
Route::get('/time', 'HomeController@gettime');
Route::post('link', ['as' => 'link', 'uses' => 'HomeController@link']);
Route::post('time', ['as' => 'time', 'uses' => 'HomeController@time']);
//測試路徑
Route::get('test', function(){return view('test'); });