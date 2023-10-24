<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoveReqMatching extends Model
{
    use HasFactory;
    protected $fillable =['move_request_id','partner_id','notied'];
    
}
