<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use mailer\tp31\Mailer;
function send_email($to,$title,$content){
    $maile=Mailer::instance();
    $maile->to($to)
        ->subject($title)
        ->html($content)
        ->send();
}
function getChildId($data,$id){
    static $list=[];
    foreach ($data as $v){
        if ($v["parent_id"]==$id){
            $list[]=$v["id"];
            getChildId($data,$v["id"]);
        }
    }
    return $list;
}

function p($data){
    echo "<pre>";
    print_r($data);
}
function getAttributeName($id){
    return \app\admin\model\Attribute::where("id",$id)->value("attr_name");
}
function getGoodsInfo($id){
    return \app\admin\model\Goods::field("id,goods_name,shop_price,goods_thumb")->where("id",$id)->find()->toArray();
}