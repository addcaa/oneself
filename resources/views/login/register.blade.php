<style>
#input100{
    height:25px;
}
</style>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>注册</title>
	<link rel="stylesheet" type="text/css" href="\index\login\vendor\bootstrap\css\bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="\index\login\fonts\iconic\css\material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="\index\login\fonts\font-awesome-4.7.0\css\font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="\index\login\css\util.css">
    <link rel="stylesheet" type="text/css" href="\index\login\css\main.css">
    <link rel="stylesheet" type="text/css" href="\layui\css\layui.css">

</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-49">注册</span>

                    <div class="wrap-input100 validate-input m-b-23" data-validate="请输入用户名">
						<span class="label-input100">用户名</span>
						<input class="input100" type="text" id="username"name="username" placeholder="请输入用户名" autocomplete="off">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 m-b-23"   data-validate="请输入手机号">
                        <span class="label-input100">邮箱号</span>
						<input class="input100 " id="input100" type="text"  name="usermail"style="position: relative; top:20px;"   placeholder="请输入邮箱号" autocomplete="off">
                        <input type="button " style="width:111px;  position: relative; top:-14px;left:260px;" id="cation"class="layui-btn layui-btn-radius" value="发送验证码">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>

                    </div>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入密码">
						<span class="label-input100">密码</span>
						<input class="input100" type="password" id="pwd" name="pwd" placeholder="请输入密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
					</div>

                    <div class="wrap-input100 validate-input" data-validate="请输入确认密码">
						<span class="label-input100">确认密码</span>
						<input class="input100" type="password" id="password"name="password" placeholder="请输入确认密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>

					<div class="text-right p-t-8 p-b-31">
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <a href="javascript:;" class="login100-form-btn btn">立即注册</a>
						</div>
					</div>

					<div class="flex-col-c p-t-25">
						<a href="\login\register" class="txt2"></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
<script src="\index\login\js\jquery-3.2.1.min.js"></script>
<script src="\index\login\js\main.js"></script>
<script src="\layui\layui.all.js"></script>
<script src="\layui\layui.js"></script>
<script>
layui.use('layer', function(){
    var layer = layui.layer;
    //邮箱验证
    $(function(){
        $("#cation").click(function(){
            // alert(11);
            var email=$("#cation").prev("input").val();
            // console.log(mail);
            var time = 60;
                var timer = setInterval(function(){
                time--;
                    $("#cation").val("("+time+"秒)重发").attr('disabled',true);
                    // layer.msg('稍等片刻');
                    //  return false;
                if(time==0){
                    clearInterval(timer);
                $("#cation").val("发送验证码").attr('disabled',false);
            }
            },1000);
            $.post(
                '/login/mail',
                {email:email},
                function(res){
                    layer.msg(res.font,{icon:res.code});


            }
            );
        })
    })
    $(function(){
        $(".btn").click(function(){
            var username=$('#username').val();
            var usermail=$("input[name='usermail']").val();
            console.log(usermail);
            var pwd=$('#pwd').val();
            var password=$('#password').val();
            // layer.msg('hello');
            var reg = /^[\u4e00-\u9fa5_a-zA-Z0-9_]{2,20}$/;// 这里是 正则表达式，大小写
            var res=/^[a-z0-9A-Z]+[- | a-z0-9A-Z . _]+@([a-z0-9A-Z]+(-[a-z0-9A-Z]+)?\\.)+[a-z]{2,}$/;
            var pwdres=/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,12}$/;
            if(username==""){
                layer.msg('请输入用户名');
                return false;
            }else if(reg.test(username)!= true){
                layer.msg('用户名由中文,英文字母和数字及下划线组成');
                return false;
            }
            if(usermail==""){
                layer.msg('请输入邮箱号');
                return false;
            }else if(res.test(usertel)!=true){
                layer.msg("邮箱号有误，请重填");
                return false;
            }
            if(pwd==""){
                layer.msg('请输入密码');
                return false;
            }else if(pwdres.test(pwd)!=true){
                layer.msg('密码数字和字母组成,长度要在6-12位之间');
                return false;
            }
            if(password==""){
                layer.msg('请输入确认密码');
                return false;
            }else if(password!=pwd){
                layer.msg('确认密码和密码不一致');
                return false;
            }
            $.post(
                '/login/add',
                {username:username,usertel:usertel,pwd:pwd,password:password},
                function(res){
                    layer.msg(res.font,{icon:res.code});
                    console.log(res);
                }
            );
        })

    })

})


</script>
