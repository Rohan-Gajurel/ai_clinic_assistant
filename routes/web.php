<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home');
})->name('home');

Route::get('/appointment', function () {
    return view('frontend.appointment');
})->name('appointment');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// Backend Routes
Route::prefix('roles')->controller(RoleController::class)->group(function() {
    Route::get('/', 'index')->name('roles.index');
    Route::get('/create', 'create')->name('roles.create');
    Route::post('/', 'store')->name('roles.store');
    Route::get('/{role}', 'edit')->name('roles.edit');
    Route::patch('/{role}', 'update')->name('roles.update');
    Route::delete('/{role}', 'destroy')->name('roles.destroy');
});

Route::prefix('permission')->controller(PermissionController::class)->group(function(){
    Route::get('/','indexPermission')->name('permissions.index');
    Route::get('/create', 'createPermission')->name('permissions.create');
    Route::post('/', 'addPermissions')->name('permissions.store');
    Route::get('/{id}','editPermissions')->name('permissions.edit');
    Route::patch('/{id}','updatePermissions')->name('permissions.update');
    Route::delete('/{id}','destroyPermissions')->name('permissions.destroy');
});

Route::prefix('users')->controller(UserController::class)->group(function(){
    Route::get('/', 'index')->name('users.users');
    Route::get('/{id}','edit')->name('users.edit');
    Route::put('/{id}','update')->name('users.update');
    Route::delete('/{id}','destroy')->name('users.destroy');
});

require __DIR__.'/settings.php';
