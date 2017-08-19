<?php
/**
 * Created by PhpStorm.
 * User: graphic
 * Date: 2017/8/3
 * Time: 15:33
 */

namespace app\admin\model;


use think\Model;

class Works extends Model
{
    public function user()
    {
        return $this->belongsTo("User");
    }
}