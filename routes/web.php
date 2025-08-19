<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/tasks/{id}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
Route::post('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

/**
 * Intentionally unsafe: destructive action over GET.
 * (Students should refactor to DELETE with CSRF.)
 */
Route::get('/tasks/delete/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy.get');

// Simple search endpoint (contains intentional SQLi bug via whereRaw)
Route::get('/search', [TaskController::class, 'search'])->name('tasks.search');
