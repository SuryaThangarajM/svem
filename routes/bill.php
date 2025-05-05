<?php

use App\Http\Controllers\BILLCONTROLLER;
use Illuminate\Support\Facades\Route;

Route::get('/Bill', [BILLCONTROLLER::class, 'getbill'])
->name('getbill');

Route::get('/BillAll', [BILLCONTROLLER::class, 'getbillall'])
->name('getbillall');

Route::get('/BillAll1', [BILLCONTROLLER::class, 'getbillallNew'])
->name('getbillallNew');

Route::get('/VehicleReports', [BILLCONTROLLER::class, 'getvehireport'])
->name('getvehireport');

Route::get('/get-customer-details', [BILLCONTROLLER::class, 'getCustomerDetails'])->name('getcusmobadd');

Route::post('/Bills/store', [BILLCONTROLLER::class, 'storebill'])->name('Bills.store');

Route::get('/get-bill-data/{bill_no}', [BILLCONTROLLER::class, 'getBillData']);

Route::post('/bills/update', [BILLCONTROLLER::class, 'billupdate'])->name('bill.update');

Route::post('/bills/Delete', [BILLCONTROLLER::class, 'billDelete'])->name('bill.delete');

Route::get('/ExpenseEntry', [BILLCONTROLLER::class, 'ExpenseEntry'])->name('expentry');

Route::post('/StoreExp', [BILLCONTROLLER::class, 'store'])->name('storeexp');

Route::get('/IncExp', [BILLCONTROLLER::class, 'getincomeexpense'])
->name('getincomeexpense');

Route::get('/IncExpDMY', [BILLCONTROLLER::class, 'getExpenseDateWise'])
->name('getExpenseDateWise');

Route::get('/TotVehiChk', [BILLCONTROLLER::class, 'gettotvehichk'])
->name('gettotvehichk');




