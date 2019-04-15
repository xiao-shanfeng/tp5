<?php

namespace app\home\controller;

use app\home\model\Cart;
use think\Controller;
use think\Request;
use think\Validate;
use app\home\model\User as UserModel;

class User extends Controller
{
    public function register(Request $request){
        if ($request->isGet()){
            return view("register");
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "username"=>"require|unique:user,username",
                "user_email"=>"require|email|unique:user,user_email",
                "password"=>"require|length:6|confirm",
                "password_confirm"=>"require|length:6"
            ];
            $msg=[
                "username.require"=>"用户名不能为空",
                "username.unique"=>"用户名不能重复",
                "user_email.require"=>"用户邮箱不能为空",
                "user_email.email"=>"用户邮箱数据格式不符合",
                "user_email.unique"=>"用户邮箱不能重复",
                "password.require"=>"密码不能为空",
                "password.length"=>"密码长度必须是6位",
                "password.confirm"=>"两次密码输入不一致",
                "password_confirm.require"=>"确认密码不能为空",
                "password_confirm.length"=>"确认密码长度必须是6位"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $data["password"]=md5($data["password"]);
                $res=UserModel::create($data,true);
                if ($res){
                    //用户注册成功之后，数据入库成功，发送邮件
                    $verify_code=uniqid();
                    UserModel::where("id",$res->id)->update(["verify_code"=>$verify_code]);
                    $title="品优购商城账号激活";
                    $to=$data["user_email"];
                    $url="http://www.tpshop.com/home/user/active/id/".$res->id."/verify_code/".$verify_code;
                    $content="您好，".$data['username']." ：<br>欢迎加入品优购！请点击下面的链接来认证您的邮箱。<br><a href='$url'>".$url."</a><br>如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中认证。";
                    send_email($to,$title,$content);
                    return view("reg_success");
                }else{
                    $this->error("用户入库失败");
                }
            }else{
                $error=implode(",",$validate->getError());
                $this->error($error);
            }
        }
    }
    public function active(Request $request){
        $id=$request->param("id");
        $verify_code=$request->param("verify_code");
        $info=UserModel::find($id);
        if ($info){
            //该用户存在
            if ($info->is_active=="是"){
                //该用户已经激活过了，无需再次注册
                $msg="该用户已经激活过了，无需再次激活";
                $url="home/user/login";
            }else{
                if ($info->verify_code==$verify_code){
                    UserModel::where("id",$info->id)->update(["is_active"=>"是"]);
                    $msg="该用户激活成功，赶紧登陆";
                    $url="home/user/login";
                }else{
                    $msg="激活失败,链接有误,请重新注册";
                    $url="home/user/register";
                }
            }
        }else{
            //该用户不存在
            $msg="激活失败,链接有误,请重新注册";
            $url="home/user/register";
        }
        return view("reg_active",compact("msg","url"));
    }
    public function login(Request $request){
        if ($request->isGet()){
            return view("login");
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "username"=>"require",
                "password"=>"require|length:6"
            ];
            $msg=[
                "username.require"=>"用户名不能为空",
                "password.require"=>"密码不能为空",
                "password.length"=>"密码长度必须为6位"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $info=UserModel::where("username",$data["username"])->find();
                if ($info){
                    if ($info->is_active=="否"){
                        $this->error("用户没有激活，无法登陆");
                    }
                    if ($info->password==md5($data["password"])){
                        session("user_id",$info->id);
                        session("user_name",$data["username"]);
                        $url="/";
                        if (cookie("?back_url")){
                            $url=cookie("back_url");
                            cookie("back_url",null);
                        }
                        $cart=new Cart();
                        $cart->cookie2Db();
                        $this->redirect($url);
                    }
                }
                $this->error("用户名或密码错误");
            }else{
                $error=$validate->getError();
                $this->error($error);
            }
        }
    }
}
