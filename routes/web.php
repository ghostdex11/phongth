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
    Route::group(['prefix' => 'admin/typedevice'], function () {
        Route::GET('/','App\Http\Controllers\typedeviceController@index');

        Route::POST('addtypedevice','App\Http\Controllers\typedeviceController@addtypedevice');
        Route::GET('detailtypedevice/{id}','App\Http\Controllers\typedeviceController@detailTypedevice');
        Route::GET('deletetypedevice/{id}','App\Http\Controllers\typedeviceController@deleteTypedevice');
        Route::POST('edittypedevice','App\Http\Controllers\typedeviceController@edittypedevice');
    });
    Route::group(['prefix' => 'admin/device'], function () {
        Route::GET('/','App\Http\Controllers\diviceController@index');

        Route::POST('adddevice','App\Http\Controllers\diviceController@adddevice');
        Route::GET('detaildevice/{id}','App\Http\Controllers\diviceController@detailDevice');
        Route::GET('deletedevice/{id}','App\Http\Controllers\diviceController@deleteDevice');
        Route::POST('editdevice','App\Http\Controllers\diviceController@editDevice');
    });
});

