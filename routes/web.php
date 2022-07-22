<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationsController;
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

Route::get('/pdf_reservation/{id}',[ReservationsController::class,'generatePdfReservation']);
Route::get('/',[ReservationsController::class,'generatePdfReservation']);
Route::post('/complete_virtual_tpv_transaction',[ReservationsController::class,'completeVirtualTPVTransaction']);

