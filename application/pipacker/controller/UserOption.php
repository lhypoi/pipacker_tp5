<?php 

	namespace app\pipacker\controller;
	use think\Controller;
	/**
	* 
	*/
	class userOption extends Controller
	{
		public function register(){
			$user_phone = input("user_phone");
			$user_pwd = MD5(input("user_pwd"));
			$user_name = input("user_name");
			// $user = db("user")->where(Array("user_phone"=>$user_phone,"user_pwd"=>$user_pwd))->find();
			db("user")->insert(Array("user_phone"=>$user_phone,"user_pwd"=>$user_pwd,"user_name"=>$user_name));
			$userId = db("user")->getLastInsID();
			// if(!empty($user)){

			// }
			return json_encode($userId);
			// $arrayName = array('status' => 1,$user,'msg'=>"提示信息");
		}
	}
 ?>