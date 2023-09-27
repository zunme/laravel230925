<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class CustomLoginController extends Controller
{
	
    function store(Request $request){
		$request->validate([
            'userid' => 'required',
            'password' => 'required',
        ],[],["userid"=>"사용자아이디","password"=>"패스워드"]);
   
        $credentials = $request->only('userid', 'password');
		$credentials['authtype'] = 'member';
		
        if (Auth::guard('web')->attempt($credentials)) {
            return $this->success();
        }
  		else  return $this->error422('아이디 패스워드를 확인해주세요');
		
        return redirect("login")->withSuccess('Login details are not valid');
	}
	function adminstore(Request $request){
		$request->validate([
            'userid' => 'required',
            'password' => 'required',
        ],[],["userid"=>"어드민아이디","password"=>"패스워드"]);
   
        $credentials = $request->only('userid', 'password');
		$credentials['authtype'] = 'admin';
		
        if (Auth::guard('admin')->attempt($credentials)) {
            return $this->success();
        }
  		else  return $this->error422('아이디 패스워드를 확인해주세요');
		
        return redirect("login")->withSuccess('Login details are not valid');
	}
	
	function partnerstore(Request $request){
		$request->validate([
            'userid' => 'required',
            'password' => 'required',
        ],[],["userid"=>"파트너 아이디","password"=>"패스워드"]);
   
        $credentials = $request->only('userid', 'password');
		$credentials['authtype'] = 'partner';
		
		$credentialsFrom = [
			'from_userid'=>$request->userid,
			'password'=>$request->password,
			'authtype'=>'partner',
		];
		$credentials['authtype'] = 'partner';
		
        if (Auth::guard('partner')->attempt($credentials)) {
            return $this->success();
        }else if ( Auth::guard('partner')->attempt($credentialsFrom) ) {
			return $this->success();
		}
  		else  return $this->error422('아이디 패스워드를 확인해주세요');
	}
	function partnerdestroy(Request $request){
		Auth::guard('partner')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
		return $this->success();
	}
}