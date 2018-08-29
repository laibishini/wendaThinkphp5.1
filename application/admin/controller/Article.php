<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/27
 * Time: 17:17
 */

namespace app\admin\controller;


use app\admin\common\model\Article as ArticleModel;
use app\admin\common\controller\Base;
use app\common\model\ArtCate;
use think\facade\Request;
use think\facade\Session;

//文章列表
class Article extends Base
{

    public function index(){

        return $this->redirect('artList');
    }


    //文章列表
    public function artList(){

       $this->isLogin();


        //获取当前用户的ID和用户的级别

        $userId = Session::get('user_id');




        $isAdmin = Session::get('is_admin');


        //获取当前用户发布的文章

        $artList = ArticleModel::where('user_id',$userId)->order('create_time','desc')->paginate(5);



        //超级管理员全部文章
       if($isAdmin == 1){

           $artList = ArticleModel::order('create_time','desc')->paginate(5);

       }







        //设置模版变量

        $this->assign('title','文章管理');



       $this->assign('empty','<span style="color: red">没有文章了</span>');

        $this->assign('artList',$artList);


        // 渲染模版

        return $this->fetch('artlist');


    }

    //编辑文章

    public function artedit(){

        $articleId = Request::param('id');

        //查询这篇文章
        $article = ArticleModel::where('id',$articleId)->find();

        //查询栏目信息
        $cateList = \app\admin\common\model\Cate::all();


        //设置变量
        $this->assign('cateList',$cateList);
        $this->assign('title','编辑文章');

        $this->assign('article',$article);










        return $this->fetch();
    }


    //编辑提交文章

    public function doedit(){

        //获取文章的ID

        $data = Request::param();










        $file = Request::file('title_img');







        //文件信息进行验证

        if(!empty($file)){
            $info = $file->validate(['size'=>156780000,'ext'=>'jpg,png,gif'])->move('uploads/');

            if($info){
                $data['title_img'] = $info->getSaveName();
            }else{
                $this->error($file->getError());
            }
        }


        if(ArticleModel::update($data)){

            //更新成功跳转到首页
            $this->success('文章更新成功','artlist');
        }else{

            $this->error('文章更新失败');
        }



    }



    public function artdelete(){
        $artId = Request::param('id');

        //拿到文章的ID删除文章

        if(ArticleModel::destroy($artId)){
            $this->success('删除成功');
        }

        $this->error('删除失败');

    }
}



