<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable =['move_request_id','user_id','name','move_type','star_point','write_at','comment'];
    protected $casts = [
        'write_at' => 'date',
    ];
}
