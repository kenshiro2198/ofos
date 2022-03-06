<?php

Route::get('/categories', 'CategoryController@index');
Route::get('/items', 'ItemController@index');

Route::get('/{any?}', function () {
    return view('main');
})->where('any', '[\/\w\.-]*')->middleware('guest');
