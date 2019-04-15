<?php
use app\admin\model\Type;

function get_type_info(){
    return Type::select();
}
function getCategoryTree($data,$parent_id=0,$lev=0){
    static $list=[];
    foreach ($data as $v){
        if ($v["parent_id"]==$parent_id){
            $v["lev"]=$lev;
            $list[]=$v;
            getCategoryTree($data,$v["id"],$lev+1);
        }
    }
    return $list;
}

function removeXSS($val){
    static $obj=null;
    if ($obj==null){
        require "./static/admin/HTMLPurifier/HTMLPurifier.includes.php";
        $obj=new HTMLPurifier();
    }
    return $obj->purify($val);
}