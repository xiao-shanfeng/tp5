<?php
namespace app\home\controller;

use think\Controller;
use app\admin\model\Category;

class Index extends Controller
{
    public function index()
    {
        $cateA=Category::where("parent_id",0)->select();
        $cateB=Category::where("parent_id",">",0)->select();
        return view("index",compact("cateA","cateB"));
    }
    public function search(){
        return ["info"=>1];
    }
}
