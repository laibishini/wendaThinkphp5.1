<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/27
 * Time: 15:02
 */

namespace app\admin\controller;

use app\admin\common\model\Site as SiteModel;
use app\admin\common\controller\Base;
use think\facade\Request;


class Site extends Base
{


    //站点信息管理首页
public function index(){



  //获取站点信息有效的才行
    $siteInfo = SiteModel::get(['status'=>1]);

    //模版赋值

    $this->assign('siteInfo',$siteInfo);


    //渲染模版
    return $this->fetch();


}

    public function catelist(){

        //检查用户是否是登录
        $this->isLogin();
        //跳转到分类的列表如果登录

        //获取全部分类
        $catelist = CateModel::all();

        //设置模版变量


        $this->assign('title','分类管理');

        $this->assign('empty','<span style="color: red">没有分类</span>');

        $this->assign('catelist',$catelist);

        //渲染模版

        return $this->fetch();





    }


    //保存站点修改信息

    public function save(){

        //获取修改的数据

        $data= Request::param();


        //根据主键查询更新的用户信息




        if(SiteModel::update($data)){

            $this->success('更新成功','index');
        }


        //更新失败了

        $this->error('更新失败');


        //设置模版变量








        // 渲染模版

        return $this->fetch();

    }


    //更新分类

    public function doedit()
    {

        $catedata = Request::param();


        $id = $catedata['id'];





        if(CateModel::where('id',$id)->data($catedata)->update()){

            return $this->success('用户，密码更新成功','catelist');

        };

        return $this->error('更新失败');


    }

    //删除分类
    public function cateDelete()
    {

        $id = Request::param('id');

        //执行删除操作

        if(CateModel::where('id',$id)->delete()){
            $this->success('删除成功','cate/catelist');
        };

        $this->error('删除失败');


    }

    //添加分类
    public function cateadd(){


    return $this->fetch('cateadd',['title'=>'添加分类']);

    }

    //获取表单添加信息添加到数据库

    public function doadd(){
        $catedate = Request::param();


        if(!empty($catedate['name'])&&!empty('sort')&&!empty('status')){


            if(CateModel::create($catedate)){
                $this->success('添加分类成功','cate/catelist');
            };
        }







        $this->error('添加失败');


    }







}