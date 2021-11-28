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
    Route::post('/login', 'LoginController@login');
    Route::post('/register', 'RegisterController@create');
});

// Vueからproxy経由でAPIにアクセス出来るかテスト
Route::get('/test', 'Controller@test');

Route::middleware('auth:api')->namespace('Api')->group(function () {
    Route::resource('/questioncategories', 'QuestionCategoryController', ['only' => ['index','show']]);
});

// Route::namespace('Api')->group(function(){
//     Route::resource('/questioncategories','QuestionCategoryController',['only' => ['index','show']]);
// });
