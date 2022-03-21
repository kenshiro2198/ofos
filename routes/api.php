<?php

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
Route::get('/category/items', 'CategoryController@items');
Route::post('/login', 'API\LoginController@login');
Route::post('/register', 'API\RegisterController@register');
Route::post('/order', 'API\OrderController@order');
Route::get('/track/{id}', 'API\TrackController@track');
Route::get('/address/{id}', 'API\AddressController@index');
Route::post('/address', 'API\AddressController@store');

/* Route::group(['middleware' => ['auth:api', 'api_csrf']], function () {
Route::get('/category/items', 'CategoryController@items');
Route::post("/logout", function () {
$user = Auth::guard('api')->user();
$user->api_token = null;
$user->csrf_token = null;
$user->save();
$response = [
'response_code' => 1,
'data' => [],
'message' => "Success.",
'csrf_token' => null,
];
return response()->json($response, 200);
});
}); */
