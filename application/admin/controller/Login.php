<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Validate;
use app\admin\model\Manager as ManagerModel;

class Login extends Controller
{
    public function login(Request $request){
        if ($request->isGet()){
            return view("login");
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "name"=>"require",
                "password"=>"require|length:6"
            ];
            $msg=[
                "name.require"=>"用户名不能为空",
                "password.require"=>"密码不能为空",
                "password.length"=>"密码长度必须为6位"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $info=ManagerModel::field("id,name,password,role_id")->where("name",$data["name"])->find();
                if ($info){
                    if (password_verify($data["password"],$info->password)){
                        session("info",$info->toArray());
                        $this->success("登录成功","admin/index/index");
                    }
                }
                $this->error("用户名或密码错误");
            }else{
                $error=implode(",",$validate->getError());
                $this->error($error);
            }
        }
    }
    public function logout(){
        session("info",null);
        $this->redirect("admin/login/login");
    }
}
