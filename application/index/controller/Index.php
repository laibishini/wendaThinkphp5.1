<?php
namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\ArtCate;


use app\common\model\Article;
use app\common\model\Comment;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class Index extends Base
{
    public function index()
    {

        //查询搜索

        $map = [];
        $keyword = Request::param('keyword');

        if(!empty($keyword)){
            $map[] = ['title','like','%'.$keyword.'%'];
        }




        $map[]= ['status','=',1];



        $cate = Request::param('cate_id');
        //判断一下是不是为空
        if(isset($cate)){
            $res = ArtCate::get($cate);






            $map[] = ['cate_id','=',$cate];



            $artList = Db::table('zh_article')
                ->where($map)
                ->order('create_time','desc')->paginate(5);



            $this->assign('catename',$res->name);
        }else{
            $this->assign('catename','全部文章');


            //如果没有传栏目ID就是首页全部显示
            $artList = Db::table('zh_article')
                ->where($map)

                ->order('create_time','desc')->paginate(5);

        }

        $this->assign('empty','<h2>没有文章</h2>');

        //列表信息的分页显示 这个是用数据模型来查询的

//        $artList = Article::all(function ($query)use ($cate){
//
//            if(isset($cate)){
//                $query->where('status',1)
//                    ->where('cate_id',$cate)
//                    ->order('create_time','desc');
//            }
//
//            //显示首页的
//            if(isset($cate)){
//                $query->where('status',1)
//
//                    ->order('create_time','desc');
//            }
//        });

        //如果有传入栏目ID就查询栏目ID  这个是用DB数据库来查询的 输出的内容可能时间没有转换








        $this->assign('artlist',$artList);

        return $this->fetch();

    }


    //添加文章

    public function insert(){
        $this->isLogin();
        //用户必须登录才能发布文章

        $this->assign('title','发布文章');
        //设置页面的标题

        //获取一下栏目信息

        $catelist = ArtCate::all();

        if(count($catelist)>0){
            $this->assign('catelist',$catelist);
        }else{
            $this->error('请先添加栏目','index/index');
        }


        return $this->fetch('insert');
    }



    //保存文章

    public function save(){

        if(Request::isPost()){
            $data = Request::post();





            $res = $this->validate($data,'app\common\validate\Article');



            if(true !== $res){
                //验证失败了
                echo '<script>alert("'.$res.'");location.back()</script>';
            }else{

                //验证成功

                //获取图片的信息

                $file = Request::file('title_img');

                if(!empty($file)){
                    //文件信息进行验证

                    $info = $file->validate(['size'=>156780000,'ext'=>'jpg,png,gif'])->move('uploads/');




                    if($info){
                        $data['title_img'] = $info->getSaveName();
                    }else{
                        $this->error($file->getError());
                    }
                }





            }


            //上传成功写入数据库

            if(Article::create($data)){

                $this->success('文章发布成功','index/index');
            }else{

                $this->error('文章发布失败');
            }
        }else{

            $this->error('请求类型错误');
        }






    }

    //详情页

    public function detail(){




//        if($this->isLogin()){
//            $artId = Request::param('id');
//            $user_id = Session::get('user_id');
//
//            //先查询是不是有这个收藏
//            $map[] = ['user_id','=',$user_id];
//            $map[] = ['article_id','=',$artId];
//            $fav = Db::table('zh_user_fav')
//                ->where($map)->find();
//
//            if(is_null($fav)){
//                halt(2);
//            }
//
//
//
//
//
//
//
//        }


        $artId = Request::param('id');


        //查询文章
        $art = Article::get(function ($query)use($artId){
            $query->where('id','=',$artId)->setInc('pv');

        });


        if(!is_null($art)){
            $this->assign('art',$art);

        }

        //添加评论信息获取文章的ID查询评论表

        $this->assign('commentlist',Comment::all(function($query)use($artId){


            $query->where('status',1)->where('article_id',$artId)->order('create_time','desc');
        }));;




        return $this->fetch();
    }


    //收藏

    public function fav(){

        //判断是不是登录了




        if(!Request::isAjax()){
            return ['status'=>-1,'message'=>'请求类型错误'];
        }

        //拿到收藏点击的数据
        $data = Request::param();


        //判断是不是有session
       if(empty($data['sessionid'])){
           return ['status'=>-2,'message'=>'请登录'];
       }


        //先查询fav表里面有没有这个收藏



        $map[] = ['user_id','=',$data['userId']];
        $map[] = ['article_id','=',$data['artId']];

        //查询数据库收藏表只找一条数据

        $fav = Db::table('zh_user_fav')
        ->where($map)->find();


        if(is_null($fav)){


            //如果说是收藏没查询到我们就写如数据
            Db::table('zh_user_fav')->data([
                'user_id'=>$data['userId'],
                'article_id'=>$data['artId'],
                ])->insert();

            return ['status'=>1,'message'=>'收藏成功'];
        }else{
            Db::table('zh_user_fav')->where($map)->delete();
            return ['status'=>0,'message'=>'已消收藏'];
        }



    }


    //留言
    public function insertComment(){

        if(Request::isAjax()){
            $data = Request::param();


            if(!empty($data['content']) ){


                //将用户留言保存到表中

                if(Comment::create($data,true)){
                    return ['status'=>1,'message'=>'评论发表成功'];
                }

                //失败


            }

            return ['status'=>0,'message'=>'发表失败'];



        }

    }


}
