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
        print_r($_SESSION);
        $cart_data=[
            'goods_id'=>$cartInfo['goods_info'][0]['goods_id'],
            'goods_name'=>$cartInfo['goods_info'][0]['goods_name'],
            'goods_num'=>$cartInfo['num'],
            'goods_price'=>$cartInfo['totPrice'],
            'user_id'=>2
        ];
        db("cart")->insert($cart_data);
        return jsonp([
                "status" => 1,
                "msg" => "加入购物成功"
        ]);
    }
}