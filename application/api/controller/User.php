<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\api\controller\baseControll;

class User extends baseControll
{
    /**
     * 显示资源列表
     *
     *登录
     * 
     * @return \think\Response
     */
    public function index()
    {
        session_start();
        if(!empty($_SESSION["user_info"])){
            unset($_SESSION["user_info"]);
            $this->reJson("3");
        }else{
            $param = Request::instance()->param();
            if(!empty($param)){
               if(isset($param["user_pwd"])){
                 $param["user_pwd"]=MD5($param["user_pwd"]);
               }

               $user = Db::table("pp_user")->where($param)->find();
              
               if(!empty($user)){
                    unset($user["user_pwd"]);
                    $_SESSION["user_info"] = $user;
                    $this->reJson("0",$user);
               }else{
                $this->reJson("1");
               }
            }else{
                $this->reJson("2",array(),"数据丢失了...");
            }
        }        
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
        $param = Request::instance()->param();
        if(!empty($param)){
            $param["update_time"] = time();
            $param["user_pwd"] = MD5($param["user_pwd"]);
            if(empty($param["user_name"])){
                $param["user_name"] = "user".time();
            }
            Db::table("pp_user")->insert($param);
            $user_id = Db::table("pp_user")->getLastInsID();
            if($user_id>0){
                $this->reJson("0",$user_id,"注册成功！");
            }else{    
                $this->reJson("1",array(),"服务器处理失败！");
            }
        }else{
            $this->reJson("2",array(),"数据丢失了...");
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }

//    vue端注册接口
    public function postReg ()
    {
        $param = Request::instance()->param();
        if (!empty($param)) {
            if (!empty(Db::table("pp_user")->where('user_phone=' . $param['user_phone'])->find())) {
                $this->reJson("1", array(), "该手机号已注册！");
                exit();
            }
            $param["update_time"] = time();
            $param["user_pwd"] = MD5($param["user_pwd"]);
            if (empty($param["user_name"])) {
                $param["user_name"] = "user" . time();
            }
            unset($param['action']);
            Db::table("pp_user")->insert($param);
            $user_id = Db::table("pp_user")->getLastInsID();
            $param['user_id'] = $user_id;
            if ($user_id > 0) {
                $this->reJson("0", $param, "注册成功！");
            } else {
                $this->reJson("1", array(), "服务器处理失败！");
            }
        } else {
            $this->reJson("2", array(), "数据丢失了...");
        }
    }

    //    vue端获取用户数据接口
    public function getUserInfo()
    {
        $param = Request::instance()->param();
        unset($param['action']);
        if (!empty($param)) {
            $user = Db::table("pp_user")->where($param)->find();
            unset($user["user_pwd"]);
            $this->reJson("0", $user);
        }
    }
    public function getUserWorks()
    {
        $param = Request::instance()->param();
        unset($param['action']);
        if (!empty($param)) {
            $user = Db::table("pp_works")->where($param)->select();
            $this->reJson("0", $user);
        }
    }

//    vue端登录接口
    public function postLog()
    {
        $param = Request::instance()->param();
        unset($param['action']);
        if(!empty($param)){
            if(isset($param["user_pwd"])){
                $param["user_pwd"]=MD5($param["user_pwd"]);
            }
            $user = Db::table("pp_user")->where($param)->find();

            if(!empty($user)){
                $this->reJson("0", $user, "登陆成功！");
            }else{
                $this->reJson("1",'',"登陆失败！");
            }
        }
    }
//    vue端编辑接口
    public function getUserEdit()
    {
        $param = Request::instance()->param();
        unset($param['action']);
        if(!empty($param)){
            if(isset($param["user_pwd"])){
                $param["user_pwd"]=MD5($param["user_pwd"]);
            }
            $user = Db::table("pp_user")->where('user_id='.$param['user_id'])->update($param);

            if(!empty($user)){
                $user = Db::table("pp_user")->where('user_id='.$param['user_id'])->find();
                $this->reJson("0", $user, "修改成功！");
            }else{
                $this->reJson("1");
            }
        }
    }
}
