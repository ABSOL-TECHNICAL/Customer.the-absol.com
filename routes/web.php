<?php

use App\Http\Controllers\ChequeStatusController;
use App\Http\Controllers\ChequeSummaryController;
use App\Http\Controllers\CustomerAgeingController;
use App\Http\Controllers\CustomerSyncController;
use App\Http\Controllers\DateFilterController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\SoaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('download/{record}',[DownloadController::class,'download'])->name('download');
// Route::resource('otherdocuments', 'OtherdocumentsController');
// Route::get('otherdocuments/{uuid}/download', 'Otherdocuments@download')->name('otherdocuments.download');

Route::redirect('/','/customer-sites');
Route::get('downloadageing/{customer}',[CustomerAgeingController::class, 'downloadpdf'])->name('download.test');
Route::get('downloadstatus/{customer}',[ChequeStatusController::class, 'downloadpdf'])->name('downloadstatus.test');
Route::get('downloadsummary/{customer}',[ChequeSummaryController::class, 'downloadpdf'])->name('downloadsummary.test');
Route::get('downloadsoa/{customer}',[SoaController::class, 'downloadpdf'])->name('downloadsoa.test');
Route::post('/filter-dates', [DateFilterController::class, 'filterDates'])->name('filter-dates');


Route::get('/sync-customers', [CustomerSyncController::class, 'syncCustomers']);