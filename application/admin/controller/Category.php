<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Category as CategoryModel;
use think\Request;
use think\Validate;

class Category extends Base
{
    public function index(){
        $data=getCategoryTree(CategoryModel::select());
        return view("index",compact("data"));
    }
    public function add(Request $request){
        if ($request->isGet()){
            $data=getCategoryTree(CategoryModel::select());
            return view("add",compact("data"));
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "cate_name"=>"require|unique:category,cate_name",
                "parent_id"=>"require|number",
                "cate_desc"=>"require|min:5"
            ];
            $msg=[
                "cate_name.require"=>"栏目名称不能为空",
                "cate_name.unique"=>"栏目名称不能重复",
                "parent_id.require"=>"父级栏目不能为空",
                "parent_id.number"=>"父级栏目数据格式不符合",
                "cate_desc.require"=>"栏目描述不能为空",
                "cate_desc.min"=>"栏目描述最少5个字符"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $res=CategoryModel::create($data,true);
                if ($res){
                    return ["info"=>1];
                }else{
                    return ["info"=>0,"msg"=>"栏目入库失败"];
                }
            }else{
                $error=implode(",",$validate->getError());
                return ["info"=>0,"msg"=>$error];

            }
        }
    }
    public function edit(Request $request,$id){
        if ($request->isGet()){
            $data=getCategoryTree(CategoryModel::select());
            $info=CategoryModel::find($id);
            return view("edit",compact("info","data"));
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "cate_name"=>"require",
                "parent_id"=>"require|number",
                "cate_desc"=>"require|min:5"
            ];
            $msg=[
                "cate_name.require"=>"栏目名称不能为空",
                "parent_id.require"=>"父级栏目不能为空",
                "parent_id.number"=>"父级栏目数据格式不符合",
                "cate_desc.require"=>"栏目描述不能为空",
                "cate_desc.min"=>"栏目描述最少5个字符"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $ids=getChildId(CategoryModel::select(),$id);
                $ids[]=$id;
                if (in_array($data["parent_id"],$ids)){
                    return ["info"=>0,"msg"=>"不能把自己的子孙栏目和自己当成父栏目"];
                }
                $res=CategoryModel::update($data,["id"=>$id],true);
                if ($res){
                    return ["info"=>1];
                }else{
                    return ["info"=>0,"msg"=>"栏目入库失败"];
                }
            }else{
                $error=implode(",",$validate->getError());
                return ["info"=>0,"msg"=>$error];

            }
        }
    }
    public function del(Request $request){
        $id=$request->post("id");
        $ids=getChildId(CategoryModel::select(),$id);
        if ($ids){
            return ["info"=>0,"msg"=>"先删除子栏目"];
        }
        $res=CategoryModel::destroy($id);
        if ($res){
            return ["info"=>1];
        }else{
            return ["info"=>0,"msg"=>"删除失败"];
        }
    }
}
