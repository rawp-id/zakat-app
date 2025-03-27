<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZakatController;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/auth');
});

Route::get('/app', function () {
    return view('layouts.app');
});

Route::get('/auth/google', [App\Http\Controllers\AuthController::class, 'redirectGoogle']);
Route::get('/auth/google/callback', [App\Http\Controllers\AuthController::class, 'callbackGoogle']);

Route::get('/auth', function(){
    return view('auth');
})->name('login');

Route::get('/zakats/confirm', [ZakatController::class, 'confirm'])->name('zakats.confirm');
Route::post('/zakats/approve/{id}', [ZakatController::class, 'approve'])->name('zakats.approve');
Route::resource('zakats', ZakatController::class)->middleware('auth');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/{user}/update', [UserController::class, 'update'])->name('users.update');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
