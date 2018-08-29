<?php
/**
 * Created by PhpStorm.
 * User: Jne
 * Date: 2018/8/24
 * Time: 9:10
 */

namespace app\index\controller;
/*专门用来测试的*/

use app\common\controller\Base;

use app\common\model\User;

class Test extends Base
{

    //测试用户验证器

    public function test1(){

        dump(User::get(1));


    }

}