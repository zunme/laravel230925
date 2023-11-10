<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\CustomLoginController;

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
use App\Models\User;

use App\Http\Controllers\CommonController;
use App\Http\Controllers\Front\MoveController;


//Route::get('/test', 'App\Http\Controllers\TestdefaultController@tmappoi');
Route::get('/test', 'App\Http\Controllers\TestdefaultController@checkuser');
Route::get('/sanctum/token', function (Request $request) {
	$user = \Auth::user();
	if( !$user ){
	    $request->validate([
			'userid' => 'required|string',
			'password' => 'nullable',
		]);
		$user = User::where('userid', $request->userid)->first();
		if (! $user || ! Hash::check($request->password, $user->password)) {
			return $this->error('인증을 하지 못했습니다');
		}	
	}
	
	switch($user->authtype){
		case( 'admin') : 
			$avilities =['role:admin'];
			break;
		case( 'partner') : 
			$avilities =['role:partner','role:member'];
			break;
		case( 'member') : 
			$avilities =['role:member'];
			break;
	}
    return $user->createToken('authtoken' , $avilities)->plainTextToken;
});
/*
Route::get('expiretoken', function (Request $request){
	dd($request->user()->currentAccessToken()->delete;
});

Route::get('gettoken', function (Request $request){
	return $request->user()->createToken('loginToken',['check-status','place-orders'])->plainTextToken;
});
Route::get('testtoken', function (Request $request){
	dd($request->user()->tokenCan('role:werver'));
})->middleware(['auth:sanctum']);
Route::get('/checktoken', function (Request $request) {
	if ( $request->user()->id && $request->user()->tokenCan('role:access') ){
		dd("OK");	
	}
	else dd("FALSE");
})->middleware(['auth:sanctum','abilities:ordercheck']);
*/
Route::post('login', [CustomLoginController::class, 'store'])->name('login');
Route::post('logout', [CustomLoginController::class, 'destroy']);
Route::get('checkuser', [CommonController::class,'checkAuthUser']);
Route::get('/getHolidays', 'App\Http\Controllers\CommonController@holidays');

Route::post('/move/reg', [MoveController::class,'store'] );

/* framework */
Route::prefix('pages')->group(function () {
	Route::get('/{page}' , [FrameworkController::class, 'showPage']);
	Route::get('/{page}/{sub}' , [FrameworkController::class, 'showPage']);
});
Route::get('/popup/view/{page}' , [FrameworkController::class, 'showPopup']);



Route::get('/v2', 'App\Http\Controllers\Front\HomeController@index');


Route::get('/', [FrameworkController::class, 'showIndex']);
Route::get('/{ctname}', [FrameworkController::class, 'showIndex']);
Route::get('/{ctname}/{id}', [FrameworkController::class, 'showIndex']);
Route::get('/{ctname}/{id}/{fnname}', [FrameworkController::class, 'showIndex']);
Route::get('/{ctname}/{id}/{fnname}/{idsub}', [FrameworkController::class, 'showIndex']);



require __DIR__.'/auth.php';