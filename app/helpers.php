<?php
use App\Models\DongCode;
function getSiGunGuCode($code, $type=null){
    if( !$type ){
        $type = config('site.use_sigungu',false) ? 'gungu':'sido';
    }

    $sido = substr($code, 0, 2);
    $gungu =  substr($code, 0, 5);

    /* TODO ? 
    if($type == 'gungu'){
        if( $sido == '36' ){
            $gungu =  substr($code, 0, 8);
        }else if( $sido == '41' ){
            $gungu =  substr($code, 0, 5);
        }
    }
    if( $sido == '36' || $sido == '41' ) $sido = substr($code, 0, 5);
    */

    if($type == 'gungu') return $gungu;
    else return $sido;
}
function getDongInfo( $code , $name_only = true){
    $codepad = str_pad($code, 10, '0');
    $dong = DongCode::where('lawd_cd', $codepad)->first()->toArray();
    if( !$dong ) return null;

    $len = strlen( $code );
    $name = '';
    
    $simple = config('customsido.simple');
    //TODO
    //$dong['sido'] = ( isset( $simple[$dong['sido_cd']]) ) ? $simple[$dong['sido_cd']] : $dong['sido'];

    //todo ' '.$dong['sgg']=>''
    if( $len < 5 ) $name =  $dong['sido'];
    else if( $len < 8 ) $name =  $dong['sido'].( $dong['sido_cd']=='36' ? ' '.$dong['sgg'] : ' '.$dong['sgg']);
    else  $name =  $dong['sido'].( $dong['sido_cd']=='36' ? ' '.$dong['sgg'] : ' '.$dong['sgg']).' '.$dong['umd'];
    
    if( $name_only ) return $name;

    $dong['name'] = $name;
    return $dong;
}
function getMoveDong( $code , $type="from"){
    $ret = array();
    $ret[$type.'_siCode'] = getSiGunGuCode($code, 'sido');
    $ret[$type.'_sido'] = getDongInfo($ret[$type.'_siCode']);
    $ret[$type.'_sigunguCode'] = getSiGunGuCode($code, 'gungu');
    $ret[$type.'_sigungu'] = getDongInfo($ret[$type.'_sigunguCode']);

    if( $ret[$type.'_sido']==null || $ret[$type.'_sigungu']==null ) return false;
    else return $ret;
}