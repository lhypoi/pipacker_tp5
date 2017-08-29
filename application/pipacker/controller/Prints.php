<?php 
	namespace app\pipacker\controller;
	use think\Controller;
	/**
	* 
	*/
	class Prints extends Controller
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

			curl_setopt($con,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].url('/works'));
			curl_setopt($con,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($con,CURLOPT_HEADER,0);

			 // curl_setopt($con, CURLOPT_HEADER, false);
			 // curl_setopt($con, CURLOPT_POSTFIELDS, "10");
			 // // curl_setopt($con, CURLOPT_POST,true);
			 // curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
			 // curl_setopt($con, CURLOPT_TIMEOUT,(int)"3000");
			 $val =  json_decode(curl_exec($con),true);

			 curl_close($con);
			 // var_dump($val['rearray']);	
			 // echo 'http://'.$_SERVER['HTTP_HOST'].url('/qworks/Apic',array('works_id'=>10));
	    	// $pp_json = $pp_list->all();
	    	// print_r($pp_list);
	    	$pp_list = $val["rearray"];
	    	// foreach ($pp_list as $key => $value) {
	    	// 	$tags = explode(',',$value['works_tags']);
	    	// 	$pp_list[$key]['works_tags'] =$tags;
	    	// }
	    	// print_r($pp_list);
	    	// $pp_json[0]['works_src']= str_replace('/', '\/', $pp_json[0]['works_src']);
	    	// unset($pp_json[0]['works_src']);
	    	// unset($pp_json[0]['works_para']);
	    	// print_r($pp_json);
	    	$json = json_encode($pp_list);
	    	$this->assign("pp_list",$pp_list);
	    	$this->assign('json_pp',$json);
	    	return $this->fetch();
	    }
	    public function pgskill(){
	    	session_start();
	    	if (!empty($_SESSION["user_info"])) {
	    		$this->assign("user_info",$_SESSION["user_info"]);
	    	} else {
	    		$this->assign("user_info","");
	    	}
	    	$con = curl_init();

			curl_setopt($con,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].url('/works'));
			curl_setopt($con,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($con,CURLOPT_HEADER,0);

			 // curl_setopt($con, CURLOPT_HEADER, false);
			 // curl_setopt($con, CURLOPT_POSTFIELDS, "10");
			 // // curl_setopt($con, CURLOPT_POST,true);
			 // curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
			 // curl_setopt($con, CURLOPT_TIMEOUT,(int)"3000");
			 $val =  json_decode(curl_exec($con),true);

			 curl_close($con);
			 // var_dump($val['rearray']);	
			 // echo 'http://'.$_SERVER['HTTP_HOST'].url('/qworks/Apic',array('works_id'=>10));
	    	// $pp_json = $pp_list->all();
	    	// print_r($pp_list);
	    	$pp_list = $val["rearray"];
	    	// foreach ($pp_list as $key => $value) {
	    	// 	$tags = explode(',',$value['works_tags']);
	    	// 	$pp_list[$key]['works_tags'] =$tags;
	    	// }
	    	// $pp_json[0]['works_src']= str_replace('/', '\/', $pp_json[0]['works_src']);
	    	// unset($pp_json[0]['works_src']);
	    	// unset($pp_json[0]['works_para']);
	    	// print_r($pp_json);
	    	$json = json_encode($pp_list);
	    	$this->assign("pp_list",$pp_list);
	    	$this->assign('json_pp',$json);
	    	return $this->fetch('pgskill');
	    }
	    
	}
 ?>