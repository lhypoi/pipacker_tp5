<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

class Works extends Controller{

    public function index()
    {
      $pp_list =  Db::table("pp_works")->paginate(10);

      $this->assign("weibo_list",$pp_list);
       return $this->fetch();

    }
    
}



?>