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
    Route::group(['prefix'=>'ajax'],function (){
        Route::get('addhistory/{id}','App\Http\Controllers\AjaxController@getaddhistory');
        Route::get('edithistory/{id}','App\Http\Controllers\AjaxController@getedithistory');
        Route::get('addbroken/{id}','App\Http\Controllers\AjaxController@getaddbroken');
        Route::get('addcomputer/{id}','App\Http\Controllers\AjaxController@getaddcomputer');
    });
    Route::group(['prefix' => 'approval'], function () {
        Route::GET('/','App\Http\Controllers\approvalController@index');
        Route::post('addapproval','App\Http\Controllers\approvalController@addApproval');
        Route::GET('detailapproval/{id}','App\Http\Controllers\approvalController@detailApproval');
        Route::GET('deleteapproval/{id}','App\Http\Controllers\approvalController@deleteApproval');
        Route::POST('editapproval','App\Http\Controllers\approvalController@editApproval');
        Route::POST('approval/{id}','App\Http\Controllers\approvalController@Approval');
        Route::GET('detailcheckout/{id}','App\Http\Controllers\approvalController@detailCheckOut');
        Route::POST('checkout','App\Http\Controllers\approvalController@submitCheckOut');
    });
    Route::group(['prefix' => 'broken'], function () {
        Route::GET('/','App\Http\Controllers\brokenController@index');
        Route::POST('addbroken','App\Http\Controllers\brokenController@addBroken');
        Route::GET('detailbroken/{id}','App\Http\Controllers\brokenController@detailBroken');
        Route::POST('editbroken','App\Http\Controllers\brokenController@editBroken');
    });
    Route::get('report', 'App\Http\Controllers\reportController@reportPDF');
});

Route::group(['prefix' => '/', 'middleware' => 'userCheck'], function () {
    Route::get('/','App\Http\Controllers\pageController@index');
    Route::get('home','App\Http\Controllers\pageController@index');
    Route::group(['prefix'=>'ajax'],function (){
        Route::get('addroom/{id}','App\Http\Controllers\AjaxController@getaddroom');

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
