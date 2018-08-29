<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/26
 * Time: 16:11
 */

namespace app\admin\common\controller;


use think\Controller;

/*后台公共控制器*/

class Base extends Controller
{

    //判断是否是登录

    protected function initialize()
    {

    }

    /*监测用户是否是登录
    在后台入口调用*/

    protected function isLogin(){

        if(!\think\facade\Session::has('user_id')){
            $this->error('请先登录','admin/user/login');

        }


    }

}