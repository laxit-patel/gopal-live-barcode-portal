<?php

use App\Http\Controllers\BarcodeCtr;
use App\Http\Controllers\ConfigurationCtr;
use App\Http\Controllers\DashboardCtr;
use App\Http\Controllers\DispatchCtr;
use App\Http\Controllers\LineCtr;
use App\Http\Controllers\LoginCtr;
use App\Http\Controllers\PackingProductionCtr;
use App\Http\Controllers\PlantCtr;
use App\Http\Controllers\ProductCtr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Laravel Cache clear route
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Route::get('/', function () {
    if (Session()->has('loggedData')) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('row.packing');
    }
});


Route::get('/display-data', [DashboardCtr::class, 'listdata'])->name('row.packing');
Route::get('/display-data/get/{ajax?}/{no?}', [DashboardCtr::class, 'listdata']);

Route::get('/packing-production/createVoucher', function () {
    Artisan::call('Production:Voucher');
});
Route::get('/getBarcode', function () {
    Artisan::call('Production:RawPacking');
});
// Route::get('/packing/getBarcode', function () {
//         Artisan::call('Production:RawPacking');
// });
// Route::get('/dispatch/getBarcode', function () {
//     Artisan::call('Dispatch:Raw');
// });

Route::get('/login', [LoginCtr::class, 'login'])->name('login');
Route::post('/login', [LoginCtr::class, 'auth'])->name('login');



Route::group(['middleware' => 'CheckLogin'], function ($router) {
    Route::get('/login/list', [LoginCtr::class, 'list'])->name('login.list');
    Route::get('/login/form/{id?}', [LoginCtr::class, 'form'])->name('login.form');
    Route::post('/login/save', [LoginCtr::class, 'save'])->name('login.save');
    Route::get('/login/delete/{id?}', [LoginCtr::class, 'delete'])->name('login.delete');


    Route::get('/dashboard', [DashboardCtr::class, 'dashboard'])->name('dashboard');
    Route::get('/plant', [PlantCtr::class, 'list'])->name('plant');
    Route::get('/plant/edit/{id}', [PlantCtr::class, 'edit'])->name('plant.edit');
    Route::post('/plant/save', [PlantCtr::class, 'save'])->name('plant.save');
    Route::get('/plant/delete/{id}', [PlantCtr::class, 'delete'])->name('plant.delete');
    Route::get('/plant/line/fetch',[PlantCtr::class, 'fetchLine'])->name('plant.line.fetch');

    Route::get('/line', [LineCtr::class, 'list'])->name('line');
    Route::get('/line/edit/{id}', [LineCtr::class, 'edit'])->name('line.edit');
    Route::post('/line/save', [LineCtr::class, 'save'])->name('line.save');
    Route::get('/line/delete/{id}', [LineCtr::class, 'delete'])->name('line.delete');

    Route::get('/barcode', [BarcodeCtr::class, 'list'])->name('barcode');
    Route::get('/barcode/edit/{id}', [BarcodeCtr::class, 'edit'])->name('barcode.edit');
    Route::post('/barcode/save', [BarcodeCtr::class, 'save'])->name('barcode.save');
    Route::get('/barcode/delete/{id}', [BarcodeCtr::class, 'delete'])->name('barcode.delete');

    Route::get('/product', [ProductCtr::class, 'list'])->name('product');

    Route::get('/dispatch', [DispatchCtr::class, 'list'])->name('dispatch');
    Route::post('/dispatch/update', [DispatchCtr::class, 'update'])->name('dispatch.update');
    Route::post('/dispatch/update/line', [DispatchCtr::class, 'updateLine'])->name('dispatch.update.line');
    Route::get('/dispatch/get/items/{order}', [DispatchCtr::class, 'getLineItems'])->name('dispatch.get.items');
    Route::get('/dispatch/get/pending/{line_no}/{plant}/{po}', [DispatchCtr::class, 'getPendingItems'])->name('dispatch.get.pending');


    Route::get('/configuration', [ConfigurationCtr::class, 'list'])->name('configuration');
    Route::post('/configuration', [ConfigurationCtr::class, 'save'])->name('configuration');
    Route::get('/raw/production/clear', [ConfigurationCtr::class, 'rawProductionClear'])->name('raw.production.clear');
    Route::get('/raw/dispatch/clear', [ConfigurationCtr::class, 'rawDispatchClear'])->name('raw.dispatch.clear');

    
});

Route::get('/sync', function () {
    Artisan::call('db:sync');
    return 'Database Synced';
});

// Route Logout 
Route::get('/logout', function () {
    session()->forget('loggedData');
    return redirect()->route('login')->with('success', 'Logout sucessfully');
})->name('logout');
