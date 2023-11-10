<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonController;

use App\Http\Controllers\Partner\MyController as PartnerMy;

use App\Http\Controllers\Admin\RequestController as AdminRequest;
use App\Http\Controllers\Admin\PartnerController as AdminPartner;
use App\Http\Controllers\Admin\PartnerAreaController as AdminPartnerArea;
use App\Http\Controllers\Admin\ReviewController as AdminReview;
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

	Route::get('/review', [CommonController::class, 'getReview']);	
	Route::get('/req', [CommonController::class, 'getReqList']);
	Route::get('/front', [CommonController::class, 'getFront']);
});

Route::get('/sigungu', [CommonController::class, 'sigungu']);

/*partner */
Route::middleware(['web','checkauth:partner'])->prefix('partner')->group(function () {
	Route::prefix('my')->group(function () {
		Route::get('/matching', [PartnerMy::class, 'matching']);	
	});
});

/* admin */
//Route::get('/djemals/requestlist', [AdminRequest::class, 'list']);
// ,'checkauth:admin'
Route::middleware(['web','checkauth:admin'])->prefix('djemals')->group(function () {
	Route::get('/requestlist', [AdminRequest::class, 'list']);
	Route::get('/reqinfo/{id}', [AdminRequest::class, 'show']);
	Route::put('/reqinfo/{id}', [AdminRequest::class, 'update']);
	Route::delete('/reqinfo/{id}', [AdminRequest::class, 'destroy']);
	Route::put('/usefront/{id}',[AdminRequest::class, 'updateFrontShow']);

	Route::resource('/partner', AdminPartner::class);
	Route::resource('/partner.area', AdminPartnerArea::class);
	Route::put('/partner/{partner_id}/area',[AdminPartnerArea::class, 'updateAreas']);
	Route::put('/partner/{partner_id}/pwd',[AdminPartner::class, 'updatePassword']);

	Route::resource('/review', AdminReview::class);
	Route::get('/reqreview/{id}', [AdminReview::class, 'reqshow']);
});