<?php

use App\Events\NotificationsEvent;
use App\Http\Controllers\{AccountController, KehadiranController, AuthController, CutiController, DashboardController, PengumumanController, PollingController, TaskController};
use App\Http\Controllers\{DivisiController, KaryawanController, KPIController, UserController, ProjectController};
use App\Mail\NotifMail;
use Illuminate\Support\Facades\Mail;
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

Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
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
    Route::get('/account/create', [AccountController::class, 'create'])->name('karyawan.create');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');


    // Cuti 
    Route::get('/cuti/staff', [CutiController::class, 'staff'])->name('cuti.staff');
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
    Route::get('karyawan/{userId}', [KaryawanController::class, 'show'])->name('karyawan.show');
    Route::get('karyawan/{userId}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    

    
        Route::get('karyawan/{userId}/kpi', [KPIController::class, 'index'])->name('karyawan.kpi.index');
        Route::get('karyawan/{userId}/kpi/create', [KPIController::class, 'create'])->name('karyawan.kpi.create');
        Route::get('karyawan/{userId}/kpi/{kpiId}', [KPIController::class, 'show'])->name('karyawan.kpi.show');



    // Kehadiran
    Route::get('kehadiran/kehadiran-saya', [KehadiranController::class, 'kehadiranSaya'])->name('kehadiran.kehadiran-saya');
    Route::get('kehadiran/kehadiran-staff', [KehadiranController::class, 'kehadiranStaff'])->name('kehadiran.kehadiran-staff');
    Route::get('kehadiran/present', [KehadiranController::class, 'present'])->name('kehadiran.present');
    Route::resource('kehadiran', KehadiranController::class);
    Route::resource('divisi', DivisiController::class);

    // Pengumuman
    Route::get('pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('pengumuman/{pengumumanId}', [PengumumanController::class, 'index'])->name('pengumuman.show');
    Route::get('pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
    Route::post('pengumuman/store', [PengumumanController::class, 'store'])->name('pengumuman.store');
    
    // Polling
    Route::get('polling', [PollingController::class, 'index'])->name('polling.index');
    Route::get('polling/create', [PollingController::class, 'create'])->name('polling.create');
    Route::post('polling/store', [PollingController::class, 'store'])->name('polling.store');
    Route::put('polling/vote', [PollingController::class, 'vote'])->name('polling.vote');
    
    // Project
    Route::get('project', [ProjectController::class, 'index'])->name('project.index');
    Route::get('project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('project/store', [ProjectController::class, 'store'])->name('project.store');

        // Task
        Route::get('project/{projectId}/task', [TaskController::class, 'index'])->name('project.task.index');
        Route::get('project/{projectId}/task/create', [TaskController::class, 'create'])->name('project.task.create');
        Route::post('project/{projectId}/task/store', [TaskController::class, 'store'])->name('project.task.store');
    Route::patch('task/{taskId}/update', [TaskController::class, 'update'])->name('task.update');

});
Route::get('/sendmail', function(){
    Mail::to('ramaramarama009@gmail.com')->send(new NotifMail('test'));
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/event', function () {
    NotificationsEvent::dispatch('anjay', 17);
    return'ok';
});
