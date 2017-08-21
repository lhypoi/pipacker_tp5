<?php
namespace app\admin\controller;

use think\Controller;

class Goodscate extends Controller{
    public function index() {
        $cate_list = db("goods_category")->paginate(10);
        $this->assign("cate_list", $cate_list);
        return $this->fetch();
    }
}