<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Login
Route::prefix('auth')->group(function() {
    Route::post('register', 'AuthenticatorController@register');
    Route::post('login', 'AuthenticatorController@login');

    Route::get('register/activate/{id}/{token}', 'AuthenticatorController@registeractivate');

    Route::middleware('auth:api')->group(function() {
        Route::post('logout', 'AuthenticatorController@logout');
    });
});

//Post
Route::middleware('auth:api')->prefix('post')->group(function() {
    Route::get('/', 'PostController@index');
    Route::post('/', 'PostController@store');
    Route::delete('/{id}', 'PostController@destroy');
    Route::get('/like/{id}', 'PostController@like');
});