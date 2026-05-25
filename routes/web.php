<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;

// Show login page
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Handle login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
// Route::post('/dashboard', [LoginController::class, 'login'])->name('login.post');

// Dashboard (protected)
Route::get('/dashboard', function () {
    return view("dashboard");
})->name('dashboard')->middleware('auth');

Route::view('/dashboard-content', 'pages.dashboard-content')->name('dashboard.content');

Route::view('/sample-page', 'pages.samplepage')->name('samplepage');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Profile (optional)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});