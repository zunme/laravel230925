<?php

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
use App\Http\Controllers\Front\FrameworkController;

Route::get('/', function () {
    return view('front.welcome');
});

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