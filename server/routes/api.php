<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::middleware('auth:sanctum')->group( function (){
    Route::apiResource('users','UserController');
    Route::apiResource('category','CategoryController');
    Route::apiResource('list-task','ListTaskController');
    Route::apiResource('sticky-note','StickyNoteController');
    Route::apiResource('task','TaskController');

    Route::get('categories', 'CategoryController@category');
});
