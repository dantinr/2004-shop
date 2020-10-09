<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserModel;
use MongoDB\Driver\Session;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{

    /**
     * 注册 View
     */
    public function regist()
    {
        return view('user.regist');
    }

    /**
     * 注册 逻辑
     */
    public function registDo(Request $request)
    {
        echo '<pre>';print_r($_POST);echo '</pre>';


        //表单验证
        $validate = $request->validate([
            'user_name'     => 'required | min:5',
            'user_email'    => 'required | email',
            'user_mobile'   => 'required | digits:11',
            'pass'          => 'required | min:6 ',
            'pass_confirmation'    => 'required | min:6 | same:pass',
        ]);

        //生成密码
        $pass = password_hash($request->post('pass'),PASSWORD_BCRYPT);

        //入库
        $u = [
            'user_name' => $request->post('user_name'),
            'mobile'    => $request->post('user_mobile'),
            'email'     => $request->post('user_email'),
            'password'  => $pass
        ];

        $uid = UserModel::insertGetId($u);

        //注册成功跳转登录
        if($uid)
        {
            return redirect('/user/login');
        }

        return redirect('/user/regist');

    }


    /**
     * 用户登录
     */
    public function login()
    {
        return view('user.login');
    }

    /**
     * 用户登录 后台
     */
    public function loginDo(Request $request)
    {


        $user_name = $request->input('user_name');
        $user_pass = $request->input('user_pass1');

        $key = 'login:count:'.$user_name;
        //检测用户是否已被锁定
        $count = Redis::get($key);

        if($count>5)
        {
            echo "输入密码错误次数太多，用户已被锁定";
            die;
        }


        $u = UserModel::where(['user_name'=>$user_name])
            ->orWhere(['email'=>$user_name])
            ->orWhere(['mobile'=>$user_name])->first();

        if(empty($u))   //用户不存在
        {
            die("用户不存在");
        }

        //验证密码
        $p = password_verify($user_pass,$u->password);
        if(!$p)
        {
            //密码不正确  记录错误次数


            $count = Redis::incr($key);
            echo "密码错误次数：" . $count;

            die;
        }

        //登录成功


    }
}
