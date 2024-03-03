<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('lol',function(){
    return 'hello';
});


Route::prefix('admin')->namespace('API')->group(function(){
    Route::get('/login',"AdminController@login");
    Route::get('/get',"AdminController@getAllAdmin");
    Route::post('/save',"AdminController@save");
    Route::get('/edit/{id}','AdminController@show');
    Route::post('/update/{id}','AdminController@update');
    Route::delete('/delete/{id}','AdminController@delete');
});

Route::prefix('employee')->namespace('API')->group(function(){
    Route::get('/get',"EmployeeController@getAllEmployee");
    Route::post('/save',"EmployeeController@save");
    Route::get('/edit/{id}','EmployeeController@show');
    Route::post('/update/{id}','EmployeeController@update');
    Route::delete('/delete/{id}','EmployeeController@delete');
    Route::get('/search',"EmployeeController@search");
});

