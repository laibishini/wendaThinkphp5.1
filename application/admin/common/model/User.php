<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/26
 * Time: 16:13
 */

namespace app\admin\common\model;


use think\Model;

class User extends Model
{

    protected $pk = 'id';
    protected $table = 'zh_user';
}