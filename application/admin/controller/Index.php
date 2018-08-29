<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/26
 * Time: 15:46
 */

namespace app\admin\controller;


//后台类


use app\admin\common\controller\Base;

class Index extends Base
{

    public function index(){

        $this->isLogin();
        //用户是否是登录



        return $this->redirect('user/userlist');
    }
}