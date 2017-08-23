<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Goods extends Controller{
    //列表显示
    public function index() {
        $goods_list = db("goods")->paginate(10);
        $this->assign("goods_list", $goods_list);
        return $this->fetch();
    }
    
    //跳转至编辑页面
    public function edit() {
        $id = input('id');
        $info = db('goods')->where("goods_id=$id")->find();
        $arr = array();
        if($info['goods_img'] != '') {
            $arr = explode(",", $info['goods_img']);
        }
        $cate_list = db('goods_category')->select();
        $this->assign('cate_list', $cate_list);
        $this->assign('arr', $arr);
        $this->assign('info', $info);
        return $this->fetch();
    }
    
    //跳转至商品添加页面
    public function add() {
        $cate_list = db('goods_category')->select();
        $this->assign('cate_list', $cate_list);
        return $this->fetch();
    }
    
    //商品编辑
    public function save() {
        $id = input('id');
        $img = db('goods')->where("goods_id=$id")->find();
        if($img['goods_img'] != '') {
            $del = explode(",", input('del_photo'));
            if($del[0] != '') {
                $arr = explode(",", $img['goods_img']);
                for ($i = 0; $i < count($del); $i ++) {
                    $filename = ROOT_PATH.$arr[$del[$i]];
                    if(file_exists($filename)) {
                        unlink($filename);
                    }else{
                        return $filename;
                    }
                    unset($arr[$del[$i]]);
                }
                $img['goods_img'] = implode(",", $arr);
            }
        }
        if(!empty($_FILES['pic_file']['tmp_name'])) {
            $info = Request()->file("pic_file")->validate(["ext"=>"jpg,png,gif"])->move("upload");
            if($info) {
                $pic = '/public/upload/'.$info->getSaveName();
                if ($img['goods_img'] != '') {
                    $img['goods_img'] = ','.$img['goods_img'];
                }
                db('goods')->where("goods_id=$id")->update([
                    'goods_name' => input('name'),
                    'goods_number' => input('num'),
                    'goods_price' => input('price'),
                    'cate_id' => input('cate'),
                    'goods_img' => $pic.$img['goods_img']
                ]);
                return ['status' => 1];
            }
        }else{
            db('goods')->where("goods_id=$id")->update([
                'goods_name' => input('name'),
                'goods_number' => input('num'),
                'goods_price' => input('price'),
                'cate_id' => input('cate'),
                'goods_img' => $img['goods_img']
            ]);
            return ['status' => 1];
        }
    }
    
    //商品添加
    public function do_add() {
        $arr = array();
        $arr['goods_name'] = input('goods_name');
        $arr['cate_id'] = input('cate_id');
        $arr['goods_number'] = input('goods_number');
        $arr['goods_price'] = input('goods_price');
        $arr['goods_img'] = input('goods_img');
        if(!empty($_FILES['goods_img']['tmp_name'])) {
            $info = Request()->file("goods_img")->validate(["ext"=>"jpg,png,gif"])->move("upload");
            if($info) {
                $pic = '/public/upload/'.$info->getSaveName();
                $arr['goods_img'] = $pic;
            }
        }
        db('goods')->insert($arr);
        $this->success('添加成功',url('index'));
    }
    
    //商品删除
    public function del() {
        $id = input('id');
        //db('goods')->where("goods_id=$id")->delete();
        return ['status' => 1];
    }
    
    //批量删除
    public function delAll() {
        $id_array = input('goods_id/a');
        if(count($id_array) > 0) {
            //db('goods')->delete($id_array);
            return ['status' => 1];
        }
    }
}