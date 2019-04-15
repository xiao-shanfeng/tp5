<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\admin\model\Type as TypeModel;

class Type extends Base
{
    public function index(){
        $data=TypeModel::select();
        return view("index",compact("data"));
    }
    public function add(Request $request){
        if ($request->isGet()){
            return view("add");
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "type_name"=>"require|unique:type,type_name",
                "type_desc"=>"require|min:5"
            ];
            $msg=[
                "type_name.require"=>"类型名称不能为空",
                "type_name.unique"=>"类型名称是唯一的",
                "type_desc.require"=>"类型描述不能为空",
                "type_desc.min"=>"类型描述不能少于5个字符"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $res=TypeModel::create($data,true);
                if ($res){
                    return ["info"=>1];
                }else{
                    return ["info"=>0,"msg"=>"类型入库失败"];
                }
            }else{
                $error=implode(",",$validate->getError());
                return ["info"=>0,"msg"=>$error];

            }
        }
    }
}
