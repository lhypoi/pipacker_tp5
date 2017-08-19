<?php 
	namespace app\api\controller;

	use think\Controller;
	use think\Request;

	/**
	 * 控制器的父类
	 */
	class baseControll extends Controller
	{
		/**
		 * [reJson json返回数据方法]
		 * @param  [type] $status [状态信息]
		 * @param  array  $redata [返回的数据]
		 * @param  string $msg    [返回的提示]
		 * @return [type]         [输出到前端]
		 */
		public function reJson($status="1",$redata=array(),$msg=""){
			echo json_encode(array(
				'status'=> $status,
				'rearray'=> $redata,
				'msg'=>$msg
			));

		}
    }


 ?>