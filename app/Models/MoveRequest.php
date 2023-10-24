<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Events\MoveReqEvent;
use Carbon\Carbon;

class MoveRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =['user_id','tel','name','req_status',
        'move_type','move_date',
        'from_zip','from_address','from_floor','from_siCode','from_sido','from_sigunguCode','from_sigungu',
        'to_zip','to_address','to_floor','to_siCode','to_sido','to_sigunguCode','to_sigungu',
        'keep','noti','matched_partner_id'];
	protected $casts = [
        'move_date' => 'date',
    ];
    protected $appends = ['move_type_label'];

    public function getMoveTypeLabelAttribute(){
        $move_type = config('site.move_type');
        if( isset($move_type[$this->move_type]) ) return $move_type[$this->move_type]['title'];
        else return $this->move_type;
    }
    public function scopeAvail(){
        return $this->where('move_date', '>=', carbon::now()->setTimezone('Asia/Seoul'))
            ->whereIn('req_status',['Ready','Matching']);
    }
    public function user(){
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
    protected $dispatchesEvents = [
        'created' => MoveReqEvent::class,
    ];
}
