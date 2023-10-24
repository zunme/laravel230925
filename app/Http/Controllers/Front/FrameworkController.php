<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Models\User;

class FrameworkController extends Controller
{
	public function showIndex(){
		$user = \Auth::guard('web')->user();
		if( !$user ) return view('front.welcome');
		return view('front.welcome');
	}
	public function showPage(Request $request, $page, $sub=null){
		$user = \Auth::guard('web')->user();
		$data=[
			'user'=>$user,
			'pagename'=>$page . ($sub) ?"_{$sub}":'',
		];
		$page =['front',$page];
		if( $sub )$page[] = $sub;

		$viewfile = implode('.', $page);
		if (view()->exists( $viewfile) ) {
			return view( $viewfile, $data);	
		}else return view('front.home', $data);
	}

	public function showPopup(Request $request, $page){
		$user = \Auth::guard('web')->user();
		$data=[
			'user'=>$user,
			'pagename'=>$page,
		];
		return view('front.popup.'.$page, $data);
	}
	public function login(){
		return view('front.welcomelogin');
	}
}