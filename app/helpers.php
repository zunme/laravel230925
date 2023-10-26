<?php
function getSiGunGuCode($code, $type=null){
    if( !$type ){
        $type = config('site.use_sigungu',false) ? 'gungu':'sido';
    }
    $sido = substr($code, 0, 2);
    $gungu =  substr($code, 0, 5);

    if($type == 'gungu') return $gungu;
    else return $sido;
}