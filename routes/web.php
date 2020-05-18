<?php

use Illuminate\Support\Facades\Route;

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
     // Routes Front
Route::group(['namespace'=>'Front'], function (){
    Route::post('register','AuthController@register');
    Route::get('login','AuthController@login');
    Route::post('/','AuthController@doLogin');


   Route::get('/','MainController@home');
   Route::get('/post/{id}','MainController@postDetails');
    Route::get('/donations','MainController@donationRequests');
    Route::post('/toggle-favourite','MainController@toggleFavourite')->name('toggle-favourite');
});


Route::get('test', function () {
    return view('test');
});

Route::group(['prefix'=>'admin'],function () {

    Route::get('login', 'AdminAuth@login');
    Route::post('login', 'AdminAuth@dologin');

});

Route::group(['middleware'=>'admin'],function (){


    Route::any('logout','AdminAuth@logout');

Route::get('home', function () {

    return view('admin.home');
});

Route::resource('roles','RoleController');
Route::resource('permissions','PermissionController');
Route::resource('governorate','GovernorateController');
Route::resource('cities','CityController');
Route::resource('posts','PostController');
Route::resource('categories','CategoryController');
Route::resource('bloodTypes','BloodTypeController');
Route::resource('contacts','ContactController');
Route::resource('users','UserController');



Route::get('{id}/edit_setting' , 'SettingController@edit');
Route::post('edit_setting/{id}' , 'SettingController@update');

    Route::get('lang/{lang}',function($lang){
        session()->has('lang')?session()->forget('lang'):'';
        $lang == 'ar'?session()->put('lang','ar'):session()->put('lang','en');
        return back();
    });
});
