<?php

use Illuminate\Support\Facades\Route;

Route::get('login','App\Http\Controllers\LoginController@getdangnhapAdmin');
Route::post('login','App\Http\Controllers\LoginController@postdangnhapAdmin');
Route::get('logout','App\Http\Controllers\LoginController@getdangxuatAdmin');
Route::get('register','App\Http\Controllers\LoginController@getDangky');
Route::post('register','App\Http\Controllers\LoginController@postDangky');
Route::get('admin/logout','App\Http\Controllers\LoginController@getdangxuatAdmin');
// Route::get('/','App\Http\Controllers\pageController@index');

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
    Route::group(['prefix' => 'room'], function () {
        Route::GET('/','App\Http\Controllers\roomController@index');
        Route::POST('addroom','App\Http\Controllers\roomController@addRoom');
        Route::GET('detailroom/{id}','App\Http\Controllers\roomController@detailRoom');
        Route::GET('deleteroom/{id}','App\Http\Controllers\roomController@deleteRoom');
        Route::POST('editroom','App\Http\Controllers\roomController@editRoom');
    });
    Route::group(['prefix' => 'typedevice'], function () {
        Route::GET('/','App\Http\Controllers\typedeviceController@index');
        Route::POST('addtypedevice','App\Http\Controllers\typedeviceController@addtypedevice');
        Route::GET('detailtypedevice/{id}','App\Http\Controllers\typedeviceController@detailTypedevice');
        Route::GET('deletetypedevice/{id}','App\Http\Controllers\typedeviceController@deleteTypedevice');
        Route::POST('edittypedevice','App\Http\Controllers\typedeviceController@edittypedevice');
    });
    Route::group(['prefix' => 'device'], function () {
        Route::GET('/','App\Http\Controllers\deviceController@index');
        Route::POST('adddevice','App\Http\Controllers\deviceController@adddevice');
        Route::GET('detaildevice/{id}','App\Http\Controllers\deviceController@detailDevice');
        Route::GET('deletedevice/{id}','App\Http\Controllers\deviceController@deleteDevice');
        Route::POST('editdevice','App\Http\Controllers\deviceController@editDevice');
    });
    Route::group(['prefix' => 'computer'], function () {
        Route::GET('/','App\Http\Controllers\computerController@index');
        Route::POST('addcomputer','App\Http\Controllers\computerController@addComputer');
        Route::GET('detailcomputer/{id}','App\Http\Controllers\computerController@detailComputer');
        Route::GET('deletecomputer/{id}','App\Http\Controllers\computerController@deleteComputer');
        Route::POST('editcomputer','App\Http\Controllers\computerController@editComputer');
    });
    Route::group(['prefix' => 'user'], function () {
        Route::GET('/','App\Http\Controllers\userController@index');
        Route::POST('adduser','App\Http\Controllers\userController@adduser');
        Route::GET('detailuser/{id}','App\Http\Controllers\userController@detailUser');
        Route::GET('deleteuser/{id}','App\Http\Controllers\userController@deleteUser');
        Route::POST('edituser','App\Http\Controllers\userController@editUser');
    });
    Route::group(['prefix' => 'history'], function () {
        Route::GET('/','App\Http\Controllers\historyController@index');
        Route::GET('detailhistory/{id}','App\Http\Controllers\historyController@detailHistory');
        Route::GET('deletehistory/{id}','App\Http\Controllers\historyController@deleteHistory');
        Route::POST('edithistory','App\Http\Controllers\historyController@editHistory');
        Route::POST('approval/{id}','App\Http\Controllers\historyController@Approval');
    });
});

Route::group(['prefix' => '/', 'middleware' => 'userCheck'], function () {
    Route::get('/','App\Http\Controllers\pageController@index');
    Route::get('home','App\Http\Controllers\pageController@index');
    Route::group(['prefix'=>'ajax'],function (){
        Route::get('room/{id}','App\Http\Controllers\AjaxController@getroom');
        Route::get('floor/{id}','App\Http\Controllers\AjaxController@getfloor');
        Route::get('editroom/{id}','App\Http\Controllers\AjaxController@geteditroom');
    });
    Route::group(['prefix' => 'regisroom'], function () {
        Route::GET('/','App\Http\Controllers\pageController@gethome');
        Route::post('addroom','App\Http\Controllers\pageController@regisRoom');
        Route::GET('detailroom/{id}','App\Http\Controllers\pageController@detailRoom');
        Route::GET('deleteroom/{id}','App\Http\Controllers\pageController@deleteRoom');
        Route::POST('editroom','App\Http\Controllers\pageController@editRoom');
    });
});
