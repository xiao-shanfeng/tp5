<?php

namespace app\home\model;

use app\admin\model\Goods;
use think\Model;
use traits\model\SoftDelete;

class Cart extends Model
{
    /**
     * @param $goods_id 商品id
     * @param $goods_attrs  商品对应的属性和属性值
     * @param $goods_buy_number 购买商品的数量
     */
    public function addCart($goods_id,$goods_attrs,$goods_buy_number){
        /**
         *拼接唯一字段，判断每次加入购物车是不是同一种商品
         */
        $uid=md5($goods_id.serialize($goods_attrs));
        //判断用户是否登录
        if (session("?user_id")){
            //用户登录，那就把数据保存到数据表（it_cart）中
            $user_id=session("user_id");//取出用户id
            //在数据库中，还需要判断数据库中是否存在该商品，如果有的话，就不是保存一条新数据，而是更新相应的数量
            $info=self::where("user_id",$user_id)->where("uid",$uid)->find();
            if ($info){
                //存在该商品
                self::where("user_id",$user_id)->where("uid",$uid)->setInc("goods_buy_number",$goods_buy_number);
            }else{
                //不存在该商品
                self::create([
                    "goods_id"=>$goods_id,
                    "uid"=>$uid,
                    "goods_attrs"=>serialize($goods_attrs),
                    "goods_buy_number"=>$goods_buy_number,
                    "user_id"=>$user_id
                ]);
            }
        }else{
            //用户没有登录，那就把商品信息保存到cookie里
            $data=cookie("?cart")?unserialize(cookie("cart")):[];
            if (isset($data[$uid])){
                //之前有商品保存到cookie中了
                $data[$uid]["goods_buy_number"]=$goods_buy_number;
            }else{
                //没有商品
                $data[$uid]=[
                    "goods_id"=>$goods_id,
                    "uid"=>$uid,
                    "goods_attrs"=>serialize($goods_attrs),
                    "goods_buy_number"=>$goods_buy_number
                ];
            }
            cookie("cart",serialize($data),3600*24);
        }
    }

    /**
     * 拼接购物车信息
     */
    public function cartInfo(){
        if (session("?user_id")){
            //用户登录
            $user_id=session("user_id");
            $data=self::where("user_id",$user_id)->select();
        }else{
            //cookie
            $data=cookie("?cart")?unserialize(cookie("cart")):[];
        }
        $cartData=[];
        foreach ($data as $v){
            $v["info"]=getGoodsInfo($v["goods_id"]);
            $attrs="";
            $goods_attrs=unserialize($v["goods_attrs"]);
            foreach ($goods_attrs as $kk=>$vv){
                $attrs.=getAttributeName($kk)."：".$vv."<br>";
            }
            $v["attrs"]=$attrs;
            $cartData[]=$v;
        }
        return $cartData;
    }
    public function getCartTotal(){
        $data=$this->cartInfo();
        $total_price=0;
        $total_count=0;
        if ($data){
            foreach ($data as $v){
                $total_count+=$v["goods_buy_number"];
                $total_price+=$v["goods_buy_number"]*$v["info"]["shop_price"];
            }
        }
        return [
            "total_price"=>$total_price,
            "total_count"=>$total_count
        ];
    }
    public function delCart($uid){
        if (session("?user_id")){
            $user_id=session("user_id");
            self::where("user_id",$user_id)->where("uid",$uid)->delete();
        }else{
            $data=cookie("?cart")?unserialize(cookie("cart")):[];
            unset($data[$uid]);
            cookie("cart",serialize($data),3600*24);
        }
    }
    public function updateCart($uid,$goods_buy_number){
        if (session("?user_id")){
            $user_id=session("user_id");
            self::where("user_id",$user_id)
                ->where("uid",$uid)
                ->setInc("goods_buy_number",$goods_buy_number);
        }else{
            $data=cookie("?cart")?unserialize(cookie("cart")):[];
            $data[$uid]["goods_buy_number"]+=$goods_buy_number;
            cookie("cart",serialize($data),3600*24);
        }
    }
    public function cookie2Db(){
        $data=cookie("?cart")?unserialize(cookie("cart")):[];
        if ($data){
            foreach ($data as $k=>$v){
                $user_id=session("user_id");
                $info=self::where("user_id",$user_id)->where("uid",$k)->find();
                if ($info){
                    self::where("user_id",$user_id)->where("uid",$k)->setInc("goods_buy_number",$v["goods_buy_number"]);
                }else{
                    self::create([
                        "goods_id"=>$v["goods_id"],
                        "uid"=>$k,
                        "goods_attrs"=>$v["goods_attrs"],
                        "goods_buy_number"=>$v["goods_buy_number"],
                        "user_id"=>$user_id
                    ]);
                }
            }
        }
        cookie("cart",null);
    }
    public function clearCart(){
        $user_id=session("user_id");
        self::where("user_id",$user_id)->delete();
    }
}
