<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
class LoginController extends Controller
{
    //登录视图
    public function index(){
        return view('login/index');
    }
    /**注册 */
    public function register(){
        return view('login/register');
    }
    public function add(){
        // dd($_POST);
        // if($_POST['username']==""){
        //     echo ['font'=>'用户名不能为空'];
        //     return false;
        // }
    }
    /**邮件发送 */
    public function mail(){
        $code=rand(111111,999999);
        $fail=Mail::send('login.email',['code'=>$code],function($message){
            $message->to(request()->input('email'))->subject('验证码啊');
        });
        if($fail!==false){
            return ['code'=>1,'font'=>"发送成功"];
        }
        // if($arr){
        //     echo "成功";
        // }else{
        //     echo "失败";
        // }
        // 返回的一个错误数组，利用此可以判断是否发送成功
        //  dd(Mail::failures());
         //31521858232@qq.com
    }
}
