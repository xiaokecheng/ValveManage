<?php
$error_num = 0;
if (isset ( $_GET ["error_num"] )) {
	$error_num = $_GET ["error_num"];
}

?>
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

$(function()
{
	checkCookie();
});

//cookies
function setCookie(c_name,value,expiredays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);     //转换为有效的日期格式
	document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toUTCString());   //需要加密
}

function getCookie(c_name)
{
	if (document.cookie.length>0)
  	{
 		 c_start=document.cookie.indexOf(c_name + "=");
  		 if (c_start!=-1)
   		 { 
    		c_start=c_start + c_name.length+1 ;
    		c_end=document.cookie.indexOf(";",c_start);
    		if (c_end==-1)
        		 c_end=document.cookie.length;
   			 return unescape(document.cookie.substring(c_start,c_end));
         } 
 	 }
	return "";
}

function checkCookie()
{
	 //获取cookie
	  var cusername = getCookie('cusername');
	  var cpassword = getCookie('cuserpass');
	  if(cusername != "" && cpassword != "")
	   {
	      $("#yonghu").val(cusername);
	      $("#mima").val(cpassword);
	      //document.getElementById('remeberMe').checked = true;   //right
	      //$("#remeberMe")..checked = true;             //wrong
	      $("#remeberMe").attr("checked","checked");
	   }
}

function clearCookie(c_name) 
{ 
	setCookie(c_name, "", -1);
}

//first method   form表单  + login_handle.php
function submituserinfo(){
	var errormess = document.getElementById("error-mess");
	errormess.style.display = "none";                                              <!--  改变显示属性,使其显示 -->  
	//验证姓名
	var username = document.getElementById("yonghu").value;
	if(username ==""){
		errormess.style.display = "";                                              <!--  改变显示属性,使其显示 -->  
		document.getElementById("error-message").innerHTML = "请输入用户名";        <!--  错误详情 -->
		return false;
	}
	return true;
}

//second method---ajax + session
function checkuserinfo(){
	event.preventDefault();  //阻止表单提交

	var errormess = document.getElementById("error-mess");
	errormess.style.display = "none";                                              <!--  改变显示属性,使其显示 -->  
	//验证姓名
	var username = document.getElementById("yonghu").value;
	var password = document.getElementById("mima").value;
	if(username ==""){
		errormess.style.display = "";                                              <!--  改变显示属性,使其显示 -->  
		document.getElementById("error-message").innerHTML = "请输入用户名";        <!--  错误详情 -->
		return false;
	}

	var xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	 {
		alert ("Browser does not support HTTP Request");
	 	return false;
	 }

	xmlHttp.onreadystatechange=function()
	 {
	  if (xmlHttp.readyState==4 && xmlHttp.status==200)
	    {
		  	var result=xmlHttp.responseText;
			 if(result == "wrong"){
				errormess.style.display = "";                                             
				document.getElementById("error-message").innerHTML = "帐户名或登录密码不正确，请重新输入";       
			 } 
			 else if(result == "success")
			 {
				 if($('#remeberMe').is(':checked')){
					 setCookie('cusername',username,7);
					 setCookie('cuserpass',password,7);
				 }
				 else
				 {
					 clearCookie('cusername');
					 clearCookie('cuserpass');
				 }
				 window.location.href='general_view.php';
			 }
			 else
			 {
				errormess.style.display = "";                                             
				document.getElementById("error-message").innerHTML = "未知错误，请联系管理员";   
			 }
	    }
	  }

	var url="login_handle_ajax.php";
	url=url+"?u="+username;
	url=url+"&p="+password;
	url=url+"&sid="+Math.random()
	//xmlHttp.onreadystatechange=stateChanged(xmlHttp); 
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}

function stateChanged( xmlHttp) 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState==200)
 	{ 
		 var result=xmlHttp.responseText;
		 if(result == "wrong"){
			errormess.style.display = "";                                             
			document.getElementById("error-message").innerHTML = "帐户名或登录密码不正确，请重新输入";       
		 } 
	}
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	 {
		 // Firefox, Opera 8.0+, Safari
 		xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
 		//Internet Explorer
 		try
 		 {
 			 xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  		 }
 		catch (e)
 		 {
 		 	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
 		 }
	 }
 	return xmlHttp;
}

</script>

</head>
<body>
	<div class="htmleaf-container">
		<div class="wrapper">
			<div class="container">
				<h1>Welcome</h1>

				<form class="form">
					<div class="login">
						<input id="yonghu" type="text" placeholder="用户名" name="username">
						<input id="mima" type="password" placeholder="密码" name="password">
					</div>

					<div id="error-mess" style="display: none">
						<span class="error-icon"></span> <span id="error-message"></span>
					</div>

					<div class="aboutpassword">
						<span class="check"> <label> <input type="checkbox" id="remeberMe" class="auto-login">记住密码</label>
						</span>

						<div class="forget-password">
							<a href="http://www.chengxiaoke.cn">忘记密码</a>
						</div>
					</div>

					<button id="login-button" onclick="checkuserinfo()">登录</button>

					<div class="register">
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

	<div
		style="text-align: center; margin: 50px 0; padding-top: 30px; font: normal 14px/24px 'MicroSoft YaHei'; color: #000000; font-size: 17px;">
		<h1>室内无线智能温控平台</h1>
	</div>
</body>
</html>


