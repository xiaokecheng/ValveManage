<!doctype html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>用户登录</title>

<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="icon" href="images/myicon.ico" />
<link rel="shortcut icon" href="images/myicon.ico" />

<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>

<script>
$('#login-button').click(function (event) {
	event.preventDefault();
	var errormess = document.getElementById("error-mess");
	errormess.style.display = "";                           <!--  改变显示属性,使其显示 -->  
	
	document.getElementById("error-message").innerHTML = "帐户名或登录密码不正确，请重新输入";   <!--  错误详情 -->
	
	document.getElementById("mima").value= "";
	
	for(i=0;i<document.all.tags("input").length;i++){  
        if(document.all.tags("input")[i].type=="text"){  
            document.all.tags("input")[i].value="";  
        }  
    }  
	<!--window.location.href="http://www.chengxiaoke.cn";-->
});
</script>

</head>
<body>
<div class="htmleaf-container">
	<div class="wrapper">
		<div class="container">
			<h1>Welcome</h1>
			
			<form class="form" method="post" action="login_handle.php">
				<div class="login" >
				<input id="yonghu" type="text" placeholder="用户名" name="username" >
				<input id="mima" type="password" placeholder="密码" name = "password">
				</div>
				
				
				<div id="error-mess" style="display: none;">
					<span class="error-icon"></span>
					<span id="error-message"></span>
				</div>
				
				<div class="aboutpassword">
					<span class="check">
						<label>
							<input type="checkbox" id="remeberMe"  class ="auto-login" >记住密码
						</label>
					</span>
					
					<div class ="forget-password">
						<a href="http://www.chengxiaoke.cn">忘记密码</a>
					</div>
				</div>
				<button type="submit" id="login-button">登录</button>
				
				<div class ="register">
						<a href="http://www.chengxiaoke.cn">注册</a>
			</div>
			</form>
			
		</div>
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	
	</div>
</div>

<div style="text-align:center;margin:50px 0; padding-top:30px;font:normal 14px/24px 'MicroSoft YaHei';color:#000000;font-size:17px;">
<h1>无线智能暖气水阀用户系统</h1>
</div>
</body>
</html>


