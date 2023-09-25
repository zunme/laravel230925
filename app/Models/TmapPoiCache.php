<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmapPoiCache extends Model
{
    use HasFactory;
	protected $fillable = ['search','result'];
	protected $casts =['result'=>'array'];
}