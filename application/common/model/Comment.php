<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/24
 * Time: 8:53
 */

namespace app\common\model;

/*评论表表用户模型跟这张表绑定的系统*/

use think\Model;

class Comment extends Model
{

    protected $autoWriteTimestamp = true;//自动时间戳

    protected $pk = 'id';

    protected $table = 'zh_user_comments';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    //自动完成设置

    protected $auto = [];//无论是新增还是

    //仅新增有效

    protected $insert = ['create_time','status'=>1,'is_top'=>0,'is_hot'=>0];

    //仅更新的时候设置

    protected $update = ['update_time'];





}