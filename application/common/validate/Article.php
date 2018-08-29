<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/24
 * Time: 8:58
 */

namespace app\common\validate;

/*表的验证器*/

use think\Validate;

class Article extends Validate
{

    protected $rule = [

        'title|标题' =>'require',
//        'title_img|图片'=>'require',
        'content|文章内容' =>'require',
        'user_id|作者' =>'require',
        'cate_id|栏目名称' =>'require',

    ];

}


