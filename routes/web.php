<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Role Routes
Route::get('/role', [RoleController::class,'index'])->name('role.index');
Route::post('role/create', [RoleController::class,'create'])->name('role.create');
Route::get('role/update/{id}', [RoleController::class,'edit'])->name('role.edit');
Route::post('role/update/', [RoleController::class,'update'])->name('role.update');
Route::delete('role/delete/{id}', [RoleController::class,'delete'])->name('role.delete');
// User Routes
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::match(['post','get'],'user/create', [UserController::class, 'create'])->name('user.create');
Route::get('user/update/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('user/update', [UserController::class, 'update'])->name('user.update');
Route::delete('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');


// Status Active Inactive Route
Route::post('/change-status', [RoleController::class, 'change_status'])->name('change.status');
