<?php
namespace app\admin\controller;

use think\Controller;

class Goods extends Controller{
    public function index() {
        $goods_list = db("goods")->paginate(10);
        $this->assign("goods_list", $goods_list);
        return $this->fetch();
    }
}