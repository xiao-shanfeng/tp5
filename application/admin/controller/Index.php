<?php
namespace app\admin\controller;
use app\admin\model\Manager as ManagerModel;
use app\admin\model\Privilege as PrivilegeModel;

class Index extends Base
{
    public function index()
    {
        $info=session("info");
        $admin_id=$info["id"];
        if ($admin_id==1){
            //超级管理员
            $privA=PrivilegeModel::where("level",0)->select();
            $privB=PrivilegeModel::where("level",1)->select();
        }else{
            //普通管理员
            $priv_ids=ManagerModel::alias("m")
                ->join("__ROLE__ r","m.role_id=r.id")
                ->where("m.id",$admin_id)
                ->value("priv_ids");
            $priv_ids=explode(",",$priv_ids);
            $privA=PrivilegeModel::where("id","in",$priv_ids)->where("level",0)->select();
            $privB=PrivilegeModel::where("id","in",$priv_ids)->where("level",1)->select();
        }
        return view("index",compact("privA","privB"));
    }
    public function welcome(){
        return view("welcome");
    }
}
