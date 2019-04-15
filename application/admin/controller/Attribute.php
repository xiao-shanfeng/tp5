<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Attribute as AttributeModel;
use think\Request;
use think\Validate;

class Attribute extends Base
{
    public function demo(){
        return view("goods/web");
    }
    public function index(Request $request){
        $type_id=$request->param("type_id");
        $data=AttributeModel::with("type")->where("type_id",$type_id)->select();
        return view("index",compact("data"));
    }
    public function add(Request $request){
        if ($request->isGet()){
            return view("add");
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "attr_name"=>"require",
                "type_id"=>"require|number|egt:1",
                "attr_type"=>"require|in:0,1",
                "attr_input_type"=>"require|in:0,1"
            ];
            $msg=[
                "attr_name.require"=>"属性名称不能为空",
                "type_id.require"=>"商品类型不能为空",
                "type_id.number"=>"商品类型数据格式不符合",
                "attr_type.require"=>"属性类型不能为空",
                "attr_type.in"=>"属性类型不合法",
                "attr_input_type.require"=>"录入方式不能为空",
                "attr_input_type.in"=>"录入方式不合法"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $data["attr_value"]=str_replace("，",",",$data["attr_value"]);
                $res=AttributeModel::create($data,true);
                if ($res){
                    return ["info"=>1];
                }else{
                    return ["info"=>0,"msg"=>"属性入库失败"];
                }
            }else{
                $error=implode(",",$validate->getError());
                return ["info"=>0,"msg"=>$error];

            }
        }
    }
    public function getAttr(Request $request){
        $type_id=$request->post("type_id");
        $data=AttributeModel::where("type_id",$type_id)->select();
        return view("getAttr",compact("data"));
    }
    public function getAttributeByType(Request $request){
        $type_id=$request->post("type_id");
        $data=AttributeModel::where("type_id",$type_id)->select();
        return view("getAttributeByType",compact("data"));
    }
}
