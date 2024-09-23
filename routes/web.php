<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskReportController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


// Route::middleware(['log.request.response'])->get('/dashboard', function () {
//     return Inertia::render('Dashboard');
    
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['log.request.response','auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/tasks', TaskController::class)->name('index', 'tasks.list');
});
Route::middleware(['auth'])->group(function () {
Route::get('/tasksreport', [TaskReportController::class,'tasksreport'])->name('tasksreport');
});

Route::get('/test', function () {
    return view('test');
});


require __DIR__.'/auth.php';
