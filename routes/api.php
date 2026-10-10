<?php

use App\Http\Controllers\KeyValueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(KeyValueController::class)
    ->prefix('object')
//    ->middleware(['api','guest'])
    ->group(function () {
        Route::post('/', 'storeKeyValue')->name('store_key_value');
        Route::get('{key_name}','getKeyValue')->name('get_key_value');
//        Route::get('{key_name}','getKeyValue')->name('get_key_value')->middleware(['key-middle-ware']);
    });
