<?php
use think\Request;
	function is_active($cur_ctr,$str,$is_sub=false)
	{
	    if (strstr($cur_ctr,lcfirst(Request::instance()->controller()))){
	        if($is_sub) {
	            if ($cur_ctr == lcfirst(Request::instance()->controller())) {
	                return $str;
	            }
	        }else{
	            return $str;
	        }
	    }

	}	

?>