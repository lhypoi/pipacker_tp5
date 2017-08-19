<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function saveFile($file_name)
{
	// 先判断是否有保存头像的目录
	// 如果没有就创建该目录

	$save_head_path = ROOT_PATH."/public/upload/images/";
	if (!is_dir($save_head_path)) {
		 mkdir($save_head_path);
	}

	$exp_str = explode("/", $_FILES[$file_name]['type']);
	 
	$save_file = time().rand(1000,9999).".".$exp_str[1];

	move_uploaded_file($_FILES[$file_name]['tmp_name'], $save_head_path.$save_file );

	return "/public/upload/images/".$save_file;
}
