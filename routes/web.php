<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;

// Laravel'in auth sistemini aktif etme
Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

// Dashboard yönlendirmesi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Görev yönetimi rotaları (Sadece giriş yapmış kullanıcılar için)
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{uuid}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::delete('/tasks/{task:uuid}', [TaskController::class, 'destroy'])->whereUuid('uuid')->name('tasks.destroy');;
    Route::patch('/tasks/{task:uuid}/complete', [TaskController::class, 'markAsCompleted'])->whereUuid('uuid')->name('tasks.complete');
    Route::put('/tasks/{task:uuid}', [TaskController::class, 'update']);
});

// Kayıt olma sayfası yönlendirmesi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Ana sayfa (dashboard) yönlendirmesi
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
