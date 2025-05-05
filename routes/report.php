<?php


use App\Http\Controllers\REPORTCONTROLLER;
use Illuminate\Support\Facades\Route;

Route::get('/report/orders', [REPORTCONTROLLER::class, 'generateReport'])->name('genreport');


Route::get('/report/customer/download', function () {
    return app(\App\Http\Controllers\ReportController::class)->generateReport('download');
});