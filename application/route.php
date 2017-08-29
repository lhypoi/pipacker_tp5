<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],
//     // 定义资源路由
//     '__rest__'=>[
//         // 指向api模块的控制器
//         'works'=>'api/Works',
//         'atlas'=>'api/Atlas',
//         'comment'=>'api/Comments',
//         'user'=>'api/User',
//     ]
// ];
//
use think\Route;
header("Access-Control-Allow-Origin: http://localhost:8080");
Route::resource("works","api/Works");
Route::resource("atlas","api/Atlas");
Route::resource("comment","api/comment");
Route::resource("user","api/User");
Route::resource("collect","api/Collect");
Route::controller("qworks","api/Works");
Route::controller("quser","api/User");
Route::resource("carts","api/Carts");