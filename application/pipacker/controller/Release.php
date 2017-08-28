<?php 
	namespace app\pipacker\controller;
	use think\Controller;
	/**
	* 
	*/
	class Release extends Controller
	{
		
		public function index()
	    {
	    	session_start();
            if(!empty($_SESSION["user_info"])){
                $this->assign("user_info",$_SESSION["user_info"]);
            }else{
                $this->assign("user_info","");
            }
	    	// print_r($this) ;
	    	// 是去到view里面对应的mainpage文件夹下面的index页面
	    	return $this->fetch();
	    }
	}
 ?>