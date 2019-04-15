<?php

namespace app\home\controller;

use app\home\model\Cart;
use app\home\model\OrderGoods;
use think\Controller;
use think\Request;
use app\home\model\Order as OrderModel;

class Order extends Controller
{
    public function done(Request $request){
        if($request->isPost()){
            $fp = fopen('./1.txt','w');
            flock($fp,LOCK_EX);
            $data = $request->param();
            $user_id = session('user_id');
            //订单货号
            $order_sn = 'sn_'.uniqid();
            $cart = new Cart();
            //订单总金额
            $order_price = $cart->getCartTotal();
            $order_pay = $data['order_pay'];
            $adress = $data['address'];
            //入库订单表
            $order = OrderModel::create([
                'user_id'=>$user_id,
                'order_sn'=>$order_sn,
                'order_price'=>$order_price['total_price'],
                'order_pay'=>$order_pay,
                'address'=>$adress
            ],true);
            //入库订单商品关联表
            $cartData = $cart->cartInfo();
//            echo "<pre>";
//           var_dump($cartData);die();
            foreach ($cartData as $v){
                OrderGoods::create([
                    'order_id'=>$order->id,
                    'goods_id'=>$v['goods_id'],
                    'goods_price'=>$v['info']['shop_price'],
                    'goods_number'=>$v['goods_buy_number'],
                    'goods_price_sum'=>$order_price['total_price'],
                    'goods_attrs'=>$v['goods_attrs']
                ]);
            }
            flock($fp,LOCK_UN);
            $cart->clearCart();
            $this->redirect('home/order/pay',['id'=>$order->id]);
        }
    }
    public  function pay(Request $request){
        $id = $request->param('id');
        $info = \app\home\model\Order::find($id);
        return view('pay',compact('info'));
    }

    public function makepay(){
        require_once EXTEND_PATH.'alipay/config.php';

        require_once EXTEND_PATH.'alipay/pagepay/service/AlipayTradeService.php';

        require_once EXTEND_PATH.'alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php';

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($_POST['WIDout_trade_no']);

        //订单名称，必填
        $subject = trim($_POST['WIDsubject']);
        //付款金额，必填
        $total_amount = trim($_POST['WIDtotal_amount']);

        //商品描述，可空
        $body = trim($_POST['WIDbody']);

        //构造参数
        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $aop = new \AlipayTradeService($config);
        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
        //输出表单
        var_dump($response);

    }
    public function callback(){
        require_once(EXTEND_PATH.'alipay/config.php');
        require_once EXTEND_PATH.'alipay/pagepay/service/AlipayTradeService.php';
        $arr=$_GET;

        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($arr);
        if($result) {//验证成功
            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            //支付金额
            $total_amount = $_GET['total_amount'];
//            echo "验证成功<br />支付宝交易号：".$trade_no;

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            OrderModel::where('order_sn',$out_trade_no)->update([
                'order_pay_money'=>$total_amount,
                'order_status'=>1,
                'trade_no'=>$trade_no
            ]);
            return view('callback',compact('total_amount'));
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }
}
