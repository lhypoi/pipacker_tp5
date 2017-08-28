<?php 
	namespace app\pipacker\controller;
	use think\Controller;
	/**
	* 
	*/
	class Photography extends Controller
	{
		
		public function index()
	    {
	    	session_start();
	    	if(!empty($_SESSION["user_info"])){
	    		$this->assign("user_info",$_SESSION["user_info"]);
	    	}else{
	    		$this->assign("user_info","");
	    	}

	    	$con = curl_init();

			curl_setopt($con,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].url('/qworks/Hot'));
			curl_setopt($con,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($con,CURLOPT_HEADER,0);
			$val =  json_decode(curl_exec($con),true);

			curl_close($con);
			$this->assign("works_list",$val["rearray"]);
	    	// print_r($this) ;
	    	// 是去到view里面对应的login文件夹下面的index页面
	    	return $this->fetch();
	    }
	}
 ?>