<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登录</title>
	<link rel="stylesheet" type="text/css" href="\index\login\vendor\bootstrap\css\bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="\index\login\fonts\iconic\css\material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="\index\login\fonts\font-awesome-4.7.0\css\font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="\index\login\css\util.css">
    <link rel="stylesheet" type="text/css" href="\index\login\css\main.css">
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
				<form class="login100-form validate-form">
					<span class="login100-form-title p-b-49">登录</span>

					<div class="wrap-input100 validate-input m-b-23" data-validate="请输入用户名">
						<span class="label-input100">用户名</span>
						<input class="input100" type="text" id="username" name="username" placeholder="请输入用户名或邮箱号" autocomplete="off">
						<span class="focus-input100" data-symbol="&#xf206;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="请输入密码">
						<span class="label-input100">密码</span>
						<input class="input100" type="password" id="pwd" name="pwd" placeholder="请输入密码">
						<span class="focus-input100" data-symbol="&#xf190;"></span>
                    </div>

					<div class="text-right p-t-8 p-b-31">
						<a href="javascript:">忘记密码？</a>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <a href="javascript:;" id="btn" class="login100-form-btn">登陆</a>
						</div>
					</div>

					<div class="txt1 text-center p-t-54 p-b-20">
						<span>第三方登录</span>
					</div>

					<div class="flex-c-m">
						<a href="#" class="login100-social-item bg1">
							<i class="fa fa-wechat"></i>
						</a>

						<a href="#" class="login100-social-item bg2">
							<i class="fa fa-qq"></i>
						</a>

						<a href="#" class="login100-social-item bg3">
							<i class="fa fa-weibo"></i>
						</a>
					</div>

					<div class="flex-col-c p-t-25">
						<a href="\login\register" class="txt2">立即注册</a>
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
$(function(){
    layui.use(['layer'],function(){
        var layer = layui.layer;
        $('#btn').click(function(){
        var username=$('#username').val();
        var pwd=$('#pwd').val()
        if(username==""){
            layer.msg('用户或邮箱不能为空');
            return false;
        }
        if(pwd==""){
            layer.msg('用户或邮箱不能为空');
            return false;
        }
        $.post(
            '/login/login',
            {username:username,pwd:pwd},
            function(res){
                layer.msg(res.font,{icon:res.code});
                if(res.code=='6'){
                    location.href="/"
                }
            },
        )
    })
    })
})

</script>
