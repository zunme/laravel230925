<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Models\User;

class FrameworkController extends Controller
{
	protected $prefix = 'partner';
	public function showIndex(){
		$user = \Auth::guard($this->prefix=='front' ? 'web': $this->prefix)->user();
		//if( !$user ) return view($this->prefix.'.welcome');
		return view($this->prefix.'.welcome',compact(['user']));
	}
	public function showPage(Request $request, $page, $sub=null){
		$user = \Auth::guard($this->prefix=='front' ? 'web': $this->prefix)->user();
		if( !$user ) return view($this->prefix.'.login');
		$data=[
			'user'=>$user,
			'pagename'=>$page . ($sub) ?"_{$sub}":'',
		];
		$page =[$this->prefix,$page];
		if( $sub )$page[] = $sub;

		$viewfile = implode('.', $page);
		if (view()->exists( $viewfile) ) {
			return view( $viewfile, $data);	
		}else {
			$data['pagename'] = 'home';
			return view($this->prefix.'.home', $data);
		}
	}

	public function showPopup(Request $request, $page){
		$user = \Auth::guard($this->prefix)->user();
		$data=[
			'user'=>$user,
			'pagename'=>$page,
		];
		return view($this->prefix.'.popup.'.$page, $data);
	}
	public function login(){
		return view($this->prefix.'.welcomelogin');
	}
}