<?php

Route::get('/', function () {
    return view('homepage');
});
Route::namespace('Guest\Order')
    ->group(function () {
        Route::post('search-order-blade', 'OrderController@searchInBlade')->name('search-order');
    });
Route::group(['middleware' => 'web'], function () {
    Route::get('admin/{any?}', 'QuickOrderController@admin')->where('any', '.*')->name('admin');
});
Route::get('/{any?}', function () {
    return view('client');
})->where(['any' => '^(?!api|admin).*']);
