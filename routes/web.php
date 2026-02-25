<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/auth/google/redirect', [UserController::class, 'googleRedirect']);
Route::get('/auth/google/callback', [UserController::class, 'googleCallback']);
