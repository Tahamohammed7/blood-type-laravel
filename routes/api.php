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

Route::group(['prefix'=>'v1', 'namespace' => 'Api'], function(){

    Route::get('governorate','MainController@governorte');
    Route::get('cities','MainController@cities');
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');
    Route::post('reset-password','AuthController@resetpassword');
    Route::post('new-password','AuthController@newpassword');



    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('donation-request','MainController@donation');
        Route::post('donation-request/create','MainController@donationRequestCreate');
        Route::post('post-favourites','MainController@postfavourites');
        Route::get('my-favourites','MainController@myfavourites');
        Route::get('notification','MainController@notification');
        Route::get('posts','MainController@posts');
        Route::get('categories','MainController@categories');
        Route::get('contacts','MainController@contacts');
        Route::get('bloodtypes','MainController@bloodtypes');
        Route::get('settings','MainController@settings');
        Route::post('profile','AuthController@profile');
        Route::post('register-token','AuthController@registerToken');
        Route::post('remove-token','AuthController@removeToken');
        Route::post('notifications-settings','AuthController@notificationsSettings');


    });
});

// Route::get('favouritespost',function(){

//     $clients = \App\Client::whereHas('posts',function($query){
//             $query->whereIn('id');
//     })->get();

//     Debugbar::info($clients);
//    return;
// });
