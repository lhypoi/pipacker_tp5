<?php
namespace app\api\controller;

use think\Request;
use think\Db;
use think\Paginator;

class message extends baseControll{
    public function getNotice() {
        $param = Request::instance()->param();
        $id = $param['u_id'];
        $sub = Db::table("pp_notice")->where("to_user=$id")->order("id DESC")->buildSql();
        $result = Db::table($sub.' a')->order("id DESC")->group("from_user")->paginate(10);
        $new_msg = array();
        $name = array();
        for($i = 0; $i < count($result); $i ++) {
            $name[$i] = db("admin")->where("id={$result[$i]['from_user']}")->column("name");
            $new_msg[$i] = Db::table("pp_notice")->where("from_user={$result[$i]['from_user']} AND to_user=$id AND status=0")->count();
        }
        //print_r($result);
        return jsonp([
            'result' => $result,
            'new_msg' => $new_msg,
            'name' => $name
        ]);
    }
    
    public function getPrivateMsg() {
        $param = Request::instance()->param();
        $id = $param['u_id'];
        $sub = Db::table("pp_private_msg")->where("to_user=$id")->order("id DESC")->buildSql();
        $result = Db::table($sub.' a')->order("id DESC")->group("from_user")->paginate(10);
        $new_msg = array();
        $name = array();
        for($i = 0; $i < count($result); $i ++) {
            $name[$i] = db("user")->where("user_id={$result[$i]['from_user']}")->column("user_name");
            $new_msg[$i] = Db::table("pp_private_msg")->where("from_user={$result[$i]['from_user']} AND to_user=$id AND status=0")->count();
        }
        //print_r($result);
        return jsonp([
            'result' => $result,
            'new_msg' => $new_msg,
            'name' => $name
        ]);
    }
    
    public function getNoticeList() {
        $param = Request::instance()->param();
        $id = $param['u_id'];
        $from_id = $param['from_id'];
        $name = array();
        $result = db("notice")->where("from_user=$from_id AND to_user=$id")->order("id DESC")->select();
        for($i = 0; $i < count($result); $i ++) {
            $name[$i] = db("admin")->where("id={$result[$i]['from_user']}")->column("name");
        }
        return jsonp([
            'result' => $result,
            'name' => $name
        ]);
    }
    
    public function getMsgList() {
        $param = Request::instance()->param();
        $id = $param['u_id'];
        $from_id = $param['from_id'];
        $name = array();
        $result = db("private_msg")->where("from_user=$from_id AND to_user=$id")->order("id DESC")->select();
        for($i = 0; $i < count($result); $i ++) {
            $name[$i] = db("user")->where("user_id={$result[$i]['from_user']}")->column("user_name");
        }
        return jsonp([
            'result' => $result,
            'name' => $name
        ]);
    }
}