<?php 
	namespace app\pipacker\controller;
	use think\Controller;
	/**
	* 
	*/
	class Mainpage extends Controller
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
	    	// print_r($_SERVER['HTTP_HOST']);
	    	// echo $_SERVER['HTTP_HOST'].url('/works');
			 // $con = curl_init((string)'http://'.$_SERVER['HTTP_HOST'].'/'.url('/works'));
			$con = curl_init();

			curl_setopt($con,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].url('/qworks/Hot'));
			curl_setopt($con,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($con,CURLOPT_HEADER,0);

			 // curl_setopt($con, CURLOPT_HEADER, false);
			 // curl_setopt($con, CURLOPT_POSTFIELDS, "10");
			 // // curl_setopt($con, CURLOPT_POST,true);
			 // curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
			 // curl_setopt($con, CURLOPT_TIMEOUT,(int)"3000");
			 $val =  json_decode(curl_exec($con),true);

			 curl_close($con);
			 
			 $this->assign("works_list",$val["rearray"]);
	    	 return $this->fetch();
	    }
	}
 ?>