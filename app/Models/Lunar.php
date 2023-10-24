<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lunar extends Model
{
    use HasFactory;
	//protected $primaryKey = "locdate";
    public $incrementing = false;
    public $timestamps = false;
	protected $fillable =['id','solYear','solMonth','solDay','solWeek','solLeapyear','solJd','lunYear','lunMonth','lunDay','lunNday','lunLeapmonth','lunIljin','lunSecha','lunWolgeon','date'];
	protected $casts = [
        'date' => 'date',
    ];
}
