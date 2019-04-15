<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Image;
use think\Request;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Category as CategoryModel;
use think\Validate;

class Goods extends Base
{
    public function index(){
        $data=GoodsModel::with("category")->select();
        return view("index",compact("data"));
    }
    public function add(Request $request){
        if ($request->isGet()){
            $data=getCategoryTree(CategoryModel::select());
            return view("add",compact("data"));
        }elseif ($request->isPost()){
            $data=$request->post();
            $rules=[
                "goods_name"=>"require|unique:goods,goods_name",
                "cat_id"=>"require|number",
                "shop_price"=>"require|float",
                "market_price"=>"require|float",
                "goods_number"=>"require|number",
                "is_new"=>"require|in:0,1",
                "is_hot"=>"require|in:0,1",
                "is_best"=>"require|in:0,1",
                "is_sale"=>"require|in:0,1",
                "goods_desc"=>"require|min:5"
            ];
            $msg=[
                "goods_name.require"=>"商品名称不能为空",
                "goods_name.unique"=>"商品名称不能重复",
                "cat_id.require"=>"所属栏目不能为空",
                "cat_id.number"=>"所属栏目数据格式不符合",
                "shop_price.require"=>"本店价格不能为空",
                "shop_price.float"=>"本店价格数据格式不符合",
                "market_price.require"=>"市场价格不能为空",
                "market_price.float"=>"市场价格数据格式不符合",
                "goods_number.require"=>"商品库存不能为空",
                "goods_number.number"=>"商品库存数据格式不符合",
                "is_new.require"=>"新品数据不能为空",
                "is_new.in"=>"新品数据异常",
                "is_hot.require"=>"热销数据不能为空",
                "is_hot.in"=>"热销数据异常",
                "is_best.require"=>"精品数据不能为空",
                "is_best.in"=>"精品数据异常",
                "is_sale.require"=>"上架数据不能为空",
                "is_sale.in"=>"上架数据异常",
                "goods_desc.require"=>"商品描述不能为空",
                "goods_desc.min"=>"商品描述最少5个字符"
            ];
            $validate=new Validate($rules,$msg);
            if ($validate->batch()->check($data)){
                $data["goods_intro"]=$request->param("goods_intro","","removeXss");
                $data["goods_attr"]=serialize($data["attr"]);
                $res=GoodsModel::create($data,true);
                if ($res){
                    return ["info"=>1];
                }else{
                    return ["info"=>0,"msg"=>"商品入库失败"];
                }
            }else{
                $error=implode(",",$validate->getError());
                return ["info"=>0,"msg"=>$error];
            }
        }
    }
    public function upimages(Request $request){
        config("default_return_type","json");
        $file=$request->file("file");
        $path="./upload/goods/".date("Y/m/d/");
        $info=$file->rule("uniqid")->move($path);
        if ($info){
            $filename=$info->getSaveName();
            $img=Image::open($path.$filename);
            $goods_img=$path."img_".$filename;
            $img->thumb(400,400)->save($goods_img);
            $goods_thumb=$path."thumb_".$filename;
            $img->thumb(215,250)->save($goods_thumb);
            return [
                "goods_ori"=>ltrim($path.$filename,"."),
                "goods_img"=>ltrim($goods_img,"."),
                "goods_thumb"=>ltrim($goods_thumb,".")
            ];
        }
    }
    public function album(Request $request,$id){
        if ($request->isGet()){
            return view("album");
        }elseif ($request->isPost()) {
            $files = $request->file("goods_album");
            $path = "./upload/album/" . date("Y/m/d/");
            foreach ($files as $file) {
                $info=$file->rule("uniqid")->move($path);
                if ($info){
                    $filename=$info->getSaveName();
                    $goods_ori=$path.$filename;
                    $img=Image::open($goods_ori);
                    $goods_img=$path."img_".$filename;
                    $img->thumb(400,400)->save($goods_img);
                    $goods_thumb=$path."thumb_".$filename;
                    $img->thumb(56,56)->save($goods_thumb);
                    Db::name("goods_album")->insertGetId([
                        "goods_id"=>$id,
                        "album_ori"=>ltrim($path.$filename,"."),
                        "album_img"=>ltrim($goods_img,"."),
                        "album_thumb"=>ltrim($goods_thumb,".")
                    ]);
                }
            }
                echo '<script type="text/javascript" src="/static/admin/lib/jquery/1.9.1/jquery.min.js"></script>';
                echo '<script type="text/javascript" src="/static/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/admin/static/h-ui.admin/js/H-ui.admin.js"></script>';
                echo "<script>alert('success!');layer_close()</script>";
        }
    }
}
