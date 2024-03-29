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

Route::namespace('Auth')->group(function () {
    Route::post('register', 'RegisterController@create');
    Route::post('login', 'LoginController@login');
});

Route::middleware('auth:api')->group(function () {
    Route::namespace('Api')->group(function () {
        Route::get('test', 'TestController@test');     
        Route::resource('questioncategories', 'QuestionCategoryController', ['only' => ['index','show']]);      
        Route::resource('questions', 'QuestionController', ['only' => ['show']]);     
        Route::post('question/answer', 'QuestionController@answer');
    });
    
    Route::namespace('Auth')->group(function () {
        Route::post('logout', 'LoginController@logout');
    });
});
