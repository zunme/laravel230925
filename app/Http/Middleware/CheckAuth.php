<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role=null): Response
    {
		switch ($role) {
			case("admin") :
				$user = \Auth::guard('admin')->user();
				if( !$user){
					if (!$request->expectsJson()) {
						return redirect('/');
					}else {
						return response()->json([
							'status' => 'Error',
							'message' => '관리자 로그인 후 사용해주세요.',
							'data' => []
						  ], 401,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
					}
				}
				
				break;
			case("partner") :
				$user = \Auth::guard('partner')->user();
				if( !$user){
					if (!$request->expectsJson()) {
						return redirect('/');
					}else {
						return response()->json([
							'status' => 'Error',
							'message' => '파트너 로그인 후 사용해주세요.',
							'data' => []
						  ], 401,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
					}
				}
				
				break;
			case("user") :
				$user = \Auth::guard('web')->user();
				if( !$user){
					if (!$request->expectsJson()) {
						return redirect('/');
					}else {
						return response()->json([
							'status' => 'Error',
							'message' => '로그인 후 사용해주세요.',
							'data' => []
						  ], 401,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
					}
				}
				break;
			case("userOrPartner") :
				$user = \Auth::guard('web')->user();
				if( !$user){
					$user = \Auth::guard('partner')->user();
					if( !$user){
						if (!$request->expectsJson()) {
							return redirect('/');
						}else {
							return response()->json([
								'status' => 'Error',
								'message' => '로그인 후 사용해주세요.',
								'data' => []
							  ], 401,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
						}
					}
				}
				break;
			default:
				if (!$request->expectsJson()) {
					return redirect('/');
				}else {
					return response()->json([
						'status' => 'Error',
						'message' => '정의되지 않은 타입입니다.',
						'data' => []
					  ], 401,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
				}
		}
		if( $user->userstatus =='ready'){
			if (!$request->expectsJson()) {
				return redirect('/');
			}else {
				return response()->json([
					'status' => 'Error',
					'message' => '승인 대기중인 아이디입니다.',
					'data' => []
				  ], 422,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
			}
			
		}else if( $user->userstatus == 'banned'){
			if (!$request->expectsJson()) {
				return redirect('/');
			}else {
				return response()->json([
					'status' => 'Error',
					'message' => '사용 정지된 아이디 입니다.',
					'data' => []
				  ], 422,['Pragma'=> 'no-cache','Cache-Control'=> 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']);
			}	
		}
		
		app()->instance('authUser', $user); // resolve('authUser');
        return $next($request);
    }
}