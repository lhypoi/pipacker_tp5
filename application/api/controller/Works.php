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
                                ->order("pp_works.works_id desc")
                                ->limit(15)
                                ->page($param["page"])
                                ->select();

                // print_r(5*$param["page"]);

            }else{
                if(isset($param["user_id"])){
                    $user_id = $param["user_id"];
                    $pp_list = Db::table("pp_works")
                                ->join("pp_user","pp_user.user_id = pp_works.user_id")
                                ->where("pp_works.user_id=$user_id")
                                ->order("pp_works.works_id desc")
                                ->limit(15)
                                ->select();
                }else{                      
                    $pp_list = Db::table("pp_works")
                                ->join("pp_user","pp_user.user_id = pp_works.user_id")
                                ->where($param)
                                ->order("pp_works.works_id desc")
                                ->limit(15)
                                ->select();
                } 

            }
        }else{
            $pp_list = Db::table("pp_works")
                            ->join("pp_user","pp_user.user_id = pp_works.user_id")
                            ->order("pp_works.works_id desc")
                            ->limit(15)
                            ->select();

        }
        // echo Db:: ;
       if(!empty($pp_list)){  
            foreach ($pp_list as $key => $val) {
                # code...
                $tags = explode(',',$val['works_tags']);
                $pp_list[$key]['works_tags'] = $tags;
                $para = explode(',',$val['works_para']);
                $pp_list[$key]['works_para'] = $para;
            }
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
        if(!empty($param)){
            $tmp_pic_name = $_FILES['pic_src']['tmp_name'];
            $tmp_pic_type = $_FILES['pic_src']['type'];
            // print_r($param['works_tags']);
            $tags = '';
            foreach ($param['works_tags'] as $key => $value) {
                $tags .= $value;
            }
            $param['works_tags'] = $tags;
            // print_r($tags);
            // $param['works_para'] = json_encode($param['works_para']);
            foreach($tmp_pic_name as $key => $tmp_pic_names) {
                // foreach ($tmp_pic_type as $key => $tmp_pic_type) {
                    // print_r($tmp_pic_name);print_r($tmp_pic_type);exit();
                // echo $tmp_pic_type[$key];
                    $param['works_src'] = saveFile($tmp_pic_names,$tmp_pic_type[$key]);
                // }
                    $param['update_time'] = time();
                    Db::table("pp_works")->insert($param);
                    // print_r($param);
                    
            }
            // print_r($param['works_src']);exit();
            // exit();
            
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
        $param = Request::instance()->param();
        // Db::table('pp_works')
        // ->where($page);
        // ->setField("works_browse","works_browse+1");
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
    public function getTags()
    {
        //
        $param = Request::instance()->param();
        $type = $param["type"];
        // print_r($type);exit();
        if(empty($param)){
            $pp_list = Db::table("pp_works")
                        ->join("pp_user","pp_user.user_id = pp_works.user_id")
                        ->order("pp_works.works_id desc")
                        ->where("pp_works.works_type = '$type'")
                        ->limit(15)
                        ->select();
           if(!empty($pp_list)){  
                foreach ($pp_list as $key => $val) {
                    # code...
                    $tags = explode(',',$val['works_tags']);
                    $pp_list[$key]['works_tags'] = $tags;
                    $para = explode(',',$val['works_para']);
                    $pp_list[$key]['works_para'] = $para;
                }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            }
        }else{
            $page_val = $param["page"];
            $pp_list = Db::table("pp_works")
                        ->join("pp_user","pp_user.user_id = pp_works.user_id")
                        ->order("pp_works.update_time desc")
                        ->where("pp_works.works_type = '$type'")
                        ->limit(15)
                        ->select();
            if(!empty($pp_list)){ 
                foreach ($pp_list as $key => $val) {
                            # code...
                            $tags = explode(',',$val['works_tags']);
                            $pp_list[$key]['works_tags'] = $tags;
                            $para = explode(',',$val['works_para']);
                            $pp_list[$key]['works_para'] = $para;
                }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            } 
        }
    }
    /**
     * 
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function getTagsNews()
    {
        //
        $param = Request::instance()->param();
        if(empty($param)){
            $pp_list = Db::table("pp_works")
                        ->join("pp_user","pp_user.user_id = pp_works.user_id")
                        ->order("pp_works.update_time desc")
                        ->where("pp_works.works_type = '$type'")
                        ->limit(15)
                        ->select();
           if(!empty($pp_list)){  
                foreach ($pp_list as $key => $val) {
                    # code...
                    $tags = explode(',',$val['works_tags']);
                    $pp_list[$key]['works_tags'] = $tags;
                    $para = explode(',',$val['works_para']);
                    $pp_list[$key]['works_para'] = $para;
                }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            }
        }else{
            $page_val = $param["page"];
            $pp_list = Db::table("pp_works")
                        ->join("pp_user","pp_user.user_id = pp_works.user_id")
                        ->order("pp_works.update_time desc")
                        ->where("pp_works.works_type = '$type'")
                        ->limit(15*$page_val,15)
                        ->select();
            if(!empty($pp_list)){ 
                foreach ($pp_list as $key => $val) {
                            # code...
                            $tags = explode(',',$val['works_tags']);
                            $pp_list[$key]['works_tags'] = $tags;
                            $para = explode(',',$val['works_para']);
                            $pp_list[$key]['works_para'] = $para;
                }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            } 
        }
    }
    //按浏览量排序
    public function getTagsHot()
    {
        //
        $param = Request::instance()->param();
        if(empty($param['page'])){
            $pp_list = Db::table("pp_works")
                            ->join("pp_user","pp_user.user_id = pp_works.user_id")
                            ->order("pp_works.works_browse desc")
                            ->where("pp_works.works_type = '$type'")
                            ->limit(15)
                            ->select();
            if(!empty($pp_list)){
             foreach ($pp_list as $key => $val) {
                        # code...
                        $tags = explode(',',$val['works_tags']);
                        $pp_list[$key]['works_tags'] = $tags;
                        $para = explode(',',$val['works_para']);
                        $pp_list[$key]['works_para'] = $para;
                    }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            }
        }else{
            $page_val = $param["page"];
            $pp_list = Db::table("pp_works")
                            ->join("pp_user","pp_user.user_id = pp_works.user_id")
                            ->order("pp_works.works_browse desc")
                            ->where("pp_works.works_type = '$type'")
                            ->limit(15)
                            ->page($page_val)
                            ->select();
            if(!empty($pp_list)){
                foreach ($pp_list as $key => $val) {
                            # code...
                            $tags = explode(',',$val['works_tags']);
                            $pp_list[$key]['works_tags'] = $tags;
                            $para = explode(',',$val['works_para']);
                            $pp_list[$key]['works_para'] = $para;
                }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            }
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
           if(!empty($pp_list)){  
                foreach ($pp_list as $key => $val) {
                    # code...
                    $tags = explode(',',$val['works_tags']);
                    $pp_list[$key]['works_tags'] = $tags;
                    $para = explode(',',$val['works_para']);
                    $pp_list[$key]['works_para'] = $para;
                }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            }
        }else{
            $page_val = $param["page"];
            $pp_list = Db::table("pp_works")
                        ->join("pp_user","pp_user.user_id = pp_works.user_id")
                        ->order("pp_works.update_time desc")
                        ->limit(15*$page_val,15)
                        ->select();
            if(!empty($pp_list)){ 
                foreach ($pp_list as $key => $val) {
                            # code...
                            $tags = explode(',',$val['works_tags']);
                            $pp_list[$key]['works_tags'] = $tags;
                            $para = explode(',',$val['works_para']);
                            $pp_list[$key]['works_para'] = $para;
                }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            } 
        }
    }
    public function getApic()
     {
        //
        $param = Request::instance()->param();
        // var_dump(Request::instance());

		 session_start();

        if(!empty($_SESSION["user_info"])){
            $user_id = $_SESSION["user_info"]["user_id"];
        }else{
            $user_id = null;
        }
        if(!empty($param)){
            unset($param["action"]);
            if(isset($param["browse"])){
                $ew = $param["browse"];
                $id = $param["works_id"];
                unset($param["browse"]);
                //上一张和下一张
                if(1==$ew){
                    $pic = Db::table("pp_works")->order('works_id desc')->where("works_id<$id")
                    ->join("pp_user","pp_user.user_id = pp_works.user_id")->limit(1)->find();
                    $allpic = Db::table("pp_works")->order('pp_works.works_id asc')
					->where("pp_works.works_id<$id")
					->join("pp_user","pp_user.user_id = pp_works.user_id")
                    // ->join("pp_collect","pp_collect.user_id = pp_works.user_id")
					->limit(10)->select();
                    // print_r($pic);				
                }else if(0==$ew){
                    $pic = Db::table("pp_works")->order('works_id asc')->where("works_id>$id")
                    ->join("pp_user","pp_user.user_id = pp_works.user_id")->limit(1)->find();
                    $allpic = Db::table("pp_works")->order('pp_works.works_id asc')
					->where("pp_works.works_id>$id")                   
                    // ->join("pp_collect","pp_collect.user_id = pp_user.user_id pp_collect = pp_works.works_id")

					->join("pp_user","pp_user.user_id = pp_works.user_id")
					->limit(10)->select();
                }			
				Db::table("pp_works")->where("works_id=$id")->setInc('works_browse');
                if(!empty($pic)){   
                    $tags = explode(',',$pic['works_tags']);
                    $pic['works_tags'] = $tags;
                    $para = explode(',',$pic['works_para']);
                    $pic['works_para'] = $para;
                    foreach ($allpic as $key => $val) {
                        # code...
                        if(null==$user_id){
                            $allpic[$key]["collect_val"] = 0;
                        }else{
                            $collect_val = Db::table("pp_collect")->where(array("works_id"=>$val["works_id"],"user_id"=>$val["user_id"]))->find();
                            if(!empty($collect_val)){
                                 $allpic[$key]["collect_val"] = 1;
                            }else{
                                 $allpic[$key]["collect_val"] = 0;
                            }
                        }
                        $tags = explode(',',$val['works_tags']);
                        $allpic[$key]['works_tags'] = $tags;
                        $para = explode(',',$val['works_para']);                     
                        unset($allpic[$key]["user_pwd"]);
                        $allpic[$key]['works_para'] = $para;
                    }
                    // print_r($para);
                    $redata["pic"] = $pic;
                    $redata["allpic"] = $allpic;
                    $this->reJson("0",$redata);
                }else{
                    $this->reJson("1");
                }
            }else{
                $id = $param["works_id"];
                $pp_list = Db::table("pp_works")
                                ->where($param)
                                ->join("pp_user","pp_user.user_id = pp_works.user_id")
                                ->find();
				Db::table("pp_works")->where("works_id=$id")->setInc('works_browse');
                $allpic =  Db::table("pp_works")->order('pp_works.works_id asc')->where("pp_works.works_id>=$id")
				->join("pp_user","pp_user.user_id = pp_works.user_id")
                 // ->join("pp_collect","pp_collect.works_id = pp_works.works_id")
				->limit(10)->select();
                if(!empty($pp_list)){
                    $tags = explode(',',$pp_list['works_tags']);
                    $para = explode(',',$pp_list['works_para']);
                    foreach ($allpic as $key => $val) {
                        # code...
                        if(null==$user_id){
                            $allpic[$key]["collect_val"] = 0;
                        }else{
                            $collect_val = Db::table("pp_collect")->where(array("works_id"=>$val["works_id"],"user_id"=>$user_id))->find();
                            if(!empty($collect_val)){
                                 $allpic[$key]["collect_val"] = 1;
                            }else{
                                 $allpic[$key]["collect_val"] = 0;
                            }
                        }
                        $tags = explode(',',$val['works_tags']);
                        $allpic[$key]['works_tags'] = $tags;
                        $para = explode(',',$val['works_para']);
                        unset($allpic[$key]["user_pwd"]);
                        $allpic[$key]['works_para'] = $para;
                    }
                    $pp_list['works_tags'] =$tags;
                    $pp_list['works_para'] =$para;
                    $redata["pic"] = $pp_list;
                    $redata["allpic"] = $allpic;
                    $this->reJson("0",$redata);
                }else{
                    $this->reJson("1",$pp_list,'没有数据');
                }  
            }
        }else{
            $this->reJson("2",$param,"没有值");
        }
    }
	//搜索api
    public function getSearch(){
        $param = Request::instance()->param();
        if(!empty($param)){
            if(isset($param["page"])){
                $page = $param["page"];
				unset($param["page"]);
            }else{       
                $page = 1;
            }
            $pp_list = Db::table("pp_works")
                           ->join("pp_user","pp_user.user_id = pp_works.user_id")
                           ->where('works_title|works_profile|works_para|works_type|user_name','like','%'.$param["key_word"].'%')
                           ->limit(15)
                           ->page($page)
                           ->select();
			foreach ($pp_list as $key => $val) {
                        # code...
                        $tags = explode(',',$val['works_tags']);
                        $pp_list[$key]['works_tags'] = $tags;
                        $para = explode(',',$val['works_para']);
                        $pp_list[$key]['works_para'] = $para;
                    }
            $this->reJson("0",$pp_list);
        }else{
             $this->reJson("1");
        }
    }
    //按浏览量排序
    public function getHot()
    {
        //
        $param = Request::instance()->param();
        if(empty($param['page'])){
            $pp_list = Db::table("pp_works")
                            ->join("pp_user","pp_user.user_id = pp_works.user_id")
                            ->order("pp_works.works_browse desc")
                            ->limit(15)
                            ->select();
            if(!empty($pp_list)){
             foreach ($pp_list as $key => $val) {
                        # code...
                        $tags = explode(',',$val['works_tags']);
                        $pp_list[$key]['works_tags'] = $tags;
                        $para = explode(',',$val['works_para']);
                        $pp_list[$key]['works_para'] = $para;
                    }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            }
        }else{
            $page_val = $param["page"];
            $pp_list = Db::table("pp_works")
                            ->join("pp_user","pp_user.user_id = pp_works.user_id")
                            ->order("pp_works.works_browse desc")
                            ->limit(15)
                            ->page($page_val)
                            ->select();
            if(!empty($pp_list)){
                foreach ($pp_list as $key => $val) {
                            # code...
                            $tags = explode(',',$val['works_tags']);
                            $pp_list[$key]['works_tags'] = $tags;
                            $para = explode(',',$val['works_para']);
                            $pp_list[$key]['works_para'] = $para;
                }
                $this->reJson("0",$pp_list); 
            }else{
               $this->reJson("1");  
            }
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

    public function getDetail(){
        $param=Request::instance()->param();
        $works_id=$param['works_id'];

        $works_de=db("works")
            ->field('pp_works.*,
                user.user_name,
                user.user_profile
            ')
            ->join("user","user.user_id=pp_works.user_id AND pp_works.works_id=$works_id")
//            ->where('works_id='.$works_id)
            ->select();
        $this->reJson($works_de);
    }
}
