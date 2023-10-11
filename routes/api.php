<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
