<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/27
 * Time: 17:15
 */

namespace app\admin\common\model;


use think\Model;

class Article extends Model
{
    protected $pk = 'id';
    protected $table = 'zh_article';
}
