<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Events\PresenceEvent;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use DataTables;
use DB;

use App\Models\Partner;
use App\Models\PartnerArea;

class PartnerAreaController extends Controller
{
    public function index(Request $request){
    }
    public function create(){

    }
    public function store(){
        
    }
    public function show($partner_id){
        return $this->success(['id'=>$partner_id]);
    }
    public function edit($partner_id){
    }
    public function update(Request $request, $partner_id, $area_id)
    {
    }
    public function destroy($partner_id, $area_id)
    {
    }
}