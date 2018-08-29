<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/24
 * Time: 14:19
 */

namespace app\index\controller;


use app\common\controller\Base;
use app\common\model\User as UserModel;
use think\facade\Request;
use think\facade\Session;

/*用户注册*/
class User extends Base
{

    //注册页面

    public function register(){

        //是否开启了注册
        $this->is_reg();
        $this->assign('title','用户注册');

        return $this->fetch();
    }

    //接受表单注册表单信息
    public function insert(){

        if(Request::isAjax()){
            //拿到数据
            $data = Request::post();


            //自定义验证器
            $rule = 'app\common\validate\User';

            //开始验证


            $res = $this->validate($data,$rule);

            if(true !==$res){
                return ['status'=>-1,'message'=>$res];
            }else{

                //模型来创建数据获取当前请求的数据通过表单提交过来的数据
                if($user = UserModel::create($data)){

                    // 返回的是插入的信息的对象 注册就是登陆这个功能

                    $res = UserModel::get($user->id);
                    Session::set('user_id',$res->id);
                    Session::set('user_name',$res->name);


                    return ['status'=>1,'message'=>'恭喜你注册成功'];
                }else{
                    return  ['status'=>0,'message'=>'注册失败，请检查'];
                }
            }




        }else{
            $this->error('请求类型错误','register');
        }

    }


    //用户登录

    public function login(){

        $this->isLogined();

        return $this->fetch('login',['title'=>'用户登录']);
    }


    //用户登录验证

    public function loginCheck(){

        if(Request::isAjax()){
            //拿到数据
            $data = Request::post();


            //自定义验证器
            $rule = [
                'email|邮箱'=>'require|email',
                'password|密码'=>'require|alphaNum',
            ];

            //开始验证


            $res = $this->validate($data,$rule);

            if(true !==$res){
                return ['status'=>-1,'message'=>$res];
            }else{

                //查询操作

                $result = UserModel::get(function ($query) use($data){
                    $query->where('email',$data['email'])
                        ->where('password',sha1($data['password']));
                });



                if(null == $result){
                    return ['status'=>0,'message'=>'邮箱或者密码不正确'];
                }else{

//                    ///将用户数据写入到session中
                    Session::set('user_id',$result->id);
                    Session::set('user_name',$result->name);

                    //获取后台用户登录信息



                    return  ['status'=>1,'message'=>'恭喜！登录成功'];
                }
            }




        }else{
            $this->error('请求类型错误','login');
        }
    }

    //用户退出登录

    public function logout(){

//        Session::delete('user_id');
//        Session::delete('user_name');
        //退出登录
        Session::clear();


        $this->success('退出成功','index/index');
    }

}