<?php

namespace app\home\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\admin\model\Category as CategoryModel;
use app\admin\model\Goods;

class Category extends Controller
{
    public function demo(){
//        $data=CategoryModel::select();
//        $data=Db::name("category")->select();
        $model=new CategoryModel();
        $data=$model->select();
        p($data);

    }
    public function index(Request $request,$id){
        if ($request->isPost()){
            $key=$request->post("key");
            p($key);
            $data=Goods::where("goods_name","like","%$key%");
        }elseif ($request->isGet()){
            $ids=getChildId(CategoryModel::select(),$id);
            $ids[]=$id;
            $data=Goods::where("cat_id","in",$ids)->select();
        }
        return view("index",compact("data"));
    }
}
