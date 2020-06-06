<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'UserController@login');

Route::middleware('auth:sanctum')->group( function (){
    Route::apiResource('users','UserController');
    Route::apiResource('category','CategoryController');
    Route::apiResource('task','TaskController');
});
