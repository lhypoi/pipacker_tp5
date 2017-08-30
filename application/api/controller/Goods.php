<?php
/**
 * Created by PhpStorm.
 * User: Xing
 * Date: 2017/8/22
 * Time: 11:02
 */

namespace app\api\controller;

use think\Cache;
use think\Controller;
use think\Request;
use think\Db;
use app\api\controller\baseControll;

class Goods extends baseControll
{
    public function goodsList()
    {
        $page=input('page');
        Cache::rm("goods_list");
        if($page>1){
            $list=db("goods")
                ->alias('g')
                ->field("*")
                ->join("goods_category c","c.cate_id = g.cate_id")
                ->order('g.goods_id desc')
                ->select();
//            $list=db("goods")
//                ->order('goods_id desc')
//                ->paginate(3);
        }else{
            $list=Cache::get('goods_list');
            if(empty($list)){
                $list=db("goods")
                    ->alias('g')
                    ->field("*")
                    ->join("goods_category c","c.cate_id = g.cate_id")
                    ->order('g.goods_id desc')
                    ->select();
            }
            Cache::set('goods_list',$list);
        }
        return jsonp($list);
//api
    }

    public function getgoodsdetail(){
        $param=Request::instance()->param();
        $goods_id=$param['id'];
        $attr_list=db("goods")
            ->where('goods_id='.$goods_id)
            ->select();
        return jsonp([
            'goods_attr'=>$attr_list
        ]);
    }

    public function addCart(){
        session_start();
        $param=Request::instance()->param();
        $cartInfo=$param['cartdata'];
        //print_r($_SESSION);
        $check = db("cart")->where("goods_id='{$cartInfo['goods_info'][0]['goods_id']}' AND user_id='{$cartInfo['user_id']}'")->find();
        if(!empty($check)) {
            db("cart")
                ->where("goods_id='{$cartInfo['goods_info'][0]['goods_id']}' AND user_id='{$cartInfo['user_id']}'")
                ->update([
                    'goods_num' => $cartInfo['nums'] + $check['goods_num'],
                    'goods_price' => $cartInfo['totPrice'] + $check['goods_price']
                ]);
        }else{
            $cart_data=[
                'goods_id'=>$cartInfo['goods_info'][0]['goods_id'],
                'goods_name'=>$cartInfo['goods_info'][0]['goods_name'],
                'goods_num'=>$cartInfo['nums'],
                'goods_price'=>$cartInfo['totPrice'],
                'user_id'=>$cartInfo['user_id']
            ];
            db("cart")->insert($cart_data);
        }
        return jsonp([
                "status" => 1,
                "msg" => "加入购物成功"
        ]);
    }
    
    //获取购物车信息
    public function getCartInfo() {
        $param=Request::instance()->param();
        $user_id = $param['id'];
        $goods_list = db("cart")->where("user_id=$user_id")->order("id DESC")->select();
        foreach ($goods_list as $key => $value) {
            $goods_id = $value['goods_id'];
            $imgs = db("goods")->where("goods_id=$goods_id")->field("goods_img")->find();
            $img = explode(",", $imgs['goods_img']);
            $goods_list[$key]['goods_img'] = $img[0];
            $numbers = db("goods")->where("goods_id=$goods_id")->field("goods_number")->find();
            $goods_list[$key]['goods_number'] = $numbers['goods_number'];
        }
        return jsonp(['goods_attr' => $goods_list]);
    }
    
    //修改购物车信息
    public function updateCart() {
        $param=Request::instance()->param();
        $user_id = $param['u_id'];
        $goods_id = $param['g_id'];
        $nums = $param['nums'];
        db("cart")->where("goods_id=$goods_id AND user_id=$user_id")->update(['goods_num'=>$nums]);
        return jsonp(1);
    }
    
    //删除购物车商品
    public function delGoods() {
        $param=Request::instance()->param();
        $user_id = $param['u_id'];
        $goods_id = $param['g_id'];
        db("cart")->where("goods_id=$goods_id AND user_id=$user_id")->delete();
        return jsonp(1);
    }
    
    //提交订单
    public function submitOrder() {
        $param=Request::instance()->param();
        $data = [
            'receive_id' => $param['data']['receive_id'],
            'order_sn' => $param['data']['order_sn'],
            'total_num' => $param['data']['total_num'],
            'total_price' => $param['data']['total_price'],
            'time' => $param['data']['time']
        ];
        $result = db("order")->insert($data);
        //$result = 1;
        return jsonp(['result' => $result]);
    }
    
    //记录订单中的商品
    public function submitOrderGoods() {
        $param=Request::instance()->param();
        for ($i = 0; $i < count($param['data']); $i ++) {
            $data = [
                'order_sn' => $param['sn'],
                'goods_id' => $param['data'][$i]['goods_id'],
                'goods_name' => $param['data'][$i]['goods_name'],
                'goods_img' => $param['data'][$i]['goods_img'],
                'goods_num' => $param['data'][$i]['goods_num'],
                'goods_price' => $param['data'][$i]['goods_price']
            ];
            db("order_goods")->insert($data);
            db("cart")->where("id={$param['data'][$i]['id']}")->delete();
        }
        return jsonp(1);
    }
    
    //获取最新订单信息
    public function getConfirm() {
        $param = Request::instance()->param();
        $sn = $param['sn'];
        $attr_list = db("order")->where("order_sn=$sn")->find();
        $goods_attr = db("order_goods")->where("order_sn={$attr_list['order_sn']}")->select();
        return jsonp([
            'goods_attr' => $goods_attr,
            'attr_list' => $attr_list
        ]);
    }
    
    //订单列表
    public function getOrder() {
        $param = Request::instance()->param();
        $id = $param['id'];
        $attr_list = db("order")->where("receive_id=$id")->select();
        $goods_attr = array();
        for ($i = 0; $i < count($attr_list); $i ++) {
            $goods_attr[$i] = db("order_goods")->where("order_sn={$attr_list[$i]['order_sn']}")->select();
        }
        return jsonp([
            'goods_attr' => $goods_attr,
            'attr_list' => $attr_list
        ]);
    }
}