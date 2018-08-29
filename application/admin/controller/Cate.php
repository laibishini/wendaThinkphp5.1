<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/27
 * Time: 15:02
 */

namespace app\admin\controller;

use app\admin\common\model\Cate as CateModel;
use app\admin\common\controller\Base;
use think\facade\Request;


class Cate extends Base
{

//分类的首页

public function index(){

    //检查用户是否是登录
    $this->isLogin();
    //跳转到分类的列表如果登录

    return $this->redirect('cateList');

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


    //查询编辑分类

    public function cateedit(){

        //获取分类的ID

        $cateId = Request::param('id');


        //根据主键查询更新的用户信息

        $cateInfo = CateModel::where('id',$cateId)->find();





        //设置模版变量

        $this->assign('title','分类编辑');



        $this->assign('cateInfo',$cateInfo);


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