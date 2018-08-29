<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/24
 * Time: 8:53
 */

namespace app\common\model;

/*zh_user表用户模型跟这张表绑定的系统*/

use think\Model;

class User extends Model
{

    protected $autoWriteTimestamp = true;//自动时间戳

    protected $pk = 'id';

    protected $table = 'zh_user';
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';


    protected $dateFormat = 'Y年m月d日';

    //获取器 将字段的意义明确自动转换 中间是字段的值首字母大写

    public function getStatusAttr($value){
        //// 'status' => string '启用 ' (length=7)

        $status = ['1'=>'启用 ','0'=>'禁用'];

        return $status[$value];
    }



    //修改器当用户写入数据到数据表中实现自动转换比如MD5

    public function setPasswordAttr($value){

        //加密返回到数据库
        return sha1($value);
    }


}