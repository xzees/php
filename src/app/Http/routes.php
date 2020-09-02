<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Route::group(['prefix' => env("config_route")], function () {
  /**
   *  Form payment
   */
  // Route::group(['middleware' => 'csrf'], function () {

    Route::post('/pay', '\App\Http\Controllers\BBL\formPaymentControlller@formSubmit');
    Route::get('/pay', '\App\Http\Controllers\BBL\formPaymentControlller@formSubmitGet');
  
  // });
  Route::post('/get_token', '\App\Http\Controllers\BBL\formPaymentControlller@token');

  Route::get('/pay/check', '\App\Http\Controllers\BBL\paymentCheckController@check');
  Route::get('/pay/fail', '\App\Http\Controllers\BBL\paymentFailController@fail');
  Route::group(['middleware' => 'logs'], function () {
    Route::post('/datafeed', '\App\Http\Controllers\BBL\paymentDatafeedController@datafeed');
    Route::get('/datafeed', function(){
      
    });
  });
  Route::get("/test", '\App\Http\Controllers\BBL\formPaymentControlller@test');

});

Route::post('/get', '\App\Http\Controllers\BBL\formPaymentControlller@tt');

Route::get("/migrate", function () {
  Artisan::call('migrate');
});


Route::get("/fail", function () {
  return view('mobile.fail');
});
Route::get("/success", function () {
  return view('mobile.success');
});

Route::get('/YWRtaW4=/bG9ncw==', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
