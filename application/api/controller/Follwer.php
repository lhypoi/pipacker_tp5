<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\api\controller\baseControll;

class Follwer extends baseControll
{
    /**
     * ÏÔÊ¾×ÊÔ´ÁÐ±í
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        //
        $param = Request::instance()->param();
        if(!empty($param)){
            $follwer_list = Db::table("pp_follower")
                            ->where($param)
                            ->join("pp_user","pp_user.user_id = pp_follower.follower.user")
                            ->field("pp_user.user_name,pp_user.user_phone,pp_user.user_photo,pp_user.user_id")
							->order("pp_comment.update_time desc")
                            ->limit(10)
                            ->select();
            $this->reJson("0",$follwer_list);
        }else{
            $this->reJson("1",array(),"Êý¾Ý¶ªÊ§ÁË...");
        }
    }

    /**
     * ÏÔÊ¾´´½¨×ÊÔ´±íµ¥Ò³.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * ±£´æÐÂ½¨µÄ×ÊÔ´
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
            // $param['works_src'] = saveFile('pic_src');
            Db::table("pp_follwer")->insert($param);
            $redata["follwer_id"] =  Db::table("pp_follwer")->getLastInsID();
            $this->reJson("0",$redata,"成功插入");
        }else{
            $this->reJson("2",array(),"数据丢失了...");
        }
    }

    /**
     * ÏÔÊ¾Ö¸¶¨µÄ×ÊÔ´
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
		 $param = Request::instance()->param();
        // print_r($_FILES['works_src']);
        if(!empty($param)){
            unset($param['id']);
            $follwer_list = Db::table("pp_follwer")
                                ->where('pp_follwer.user_id='.$param['user_id'])
                                ->join("pp_user","pp_user.user_id = pp_follwer.follwer_user")
                                ->field("pp_user.user_name,pp_user.user_phone,pp_user.user_photo,pp_user.user_id")
                                ->select();
            if(!empty($follwer_list)){
                $this->reJson("1",$follwer_list,"读取成功...");
            }else{
                $this->reJson("2",array(),"服务器处理失败");
            }
		}else{
			$this->reJson("3",array(),"数据丢失了...");
		}
    }

    /**
     * ÏÔÊ¾±à¼­×ÊÔ´±íµ¥Ò³.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * ±£´æ¸üÐÂµÄ×ÊÔ´
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
     * É¾³ýÖ¸¶¨×ÊÔ´
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
		$param = Request::instance()->param();
		if(!empty($param)){
		unset($param["id"]);
		if(Db::table("pp_follwer")->where($param)->delete()){
			$this->reJson("0",array(),"取消关注");
		}else{
			$this->reJson("2",array(),"服务器处理失败");
		}
		}else{
		$this->rejson("1",array(),"数据丢失了...");
		}
    }
}
