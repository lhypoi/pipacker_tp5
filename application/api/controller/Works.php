<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\api\controller\baseControll;

class Works extends baseControll
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $param = Request::instance()->param();
        if(!empty($param)){
            if(isset($param["page"])){
                $pp_list = Db::table("pp_works")
                                ->join("pp_user","pp_user.user_id = pp_works.user_id")
                                ->limit(5*$param["page"])
                                ->select();

            }else{     
                $pp_list = Db::table("pp_works")
                                ->join("pp_user","pp_user.user_id = pp_works.user_id")
                                ->where($param)
                                ->limit(10)
                                ->select();
            }
        }else{
            $pp_list = Db::table("pp_works")
                            ->join("pp_user","pp_user.user_id = pp_works.user_id")
                            ->limit(5)
                            ->select();

        }
        // echo Db:: ;
        $this->reJson("0",$pp_list);
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
        // print_r($_FILES['works_src']);
        if(!empty($param)){
            // $param['works_para'] = json_encode($param['works_para']);
            $param['works_src'] = saveFile('pic_src');
            $param['update_time'] = time();
            Db::table("pp_works")->insert($param);
            $works_id = Db::table("pp_works")->getLastInsID();
            $this->reJson("2",$works_id,"成功插入");
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
    public function delete()
    {
        //
        $param = Request::instance()->param();
        $isdel = true;
        if(!empty($param)){
            $val = Db::table("pp_comment")->where($param)->select();
            if(!empty($val)){
                $isdel = Db::table("pp_comment")->where($param)->delete();
            }           
            if($isdel){
               $isdel_w = Db::table("pp_works")->where($param)->delete();
               if($isdel_w){
                   $this->reJson("0",array(),"删除成功！"); 
               }
            }else{
                $this->reJson("1",array(),"删除失败，稍后再试");
            }
        }else{
            $this->reJson("2",array(),"服务器并没有接收到数据，数据应该是丢失了...");   
        }
    }
    /**
     * 
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function getNews()
    {
        //
        $param = Request::instance()->param();
        if(empty($param)){
            $pp_list = Db::table("pp_works")
                        ->join("pp_user","pp_user.user_id = pp_works.user_id")
                        ->order("pp_works.update_time desc")
                        ->limit(15)
                        ->select();
            $this->reJson("0",$pp_list);
        }else{
            $page_val = $param["page"];
            $pp_list = Db::table("pp_works")
                        ->join("pp_user","pp_user.user_id = pp_works.user_id")
                        ->order("pp_works.update_time desc")
                        ->limit(15*$page_val)
                        ->select();
            $this->reJson("0",$pp_list); 
        }
    }
    public function getApic()
     {
        //
        $param = Request::instance()->param();
        // var_dump(Request::instance());
        if(!empty($param)){
            unset($param["action"]);
            if(isset($param["browse"])){
                $ew = $param["browse"];
                $id = $param["works_id"];
                unset($param["browse"]);
                //上一张和下一张
                if(1==$ew){
                    $pic = Db::table("pp_works")->order('works_id desc')->where("works_id<$id")->limit(1)->find();
                    // print_r($pic);
                }else if(0==$ew){
                    $pic = Db::table("pp_works")->order('works_id asc')->where("works_id>$id")->limit(1)->find();
                }
                if(!empty($pic)){   
                    $tags = explode(',',$pic['works_tags']);
                    $pic['works_tags'] = $tags;
                    $para = explode(',',$pic['works_para']);
                    $pic['works_para'] = $para;
                    $this->reJson("0",$pic);
                }else{
                    $this->reJson("1");
                }
            }else{  
                $pp_list = Db::table("pp_works")
                                ->where($param)
                                ->join("pp_user","pp_user.user_id = pp_works.user_id")
                                ->find();
                if(!empty($pp_list)){
                    $tags = explode(',',$pp_list['works_tags']);
                    $para = explode(',',$pp_list['works_para']);
                    $pp_list['works_tags'] =$tags;
                    $pp_list['works_para'] =$para;
                    $this->reJson("0",$pp_list);
                }else{
                    $this->reJson("1",$pp_list,'没有数据');
                }  
            }
        }else{
            $this->reJson("2",$param,"没有值");
        }
    }
    public function getHot()
    {
        //
        $param = Request::instance()->param();
        if(empty($param)){
            $pp_list = Db::table("pp_works")
                            ->join("pp_user","pp_user.user_id = pp_works.user_id")
                            ->order("pp_works.works_browse desc")
                            ->limit(4)
                            ->select();
            $this->reJson("0",$pp_list);
        }else{
            $page_val = $param["page"];
            $pp_list = Db::table("pp_works")
                            ->join("pp_user","pp_user.user_id = pp_works.user_id")
                            ->order("pp_works.works_browse desc")
                            ->limit(4*$page_val)
                            ->select();
            $this->reJson("0",$pp_list); 
        }
    }
//    根据参数获取对应的作品：分类、页数、最热or最新
    public function getWorks ()
    {
        $param = Request::instance()->param();
        $order = $param['selected'] == '0' ? "pp_works.works_browse desc" : "pp_works.update_time desc";
        $page_val = $param["page"];
        $where = $param['classify'] == '分类' ? '' : 'works_type =\''.$param['classify'].'\'';
        $pp_list = Db::table("pp_works")
            ->join("pp_user","pp_user.user_id = pp_works.user_id")
            ->where($where)
            ->order($order)
            ->page($page_val)
            ->paginate(10);
        $this->reJson("0",$pp_list);
    }
}
