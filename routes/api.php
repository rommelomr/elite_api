<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarDriversController;
use App\Http\Controllers\TerminalsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdministrationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/home_data', [HomeController::class,'homeData']);

Route::get('/identification_types', [ClientsController::class,'getIdentificationTypes']);

Route::get('/services', [ServicesController::class,'getServices']);

Route::get('/terminals', [TerminalsController::class,'getTerminals']);

Route::get('/reservations_data', [ReservationsController::class,'getReservationFormData']);

Route::post('/save_reservation', [ReservationsController::class,'saveReservation']);


Route::middleware(['auth:api'])->group(function(){

	Route::post('/modify_reservation', [ReservationsController::class,'modifyReservation']);

	Route::get('/reservations_dashboard_data', [ReservationsController::class,'reservations']);
	
	Route::post('/logout',[AuthController::class,'logout']);

	Route::post('/register_driver',[CarDriversController::class,'registerDriver']);
	
  Route::get('/reservation_email',[ClientsController::class,'sendReservationEmail']);

  Route::post('/reservation_email',[ClientsController::class,'sendReservationEmail']);

  Route::post('/update_reservation_client',[ReservationsController::class,'updateReservationClient']);

  Route::get('/prices_data',[AdministrationController::class,'getPricesViewData']);

  Route::post('/update_price',[AdministrationController::class,'updatePrice']);
  
});

Route::post('/login',[AuthController::class,'login']);
