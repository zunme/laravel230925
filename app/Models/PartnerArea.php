<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerArea extends Model
{
    use HasFactory;
    protected $fillable = ['partner_id','avail_siCode','avail_sigunguCode'];
    //protected $appends = ['area_label'];
    // $p->append(['area_label']);

    public function getAreaLabelAttribute(){
        $labels = config('customsido.simple');
        if( isset($labels[$this->avail_siCode]) ) return $labels[$this->avail_siCode];
        else return $this->avail_siCode;
    }

    public function partner(){
		return $this->belongsTo(Partner::class, 'partner_id', 'id');
	}

}
