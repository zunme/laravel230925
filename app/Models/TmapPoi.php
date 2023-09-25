<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Enums\Srid;

class TmapPoi extends Model
{
    use HasFactory;
	/*
	protected $table = '';
	protected $primaryKey = '';
	protected $hidden =[];
	protected $casts =[];
	const CREATED_AT = '';
    const UPDATED_AT = '';
	public $timestamps = false;
	*/
	protected $primaryKey = 'pkey';
    public $incrementing = false;
	protected $fillable = ['id','pkey','name','telno','frontLon','frontLat','crdnt','zipCode','upperAddrName','middleAddrName','lowerAddrName','detailAddrName','mlClass','firstNo','secondNo','roadName','firstBuildNo','secondBuildNo','poiobj'];
	protected $casts =['poiobj'=>'array','crdnt' => Point::class];
}