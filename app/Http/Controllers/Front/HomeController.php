<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use Illuminate\View\View;
use Auth;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\User;
use App\Models\MoveRequest;

class HomeController extends CommonController
{
    function index(){
        $data = $this->getFrontData();
        //return $this->success( $data );
        return view('front.welcomenew', $data);
    }
}