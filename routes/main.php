<?php

use App\Http\Controllers\MAINCONTROLLER;
use Illuminate\Support\Facades\Route;

// Route::get('/CustomerEntry', function () {
//     return view('CustomerEntry');  // Make sure you have resources/views/about.blade.php
// })->name('CustomerEntry');

Route::get('getcus', [MAINCONTROLLER::class, 'getcus'])
->name('getcus');

Route::get('getopr', [MAINCONTROLLER::class, 'getopr'])
->name('getopr');

Route::get('getVehi', [MAINCONTROLLER::class, 'getVehi'])
->name('getVehi');

Route::post('Cusentry', [MAINCONTROLLER::class, 'cusentry'])
->name('refercus');

Route::post('Oprentry', [MAINCONTROLLER::class, 'oprentry'])
->name('referopr');

Route::post('Vehientry', [MAINCONTROLLER::class, 'Vehientry'])
->name('referVehi');

Route::get('/customer/fetch', [MAINCONTROLLER::class, 'fetchCustomer'])->name('customer.fetch');
// Route::post('/customers/store', [MAINCONTROLLER::class, 'storecus'])->name('customer.store');
Route::post('/customers/update', [MAINCONTROLLER::class, 'updatecus'])->name('customer.update');
Route::post('/customers/delete', [MAINCONTROLLER::class, 'deletecus'])->name('customer.delete');

Route::get('/operators/fetch', [MAINCONTROLLER::class, 'fetchoperator'])->name('operator.fetch');
// Route::post('/operators/store', [MAINCONTROLLER::class, 'storeopr'])->name('operator.store');
Route::post('/operators/update', [MAINCONTROLLER::class, 'updateopr'])->name('operator.update');
Route::post('/operators/delete', [MAINCONTROLLER::class, 'deleteopr'])->name('operator.delete');

Route::get('/Vehicle/fetch', [MAINCONTROLLER::class, 'fetchVehicle'])->name('Vehicle.fetch');
Route::post('/Vehicle/update', [MAINCONTROLLER::class, 'updatevehi'])->name('Vehicle.update');
Route::post('/Vehicle/delete', [MAINCONTROLLER::class, 'deletevehi'])->name('Vehicle.delete');

