<?php
namespace app\api\controller;

use think\Db;
use think\Request;
use app\api\controller\baseControll;

class Article extends baseControll{
    public function getArticleList() {
        $result = db("article")->order("id DESC")->limit(4)->select();
        return jsonp(['result' => $result]);
    }
    
    public function getArticle() {
        $param=Request::instance()->param();
        $id = $param['id'];
        $result = db("article")->where("id=$id")->find();
        return jsonp(['result' => $result]);
    }
}