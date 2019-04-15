<?php

namespace app\home\controller;

use app\admin\model\Goods;
use app\home\model\Cart;
use app\home\model\Consignee;
use think\Controller;
use think\Request;

class Shop extends Controller
{
    public function add(Request $request){
        $data=$request->post();
//        p($data);die;
        $goods_id=$data["goods_id"];
        $goods_attrs=$data["attr"];
        $goods_buy_number=$data["goods_buy_number"];
        $goods_info=Goods::field("id,goods_name,goods_thumb")->where("id",$goods_id)->find();
        $cart=new Cart();
        $cart->addCart($goods_id,$goods_attrs,$goods_buy_number);
        $attrs="";
        foreach ($goods_attrs as $k=>$v){
            $attrs.=getAttributeName($k)."：".$v."  ";
        }
        return view("add-res",compact("attrs","goods_buy_number","goods_info"));
    }
    public function cartinfo(){
        $cart=new Cart();
        $cartData=$cart->cartInfo();
        $total=$cart->getCartTotal();
        return view("cart",compact("cartData","total"));
    }
    public function delcart(Request $request){
        $uid=$request->param("uid");
        $cart=new Cart();
        $cart->delCart($uid);
        return $this->redirect("home/shop/cartinfo");
    }
    public function updatacart(Request $request){
        $uid=$request->param("uid");
        $cart=new Cart();
        $cart->updateCart($uid,1);
        return ["info"=>1];
    }
    public function checkout(){
        $cart=new Cart();
        $cartinfo=$cart->cartInfo();
        $total=$cart->getCartTotal();
        if (empty($cartinfo)){
            $this->error("购物车为空,不能进行结算");
        }
        if (!session("?user_id")){
            cookie("back_url","home/shop/checkout");
            return $this->redirect("home/user/login");
        }
        $user_id=session("user_id");
        $consignee=Consignee::where("user_id",$user_id)->select();
        foreach ($consignee as $v){
            $v["tel"]=preg_replace("/^(\d{3})(\d{4})(\d{4})$/","$1****$2",$v["tel"]);
        }
//        p($cartinfo);p($total);p($consignee);die;
        return view("checkout",compact("cartinfo","consignee","total"));
    }
}
