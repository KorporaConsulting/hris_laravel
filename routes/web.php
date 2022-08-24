<?php

use App\Events\NotifEvent;
use App\Events\NotificationsEvent;
use App\Http\Controllers\{AccountController, KehadiranController, AuthController, BoardController, CronController};
use App\Http\Controllers\{DashboardController, PengumumanController, PollingController, TaskController, CutiController};
use App\Http\Controllers\{DivisiController, EventController, KaryawanController, KPIController};
use App\Http\Controllers\{MailController, UserController, ProjectController, TestController};
use App\Mail\NotifMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
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



// Authenticate
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('guest')->group(function(){
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');
    Route::get('/forgot-password', [AuthController::class, 'passwordRequest'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'passwordEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'passwordReset'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'passwordUpdate'])->name('password.update');
});



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
    Route::get('/account/create', [AccountController::class, 'create'])->name('karyawan.create');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::get('/account/change-password', [AccountController::class, 'changePassword'])->name('account.changePassword');
    Route::patch('/account/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');


    // Cuti 
    Route::get('/cuti', [CutiController::class, 'index'])->name('cuti.index');
    Route::get('/cuti/manager', [CutiController::class, 'manager'])->name('cuti.manager');


    Route::get('/cuti/create', [CutiController::class, 'create'])->name('cuti.create');
    Route::get('/cuti/list', [CutiController::class, 'show'])->name('cuti.show');
    Route::post('/cuti', [CutiController::class, 'store'])->name('cuti.store');
    Route::patch('/cuti/{cutiId}', [CutiController::class, 'update'])->name('cuti.update');
    Route::delete('/cuti/{cutiId}', [CutiController::class, 'destroy'])->name('cuti.destroy');

    // KPI

    Route::get('/kpi/kpi-saya', [KPIController::class, 'myKPI'])->name('kpi.mykpi');
    Route::get('/kpi/create/{userId}', [KPIController::class, 'create'])->name('kpi.create');
    Route::resource('/kpi', KPIController::class)->except('create');


    // Karyawan
    // Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    // Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');

    Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::post('karyawan/csv-store', [KaryawanController::class, 'csvStore'])->name('karyawan.csvStore');
    Route::get('karyawan/{userId}', [KaryawanController::class, 'show'])->name('karyawan.show');
    Route::get('karyawan/{userId}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit')->middleware('permission:karyawan.update');
    Route::patch('karyawan/{userId}', [KaryawanController::class, 'update'])->name('karyawan.update');
    Route::get('karyawan/{userId}/change-status', [KaryawanController::class, 'changeStatus'])->name('karyawan.changeStatus');
    Route::delete('karyawan/{userId}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::patch('karyawan/{userId}/restore', [KaryawanController::class, 'restore'])->name('karyawan.restore');
    Route::patch('karyawan/restore-all', [KaryawanController::class, 'restoreAll'])->name('karyawan.restoreAll');

    
        Route::get('karyawan/{userId}/kpi', [KPIController::class, 'index'])->name('karyawan.kpi.index');
        Route::get('karyawan/{userId}/kpi/create', [KPIController::class, 'create'])->name('karyawan.kpi.create');
        Route::get('karyawan/{userId}/kpi/{kpiId}', [KPIController::class, 'show'])->name('karyawan.kpi.show');



    // Kehadiran
    Route::get('kehadiran/kehadiran-saya', [KehadiranController::class, 'kehadiranSaya'])->name('kehadiran.kehadiran-saya');
    Route::get('kehadiran/present', [KehadiranController::class, 'present'])->name('kehadiran.present');
    Route::get('kehadiran/report', [KehadiranController::class, 'report'])->name('kehadiran.report');
    Route::resource('kehadiran', KehadiranController::class);
    Route::resource('divisi', DivisiController::class);

    // Pengumuman
    Route::get('pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::get('pengumuman/{pengumuman:id}', [PengumumanController::class, 'show'])->name('pengumuman.show');
    Route::post('pengumuman/store', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::get('pengumuman/{pengumuman:id}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
    Route::patch('pengumuman/{pengumuman:id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('pengumuman/{pengumuman:id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    
    // Polling
    Route::get('polling', [PollingController::class, 'index'])->name('polling.index');
    Route::get('polling/create', [PollingController::class, 'create'])->name('polling.create');
    Route::post('polling/store', [PollingController::class, 'store'])->name('polling.store');
    Route::get('polling/{polling:id}', [PollingController::class, 'show'])->name('polling.show');
    Route::put('polling/vote', [PollingController::class, 'vote'])->name('polling.vote');
    Route::get('polling/{polling:id}/edit', [PollingController::class, 'edit'])->name('polling.edit');
    Route::patch('polling/{pollingId}', [PollingController::class, 'update'])->name('polling.update');
    Route::delete('polling/{pollingId}', [PollingController::class, 'destroy'])->name('polling.destroy');
    
    // Project
    Route::get('project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::delete('project/{projectId}', [ProjectController::class, 'destroy'])->name('project.destroy');

        // Board
        Route::post('project/{projectId}/store', [BoardController::class, 'store'])->name('project.board.store');
        Route::post('project/{projectId}/store/default', [BoardController::class, 'storeDefault'])->name('project.board.storeDefault');
        Route::patch('project/{projectId}/board/{boardId}', [BoardController::class, 'update'])->name('project.board.update');
        Route::delete('project/{projectId}/board/{boardId}', [BoardController::class, 'destroy'])->name('project.board.destroy');

        // Task
        Route::get('project/{projectId}/task', [TaskController::class, 'index'])->name('project.task.index');
        Route::get('project/{projectId}/task/create', [TaskController::class, 'create'])->name('project.task.create');
        Route::post('project/{projectId}/task/store', [TaskController::class, 'store'])->name('project.task.store');

    Route::post('task/store', [TaskController::class, 'store'])->name('task.store');
    Route::patch('task/{taskId}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('task/{taskId}', [TaskController::class, 'destroy'])->name('task.destroy');

    Route::get('event', [EventController::class, 'index'])->name('event.index');
    Route::post('event/action', [EventController::class, 'action'])->name('event.action');
    Route::get('event/create', [EventController::class, 'create'])->name('event.create')->middleware('permission:event.create');
    Route::post('event', [EventController::class, 'store'])->name('event.store');
    Route::patch('event/{eventId}', [EventController::class, 'update'])->name('event.update')->middleware('permission:event.update');
    
});

Route::prefix('trash')->group(function(){
    Route::get('karyawan', [KaryawanController::class, 'trash'])->name('trash.karyawan');
});

Route::get('send-event-today', [CronController::class, 'sendEventToday']);

Route::prefix('cron')->group(function(){
    Route::get('check-alpha', [CronController::class, 'checkAlpha']);
    Route::get('cuti-bulanan', [CronController::class, 'cutiBulanan']);
});
Route::get('mail', MailController::class);
Route::redirect('/', 'login');



