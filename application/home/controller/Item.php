<?php

namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\Goods;
use app\admin\model\Attribute;

class Item extends Controller
{
    public function item(Request $request,$id){
        $data=Goods::find($id);
        $albumdata=Db::name("goods_album")->where("goods_id",$id)->select();
        $attr=Attribute::where("type_id",$data->goods_type_id)->select();
        $attrinfo=unserialize($data->goods_attr);
//        p($attr->toArray());p($attrinfo);die;
        foreach ($attr as $k=>$v){
            $attr[$k]["value"]=$attrinfo[$v->id];
        }
        return view("item",compact("data","albumdata","attr"));
    }
}
