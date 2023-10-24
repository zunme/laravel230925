<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Models\User;

class FrameworkController extends Controller
{
	public function showIndex(){
		$user = \Auth::guard('admin')->user();
		if( !$user ) return view('admin.welcome');
		return view('admin.welcome');
	}
	public function showPage(Request $request, $page, $sub=null){
		$user = \Auth::guard('admin')->user();
		if( !$user ) return view('admin.login');
		$data=[
			'user'=>$user,
			'pagename'=>$page . ($sub) ?"_{$sub}":'',
		];
		$page =['admin',$page];
		if( $sub )$page[] = $sub;

		$viewfile = implode('.', $page);
		if (view()->exists( $viewfile) ) {
			return view( $viewfile, $data);	
		}else return view('admin.home', $data);
	}

	public function showPopup(Request $request, $page){
		$user = \Auth::guard('admin')->user();
		if( !$user ) return view('admin.pop.login');
		$data=[
			'user'=>$user,
			'pagename'=>$page,
		];
		return view('admin.popup.'.$page, $data);
	}
	public function login(){
		return view('admin.welcomelogin');
	}
}