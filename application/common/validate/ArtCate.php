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

class ArtCate extends Validate
{

    protected $rule = [

        'name|标题' =>'require|length:3,20|chsAlpha',


    ];

}


