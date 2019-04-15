<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Privilege as PrivilegeModel;
use think\Request;
use think\Validate;

class Privilege extends Base
{
    public function index(){
        $data=getCategoryTree(PrivilegeModel::select());
        return view("index",compact("data"));
    }
    public function add(Request $request){
        if ($request->isGet()){
            $data=getCategoryTree(PrivilegeModel::where("level","<",2)->select());
            return view("add",compact("data"));
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "priv_name"=>"require",
                "parent_id"=>"require|number|egt:0"
            ];
            $msg=[
                "priv_name.require"=>"权限名称不能为空",
                "parent_id.require"=>"父级权限不能为空",
                "parent_id.number"=>"父级权限数据格式不符合",
                "parent_id.egt"=>"父级权限数据格式异常"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $res=PrivilegeModel::create($data,true);
                if ($res){
                    return ["info"=>1];
                }else{
                    return ["info"=>0,"msg"=>"权限入库失败"];
                }
            }else{
                $error=implode(",",$validate->getError());
                return ["info"=>0,"msg"=>$error];

            }
        }
    }
    public function getlevel(Request $request){
        $id=$request->post("parent_id");
        if ($id==0){
            return ["level"=>0];
        }
        $level=PrivilegeModel::where("id",$id)->value("level");
        return ["level"=>$level+1];
    }
}
