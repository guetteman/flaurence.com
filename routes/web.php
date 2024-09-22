<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('WelcomePage');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('DashboardPage');
    })->name('dashboard');
});
