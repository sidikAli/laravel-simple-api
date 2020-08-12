<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
	Route::get('post', 'API\PostController@index');
	Route::get('post/{id}', 'API\PostController@show');
	Route::post('post', 'API\PostController@store');
	Route::put('post/{id}', 'API\PostController@update');
	Route::delete('post/{id}', 'API\PostController@destroy');
});