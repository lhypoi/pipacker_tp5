<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\api\controller\baseControll;

class Home extends baseControll
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $param = Request::instance()->param();
        $id=$param["user_id"];
        $pp_list = Db::table("pp_user")
                ->where("user_id=$id")
                ->select();
        if(!empty($pp_list)){                
            $this->reJson("0",$pp_list); 
        }else{
           $this->reJson("1");
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
        $param = Request::instance()->param();

        $id=$param["user_id"];
        // 获取文件
        $files = Request()->file("user_bg");
        $info = $files->move("upload");
        if ($info){
            // 图片保存成功
            $param['user_bg'] = '/public/upload/'.$info->getSaveName();
            Db::table("pp_user")
                ->where("user_id=$id")
                ->update($param);
                // print_r($info);
            $this->reJson("1",$param['user_bg'],"成功更新");
        }else{
            // print_r($info);
            $this->reJson("0",array(),"数据丢失了...");exit();
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
    public function update()
    {
        $param = Request::instance()->param();
        if(!empty($param)){
            $wid=$param["user_id"];
            Db::table("pp_user")
                    ->where("user_id=$wid")
                    ->update($param);
            $this->reJson("1",$param,"成功更新");
        }else{
            $this->reJson("0",array(),"数据丢失了...");
        }
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

    public function savehead(Request $request)
    {
        $param = Request::instance()->param();

        $id=$param["user_id"];
        // 获取文件
        $files = Request()->file("user_photo");
        $info = $files->move("upload");
        if ($info){
            // 图片保存成功
            $param['user_photo'] = '/public/upload/'.$info->getSaveName();
            Db::table("pp_user")
                ->where("user_id=$id")
                ->update($param);
            $this->reJson("1",$param['user_photo'],"成功更新");
        }else{
            $this->reJson("0",array(),"数据丢失了...");exit();
        }  
    }
}

