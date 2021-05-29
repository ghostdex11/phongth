<?php

use Illuminate\Support\Facades\Route;

Route::get('login','App\Http\Controllers\LoginController@getdangnhapAdmin');
Route::post('login','App\Http\Controllers\LoginController@postdangnhapAdmin');
Route::get('logout','App\Http\Controllers\LoginController@getdangxuatAdmin');
Route::get('register','App\Http\Controllers\LoginController@getDangky');
Route::post('register','App\Http\Controllers\LoginController@postDangky');
Route::get('admin/logout','App\Http\Controllers\LoginController@getdangxuatAdmin');
Route::get('/home','App\Http\Controllers\userController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'adminCheck'], function () {
    Route::get('/',function(){
		return view('admin.layouts.index');
	});
	Route::group(['prefix' => 'zone'], function () {
		Route::GET('/','App\Http\Controllers\zoneController@index');
		Route::POST('addzone','App\Http\Controllers\zoneController@addZone');
		Route::GET('detailzone/{id}','App\Http\Controllers\zoneController@detailZone');
		Route::GET('deletezone/{id}','App\Http\Controllers\zoneController@deleteZone');
		Route::POST('editzone','App\Http\Controllers\zoneController@editZone');
	});
});

