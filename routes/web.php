<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'App\Http\Controllers\GuestController@login')->name('login');
Route::post('/login', 'App\Http\Controllers\GuestController@authenticate')->name('authenticate');

// Route prefix admin
Route::prefix('admin')->group(function () {
    Route::get('/', 'App\Http\Controllers\Admin\AdminController@home')->name('admin.home');
    Route::get('/projects', 'App\Http\Controllers\Admin\AdminController@projects')->name('admin.projects');
});

// create admin user
Route::get('/create-admin', function () {
    $user = new User();
    $user->name = 'Admin';
    $user->email = 'admin@admin.com';
    $user->password = Hash::make('password');
    $user->save();
});

Route::prefix('api')->group(function () {
    Route::apiResource('projects', 'App\Http\Controllers\ProjectsController');
    Route::apiResource('tasks', 'App\Http\Controllers\TasksController');
});
