<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable =['move_request_id','user_id','name','move_type','star_point','write_at','comment'
            ,'use_front','is_view','area','move_date'
        ];
    protected $casts = [
        'write_at' => 'date',
        'move_date' => 'date',
    ];
    protected $appends = ['move_type_label'];

    public function getMoveTypeLabelAttribute(){
        $move_type = config('site.move_type');
        if( isset($move_type[$this->move_type]) ) return $move_type[$this->move_type]['title'];
        else return $this->move_type;
    }

    public function scopeActive($query){
        return $query->where('is_view','Y');
    }
    public function scopeActivefront($query){
        if( config('site.front_review_only_checked') ) return $query->where(['is_view'=>'Y','use_front'=>'Y'])->orderBy(\DB::raw('RAND()'));
        return $query;
    }
}
