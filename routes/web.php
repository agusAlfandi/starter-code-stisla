<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'revalidate', 'verified', 'can:dashboard'])->group(function () {
    Route::get('/home', function () {
        return view('dashboard.home');
    })->name('home');
});
