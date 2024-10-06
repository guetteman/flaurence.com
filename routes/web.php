<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RunController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('WelcomePage');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(ProjectController::class)->group(function () {
        Route::get('/projects/create', 'create')->name('projects.create');
        Route::post('/projects', 'store')->name('projects.store');
        Route::get('/projects/{project}', 'show')->name('projects.show');
        Route::get('/projects/{project}/edit', 'edit')->name('projects.edit');
        Route::put('/projects/{project}', 'update')->name('projects.update');
    });

    Route::controller(RunController::class)->group(function () {
        Route::post('/projects/{project}/runs', 'store')->name('runs.store');
        Route::get('/projects/{project}/runs/{run}', 'show')->name('runs.show');
    });
});
