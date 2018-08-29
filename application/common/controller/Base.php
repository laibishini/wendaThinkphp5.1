<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/24
 * Time: 8:35
 */

namespace app\common\controller;

/*公共的控制器基础控制器*/

use app\admin\common\model\Site;
use app\common\model\ArtCate;
use app\common\model\Article;
use think\Controller;
use think\facade\Request;
use think\Session;

class Base extends Controller
{

    /*初始化方法主要是放创建一些常量和公共方法，
    在所有的方法之前被调用*/
    protected function initialize()
    {

        $this->showNav();

        //监测网站是否关闭

        $this->is_open();

        //根据用户点击量把文章表数据拿到

        $this->getHoteArt();
    }

    //防止重复登录

    protected  function isLogined(){

        if(\think\facade\Session::has('user_id')){
            $this->error('你已经登录了','index/index');
        }
    }


    //没有登录
    protected function isLogin(){

        if(!\think\facade\Session::has('user_id')){
            $this->error('你是不是忘记登录了','user/login');

        }


    }


    //获取栏目分类

    protected function showNav(){

        //读取数据库栏目信息

       $catelist=  ArtCate::all(function($query){
            $query->where('status',1)->order('sort','asc');
        });



       $this->assign('catelist',$catelist);
    }

//监测站点是否是关闭

public function is_open(){


        //获取当前网站状态

   $isOpen =  Site::where('status',1)->value('is_open');

   //如果站点已经关闭我们只运行关闭前台网站 后台是不能关闭的

    //查询模块是不是等于index
   if($isOpen == 0 && Request::module()=='index'){

       //就把网站关掉
       $info = <<< 'INFO'
<body style="background-color: rebeccapurple;text-align: center;margin: 200px;" ><h2 style="font-size: 100px;
">站点维护中。。。。</h2></body>
INFO;

       exit($info);


   }
}


//是否是开启注册

public function is_reg(){
        //获取当前的注册状态

    $isReg =  Site::where('status',1)->value('is_reg');
    //如果当前已经关闭我们就跳到首页
    if($isReg == 0){
        $this->error('注册关闭','index/index');

    }




}


//更具点击量获取推荐文章
public function getHoteArt(){

        $hotArtList = Article::where('status',1)->order('pv','desc')->limit(12)->select();

        $this->assign('hotArtList',$hotArtList);
}


}



