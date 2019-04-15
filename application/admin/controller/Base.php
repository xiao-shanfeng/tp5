<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $info=session("info");
        $id=$info["id"];
        if (empty($id)){
            $this->error("必须登录","admin/login/login");
        }
        if ($id==1){
            return true;
        }
        $curr_priv=request()->controller()."-".request()->action();
        $role_id=$info["role_id"];
        $roledata=Db::name("role")->find($role_id);
        $has_priv=$roledata["priv_ac"];
        if (request()->controller()!="Index"){
            if (strpos($has_priv,$curr_priv)===false){
                exit("你无权访问");
            }
        }
    }
}
