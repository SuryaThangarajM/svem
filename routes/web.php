<?php

use App\Http\Controllers\BILLCONTROLLER;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return view('dashboardnew'); // User is authenticated
    } else {
        return view('auth.login'); // User is not authenticated
    }
});

Route::get('/dashboard', function () {
    return view('dashboardnew');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/main.php';
require __DIR__ . '/bill.php';
require __DIR__ . '/report.php';

Route::resource('expenses', BILLCONTROLLER::class);


