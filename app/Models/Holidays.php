<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    use HasFactory;
	protected $primaryKey = "locdate";
    public $incrementing = false;
    public $timestamps = false;
	protected $fillable =['locdate','dateKind','dateName','isHoliday','last_update'];
	protected $casts = [
        'last_update' => 'datetime',
    ];
}