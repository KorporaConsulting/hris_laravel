<?php

use App\Events\NotificationsEvent;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('tester', function(){
    return auth()->user();
});


// Authenticate

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function(){
    // Dashboard User General
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');

    // User
    Route::get('/user/{userId}', [UserController::class, 'show'])->name('users.show');
    Route::get('/user/{userId}/edit', [UserController::class, 'edit'])->name('users.show');


    // Account
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account/update', [AccountController::class, 'update'])->name('account.update');
    Route::get('/account/create', [AccountController::class, 'create'])->name('karyawan.create')->middleware('hr');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');


    // Cuti 
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
    Route::get('/cuti/list', [CutiController::class, 'show'])->name('cuti.show');
    Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');
    Route::patch('/cuti/{cutiId}', [CutiController::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{cutiId}', [CutiController::class, 'destroy'])->name('cuti.destroy');

    // KPI
    Route::get('/kpi', [KPIController::class, 'index'])->name('kpi.index')->middleware('hr');
    Route::post('/kpi', [KPIController::class, 'store'])->name('kpi.store')->middleware('hr');
    Route::get('/kpi/kpi-saya', [KPIController::class, 'myKPI'])->name('kpi.mykpi');
    Route::get('/kpi/{user_id}', [KPIController::class, 'show'])->name('kpi.show')->middleware('hr');

    // Karyawan
    // Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    // Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');




});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/event', function () {
    NotificationsEvent::dispatch('anjay', 17);
    return'ok';
});
