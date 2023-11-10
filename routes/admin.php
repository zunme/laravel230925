<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Admin\FrameworkController;

Route::post('login', [CustomLoginController::class, 'adminstore'])->name('admin.login');
Route::post('logout', [CustomLoginController::class, 'admindestroy']);

Route::middleware('cache.headers:no_store')->group(function(){
	/* framework */
	Route::prefix('pages')->group(function () {
		Route::get('/{page}' , [FrameworkController::class, 'showPage']);
		Route::get('/{page}/{sub}' , [FrameworkController::class, 'showPage']);
	});
	Route::get('/popup/view/{page}' , [FrameworkController::class, 'showPopup']);

	Route::get('/', [FrameworkController::class, 'showIndex']);
	Route::get('/{ctname}', [FrameworkController::class, 'showIndex']);
	Route::get('/{ctname}/{id}', [FrameworkController::class, 'showIndex']);
	Route::get('/{ctname}/{id}/{fnname}', [FrameworkController::class, 'showIndex']);
	Route::get('/{ctname}/{id}/{fnname}/{idsub}', [FrameworkController::class, 'showIndex']);
});