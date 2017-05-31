<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'OverViewController@OverView');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
Route::get('/note', function () {
    return view('note');
});

Route::get('/console', function () {
    return view('console');
});

Route::get('/other', function () {
    return view('other');
});

Route::get('/timeperiod', function () {
    return view('timeperiod');
});

Route::post('/getList','OverViewController@getList');
Route::get('/filter',function(){
	return view('filter');
});

Route::get('/change', 'OverViewController@change');
Route::get('/company', function () {
    return view('company');
});

Route::get('/test','TestController@test');

//Route::get('/',function(){
//	return view('pause');
//});