<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Role as RoleModel;
use think\Request;
use app\admin\model\Privilege as PrivilegeModel;
use think\Validate;

class Role extends Base
{
    public function index(){
        $data=RoleModel::select();
        return view("index",compact("data"));
    }
    public function edit(Request $request,$id){
        if ($request->isGet()){
            $privA=PrivilegeModel::where("level",0)->select();
            $privB=PrivilegeModel::where("level",1)->select();
            $privC=PrivilegeModel::where("level",2)->select();
            $info=RoleModel::find($id);
            $old_priv_ids=explode(",",$info->priv_ids);
            return view("edit",compact("privA","privB","privC","info","old_priv_ids"));
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "role_name"=>"require|unique:role,role_name,".$id,
                "priv"=>"require|array"
            ];
            $msg=[
                "role_name.require"=>"角色名称不能为空",
                "role_name.unique"=>"角色名称已经存在",
                "priv.require"=>"权限数据不能为空",
                "priv.array"=>"权限数据异常"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $priv=implode(",",$data["priv"]);
                $priv_ac=PrivilegeModel::
                where("id","in",$data["priv"])
                    ->where("level","neq",'0')
                    ->column("concat(controller_name,'-',action_name) as priv_ac");
                $priv_ac=implode(",",$priv_ac);
                RoleModel::where("id",$id)->update([
                    "role_name"=>$data["role_name"],
                    "priv_ids"=>$priv,
                    "priv_ac"=>$priv_ac
                ]);
                return ['info'=>1];
            }else{
                $error=implode(",",$validate->getError());
                return ["info"=>0,"msg"=>$error];
            }
        }
    }
}
