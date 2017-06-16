<?php
	session_start ();
	if(!isset($_SESSION ["username"]) ||  !isset($_SESSION ["userid"]))
	{
		echo "<script>window.location.href='login.php';</script>";
	}
	
	require_once ('connect.php');
	$username = $_SESSION ['username'];
	$userid = $_SESSION ['userid'];

	$sql = "SELECT * FROM user WHERE userid='$userid'";
	$query = mysqli_query ( $con, $sql );
	$row = mysqli_fetch_assoc ( $query );

	$telephone = $row ['telephone'];
	$email = $row ['email'];

	$userid_format = str_pad ( $userid, 6, '0', STR_PAD_LEFT );   //账号ID形式：000001，共六位，左端补零
?>
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加控制阀门</title>

<link rel="icon" href="images\myicon.ico" />
<link rel="shortcut icon" href="images\myicon.ico" />

<link type="text/css" rel="stylesheet" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/menu.js"></script>

<style>
a,a:hover, a:focus {
    color: #000; 
}

.main-mod p {
	font-size: 14px;
	padding-bottom: 20px;
	padding-left: 10px;
}

.revisepass-but {
	margin-left: 10px;
	margin-top: 20px;
	height: 40px;
	font-size: 14px;
	padding: 10px;
	color: #0088CC;
	cursor: pointer;
	font-weight: 700;
}

.right-nav h2{
	padding-left: 0px;
	margin-right:0px;
}

.first_class{
	cursor: pointer;
	padding-left: 20px;
    display: inline-block;
    vertical-align: middle;
    font-size: 22px;
    font-weight: 400;
    margin-right: 5px; 
    max-width: 70%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.account-box {
	border-bottom: 1px solid rgb(215, 215, 215);
}

.modify input {
    outline: 0;
    border: 1px solid rgba(156, 156, 156, 0.4);
    background-color: rgba(255, 255, 255, 0.2);
    width: 250px;
    border-radius: 3px;
    padding: 8px 15px;
    margin: 0 10px 10px 10px;
    display: block;
    text-align: left;
    font-size: 16px;
    color: #000000;
    -webkit-transition-duration: 0.25s;
    transition-duration: 0.25s;
    font-weight: 300;
}

form button {
    clear: both;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: 0;
    background-color: #0e90d2;
    border: 0;
    margin: 30px 10px 10px 30px;
    padding: 10px 15px;
    color: #ffffff;
    border-radius: 3px;
    width: 200px;
    cursor: pointer;
    font-size: 18px;
}

.am-admin{
	margin:0 auto;
	width:500px;
}

.add_admin_form{
	padding-bottom: 50px;
    border-bottom: 1px solid rgb(215, 215, 215);
}

</style>

</head>

<body>
	<div class="top"></div>
	<div id="header">
		<div class="logo">室内无线智能温控平台</div>
		<div class="navigation">
			<ul>
				<li>欢迎您！</li>
				<li><a href="user_setting.php"><?php echo $username?></a></li>

				<li><a href="quit_handle.php">退出</a></li>
			</ul>
		</div>
	</div>

	<div id="content">
		<div class="left_menu">
			<ul id="nav_dot">
				<li>
					<h4 class="M1">
						<span></span><a href="general_view.php">用户总览</a>
					</h4>
				</li>

				<li>
					<h4 class="M2">
						<span></span><a href="temperature_monitor.php">温度监控</a>
					</h4>
				</li>

				<li>
					<h4 class="M3">
						<span></span><a href="valve_control.php">阀门管理</a>
					</h4>
				</li>

				<li>
					<h4 class="M4">
						<span></span><a href="infor_center.php">消息中心</a>
					</h4>
				</li>

				<li>
					<h4 class="M6">
						<span></span><a href="history_data.php">历史数据</a>
					</h4>
				</li>

				<li>
					<h4 class="M10" style="background-color: #0075B0;">
						<span></span><a href="user_setting.php">用户设置</a>
					</h4>
				</li>
			</ul>
		</div>

		<div class="m-right">
			<div class="right-nav">
				<a class="first_class" href="user_setting.php">用户设置</a>
				<h2>>></h2>
				<h2 >添加阀门</h2>
			</div>
			<div class="main">

				<form class="add_admin_form">
					<div class="modify">
					
						<span>阀门ID:</span><input  type="text" placeholder="" name="yonghuming">
						<span>阀门名称:</span><input  type="text" placeholder="" name="email">
						<span>最大温度阈值:</span><input  type="text" placeholder="" name="dianhua">
						<span>最小温度阈值:</span><input  type="text" placeholder="" name="yonghumima">
						<span>备注:</span><input  type="text" placeholder="" name="querenmima">
					</div>


					<div class="save_modify">
					<button id="login-button" onclick="checkuserinfo()">保存</button>
					</div>
					

				</form>
			
			</div>

		</div>
	</div>
	<div class="bottom"></div>
	<div id="footer">
		<p>
			Copyright© 2017 版权所有 沈阳航空航天大学自动化学院
		</p>
	</div>
	<script>navList(12);</script>
</body>
</html>

