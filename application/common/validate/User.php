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

class User extends Validate
{

    protected $rule = [

        'name|姓名' =>'require|length:5,20|chsAlphaNum',
        'email|邮箱' =>'require|email|unique:zh_user',
        'mobile|手机号' =>'require|mobile|unique:zh_user',
        'password|密码' =>'require|length:6,20|alphaNum|confirm',

    ];

}


//'name|姓名'=>[
//    'require'=>'require',
//    'length'=>'5,20',
//    'chsAlphaNum'=>'chsAlphaNum',//仅仅允许汉子和字母数字
//
//],
//        'email|邮箱'=>[
//    'require'=>'require',
//    'email'=>'email',
//    'unique'=>'zh_user',//该字段必须是zh_user中是唯一的
//
//],
//        'mobile|手机号'=>[
//    'require'=>'require',
//    'mobile'=>'mobile',
//    'unique'=>'zh_user',//该字段必须是zh_user中是唯一的
//    'number'=>'number'
//
//],
//        'password|密码'=>[
//    'require'=>'require',
//    'length'=>'6,20',
//    'alphaNum'=>'alphaNum',//仅仅允字母数字
//    'confirm'=>'confirm',//二次输入自动和这个possword_confirmy字段相等验证
//
//],