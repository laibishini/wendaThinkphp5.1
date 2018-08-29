<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


//公共name名字
if(!function_exists('getUserName')){


    function getUserName($id){

        return \think\Db::table('zh_user')->where('id',$id)->value('name');//获取name字段的值
    }
}


//过滤文章摘要

function getArtContent($content){

    return mb_substr(strip_tags($content),0,10)."...";
}


if(!function_exists('getCateName')){


    function getCateName($id){

        return \think\Db::table('zh_article_category')->where('id',$id)->value('name');//获取name字段的值
    }
}
