<?php
namespace app\admin\controller;

use think\Controller;

class Goodscate extends Controller{
    //列表
    public function index() {
        $cate_list = db("goods_category")->paginate(10);
        $this->assign("cate_list", $cate_list);
        return $this->fetch();
    }
    
    //添加页
    public function add() {
        return $this->fetch();
    }
    
    //添加操作
    public function save() {
        db('goods_category')->insert(input());
        $this->success('添加成功',url('index'));
    }
    
    //分类编辑
    public function edit() {
        $id = input('id');
        db('goods_category')->where("cate_id=$id")->update([
            'cate_name' => input('field')
        ]);
        return ['status' => 1];
    }
    
    //批量删除
    public function delAll() {
        $id_array = input('cate_id/a');
        if(count($id_array) > 0) {
            foreach ($id_array as $key => $value) {
                if (db('goods')->where("cate_id=$value")->find()) {
                    return ['status' => 0];
                }
            }
            db('goods_category')->delete($id_array);
            return ['status' => 1];
        }
    }
    
    //逐条删除
    public function del() {
        $id = input('id');
        if (db('goods')->where("cate_id=$id")->find()) {
            return ['status' => 0];
        }
        db('goods_category')->where("cate_id=$id")->delete();
        return ['status' => 1];
    }
}