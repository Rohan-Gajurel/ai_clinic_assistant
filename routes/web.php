<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;

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

Route::prefix('doctors')->controller(DoctorController::class)->group(function(){
    Route::get('/', 'index')->name('doctors.doctors');
    Route::get('/create', 'create')->name('doctors.create');
    Route::post('/', 'store')->name('doctors.store');
    Route::get('/{id}/edit', 'edit')->name('doctors.edit');
    Route::put('/{id}', 'update')->name('doctors.update');
    Route::delete('/{id}', 'destroy')->name('doctors.destroy');
});

Route::prefix('schedules')->controller(ScheduleController::class)->group(function(){
    Route::get('/', 'index')->name('schedules.index');
    Route::get('/create', 'create')->name('schedules.create');
    Route::post('/', 'store')->name('schedules.store');
    Route::get('/{id}/edit', 'edit')->name('schedules.edit');
    Route::put('/{id}', 'update')->name('schedules.update');
    Route::delete('/{id}', 'destroy')->name('schedules.destroy');
});

Route::prefix('patients')->controller(PatientController::class)->group(function(){
    Route::get('/', 'index')->name('patients.index');
    Route::get('/create', 'create')->name('patients.create');
    Route::post('/', 'store')->name('patients.store');
    Route::get('/{id}/edit', 'edit')->name('patients.edit');
    Route::put('/{id}', 'update')->name('patients.update');
    Route::delete('/{id}', 'destroy')->name('patients.destroy');
});
Route::get('/doctor-slots', [AppointmentController::class, 'getDoctorSlots'])->name('doctor.slots');

Route::prefix('appointments')->controller(AppointmentController::class)->group(function(){
    Route::get('/', 'index')->name('appointments.index');
    Route::get('/create/{id}', 'create')->name('appointments.create');
    Route::post('/', 'store')->name('appointments.store');
    Route::get('/{id}/edit', 'edit')->name('appointments.edit');
    Route::put('/{id}', 'update')->name('appointments.update');
    Route::delete('/{id}', 'destroy')->name('appointments.destroy');
    Route::get('/frontend-appointments', 'frontendAppointments')->name('frontend.appointments');
});

require __DIR__.'/settings.php';
