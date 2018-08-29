<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/26
 * Time: 16:23
 */

namespace app\admin\controller;


use app\admin\common\controller\Base;
use app\admin\common\model\User as UserModel;
use think\facade\Request;
use think\Session;

class User extends Base
{


    public function login(){

        //后台登录页面

        //1、渲染登录界面
        $this->assign('title','管理员登录');
       return $this->fetch();


    }

    //后台登录
    public function checklogin(){
        $data = Request::param();


        //查询条件

        $map[] = ['email','=',$data['email']];
        $map[] = ['password','=',sha1($data['password'])];

        $result = UserModel::where($map)->find();




        if($result){
            \think\facade\Session::set('user_id',$result['id']);
            \think\facade\Session::set('user_name',$result['name']);
            \think\facade\Session::set('is_admin',$result['is_admin']);

            $this->success('登录成功','admin/user/userList');

        }

        $this->error('登录失败','admin/user/login');



    }

    //退出登录

    public function logout(){
        //清除session

        \think\facade\Session::clear();

        //退出登录并跳转登陆页面

        $this->success('退出成功','admin/user/login');
    }


    //用户列表
    public function userlist(){

        //获取当前用户的ID
        $data['admin_id'] = \think\facade\Session::get('user_id');

        $data['admin_level'] = \think\facade\Session::get('is_admin');

        //查询用户信息

        $userlist = UserModel::where('id',$data['admin_id'] )->select();

        //如果是超级管理员获取全部的信息
       if($data['admin_level'] == 1){
           $userlist = UserModel::select();
       }





       //返回查询信息


        $this->assign('title','用户管理');
        $this->assign('empty','<span style="color: red">没有任何数据</span>');
        $this->assign('userlist',$userlist);



        return $this->fetch();
    }


    //用户编辑

    public function useredit(){

        //渲染用户的编辑界面

        //1、获取数据更新的主键

        $userId = Request::param('id');

        //根据主键进行查询获取

        $userInfo = UserModel::where('id',$userId)->find();

        //设置编辑界面

        $this->assign('title','编辑用户');

        $this->assign('userInfo',$userInfo);

        //显示编辑页面

        return $this->fetch();
    }

    //编辑更新用户

    public function doedit(){

        $user = Request::param();


        //取出主键

        $id = $user['id'];

        //把用户加密进行保存查询用户密码和当前密码是否是一致的

        $password = UserModel::where('id',$id)->value('password');

        unset($user['id']);
        //如果相等就说明你没改密码不不更新密码

        if($user['password'] === $password){

            unset($user['password']);

        }else{
            $user['password'] = sha1($user['password']);

        }

        UserModel::where('id',$id)->data($user)->update();

        return $this->success('用户，密码更新成功');
    }


    //删除用户
    public function dodelete(){

        $id = Request::param('id');

       //执行删除操作

        if(UserModel::where('id',$id)->delete()){
            $this->success('删除成功','user/userlist');
        };

        $this->error('删除失败');

    }



}