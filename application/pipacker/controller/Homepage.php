<?php 
	namespace app\pipacker\controller;
	use think\Controller;
	/**
	* 
	*/
	class Homepage extends Controller
	{
		
		public function index()
	    {
	    	// print_r($this) ;
	    	// 是去到view里面对应的mainpage文件夹下面的index页面
	    	session_start();
            if(!empty($_SESSION["user_info"])){
                $this->assign("user_info",$_SESSION["user_info"]);
            }else{
                $this->assign("user_info","");
            }
            if(!empty($_SESSION["user_profile"])){
                $this->assign("user_profile",$_SESSION["user_profile"]);
            }else{
                $this->assign("user_profile","");
            }
            $con = curl_init();

			curl_setopt($con,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].url('/api/home'));
			curl_setopt($con,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($con,CURLOPT_HEADER,0);

			 $val =  json_decode(curl_exec($con),true);

			 curl_close($con);
	    	return $this->fetch();
	    }
	}
 ?>