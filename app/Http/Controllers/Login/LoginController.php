<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    //登录视图
    public function index(){
        return view('login/index');
    }
    /**登陆 */
    public function login(){
        // dd($_POST);
        $username=$_POST['username'];
        $user_model=DB::table('oneself_user');
        if(substr_count($username,'@')>0){
            // echo "邮箱";
            $where=['usermail'=>$username];
        }else{
            $where=['username'=>$username];
        }
        $arr=DB::table('oneself_user')->where($where)->first();
        // print_r($arr);die;
        $pwd=decrypt($arr->pwd);
        if(!empty($arr)){
            // echo "you";
            $time=time();
            // dd($time);
            $error_time=$arr->error_time;
            $error_num=$arr->error_num;
            // dd($error_time,$error_num);
           if($pwd==$_POST['pwd']){
                // echo"对";
                if($time-$error_time<3600&&$error_num>=5){
                    $m=60-floor(($time-$error_time)/60);
                    return ['font'=>$m.'分钟后登陆'];
                    return false;
                }
                $updateInfo=[
                    'error_num'=>0,
                    'error_time'=>null
                ];
                $res=$user_model->where($where)->update($updateInfo);
                return ['code'=>6,'font'=>'登陆成功'];
           }else{
                if($time-$error_time>3600){
                    $updateInfo=[
                        'error_num'=>1,
                        'error_time'=>$time
                    ];
                    $where=[
                        'user_id'=>$arr->user_id,
                    ];
                    $res=$user_model->where($where)->update($updateInfo);
                    if($res){
                        // $num=5-$error_num;
                        return ['font'=>'你错误了1次,你还有4次机会'];
                        return false;
                    }
                }else{
                    if($error_num>=5){
                        $m=60-floor(($time-$error_time)/60);
                        // echo $m;die;
                        return ['font'=>$m.'分钟后登陆'];
                        return false;
                    }else{
                        $error_num+=1;
                        $updateInfo=[
                            'error_num'=>$error_num,
                            'error_time'=>$time
                        ];
                        $where=[
                            'user_id'=>$arr->user_id,
                        ];
                        $res=$user_model->where($where)->update($updateInfo);
                        if($res){
                            $num=5-$error_num;
                            if($num==0){
                                return ['font'=>'账号已锁定，请等一小时后重新登录'];
                                return false;
                            }else{
                                return ['font'=>'您错误了'.$error_num.'次'.',还有'.$num.'次机会'];
                                return false;
                            }
                        }
                    }
                }
           }
        }else{
            return ['font'=>'没有此账号请先登录'];
            return false;
        }
    }
    /**注册 */
    public function register(){
        return view('login/register');
    }
    public function add(){
        // dd(session('email'));
        $code=session('email.code');
        // $addtime=session('email.addtime');
        $pwd=encrypt($_POST['pwd']);
        $usermail=session('email.email');
        $time=time();
        if($_POST['username']==""){
            echo ['font'=>'用户名不能为空'];
            return false;
        }
        // if($time-addtime>=120){
        //     return ['font'=>'验证码已过期'];
        //     return false;
        // }
        if($_POST['usermail']!=$usermail){
            return ['font'=>'请输入正确邮箱号'];
            return false;
        }
        if($_POST['code']!=$code){
            return ['font'=>'请输入正确验证码'];
            return false;
        }
        $res_info=DB::table('oneself_user')->where(['usermail'=>$usermail])->first();
        // print_r($res_info);
        if(empty($res_info)){
            $info=[
                'username'=>$_POST['username'],
                'usermail'=>$_POST['usermail'],
                'pwd'=>$pwd
            ];
            $arr=DB::table('oneself_user')->insert($info);
            if($arr){
                return ['font'=>'注册成功'];
                return true;
            }else{
                return ['font'=>'注册失败'];
                return false;
            }
        }else{
            return ['font'=>'已有此账号是否申请'];
            return false;
        }
    }
    /**邮件发送 */
    public function mail(){
        $code=rand(111111,999999);
        $arr= Mail::send('login.email',['code'=>$code],function($message){
            $to = request()->input('email');
            $message ->to($to)->subject('邮件测试');
        });
        $email=[
            'code'=>$code,
            'email'=>request()->input('email'),
            'addtime'=>time()
        ];
        session(['email'=>$email]);
        if($arr=!false){
            return ['font'=>'发送成功'];
        }else{
            return ['font'=>'发送失败'];
            return false;
        }
    }
    public function a(){
        echo session('email.code');
    }

}
