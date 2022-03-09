<?php
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'guest', 'prefix' => 'guest'], function () {
    Route::get('/categories', 'CategoryController@index');
    Route::get('/category/items', 'CategoryController@items');
    Route::get('/items', 'ItemController@index');
});

Route::get('/{any?}', function () {
    return view('main');
})->where('any', '[\/\w\.-]*')->middleware('guest');
