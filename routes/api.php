<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonController;

use App\Http\Controllers\Admin\RequestController as AdminRequest;
use App\Http\Controllers\Admin\PartnerController as AdminPartner;
use App\Http\Controllers\Admin\PartnerAreaController as AdminPartnerArea;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum','abilities:role:member')->prefix('web')->group(function () {
	Route::get('user', function(Request $request){
		return $request->user();
	});
});
Route::middleware('auth:sanctum','abilities:role:partner')->prefix('partner')->group(function () {
	Route::get('user', function(Request $request){
		return $request->user();
	});
});
Route::middleware('auth:sanctum','abilities:role:admin')->prefix('admin')->group(function () {
	Route::get('user', function(Request $request){
		return $request->user();
	});
});

Route::prefix('common')->group(function () {
	Route::get('sondays', [CommonController::class, 'sondays']);
});

/* admin */
//Route::get('/djemals/requestlist', [AdminRequest::class, 'list']);
// ,'checkauth:admin'
Route::middleware(['web','checkauth:admin'])->prefix('djemals')->group(function () {
	Route::get('/requestlist', [AdminRequest::class, 'list']);
	Route::get('/reqinfo/{id}', [AdminRequest::class, 'show']);

	Route::resource('/partner', AdminPartner::class);
	Route::resource('/partner.area', AdminPartnerArea::class);
});