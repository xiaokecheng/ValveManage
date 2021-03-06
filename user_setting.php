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

	$userid_format = str_pad ( $userid, 6, '0', STR_PAD_LEFT );
?>
<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户设置</title>

<link rel="icon" href="images\myicon.ico" />
<link rel="shortcut icon" href="images\myicon.ico" />

<link type="text/css" rel="stylesheet" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/menu.js"></script>

<style>
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

.account-box {
	border-bottom: 1px solid rgb(215, 215, 215);
}

.revise-password {
	padding-bottom: 80px;
	border-bottom: 1px solid rgb(215, 215, 215);
}
</style>

<script type="text/javascript">


</script>

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
				<h2>用户设置</h2>
			</div>
			<div class="main">

				<div class="account-box main-mod" style="margin-bottom: 30px;">
					<h2 style="font-weight: bold;">账户信息</h2>
					<p style="padding-top: 20px;">注册账号：<?php echo $email?></p>
					<p>账号ID：<?php echo $userid_format?></p>
					<p>电话：<?php echo $telephone?></p>
					<p>主管理员姓名：<?php echo $username?></p>
				</div>
				<div class="safe-info">
					<h2 style="font-weight: bold;">账户管理</h2>

					<form class="revise-password">
						<button class="revisepass-but" type="button" onclick="window.location.href='modify_password.php'">修改密码</button>
						<button class="revisepass-but" type="button" onclick="window.location.href='modify_user_info.php'">修改账户信息</button>
						<button class="revisepass-but" type="button" onclick="window.location.href='add_admin.php'">添加管理员</button>
						<button class="revisepass-but" type="button" onclick="window.location.href='add_valve.php'">添加阀门</button>
						<button class="revisepass-but" type="button" onclick="alert('该功能暂未开启')">自动开关阀门</button>
					</form>
				</div>
			</div>

		</div>
	</div>
	<div class="bottom"></div>
	<div id="footer">
		<p>
			Copyright© 2017 版权所有 沈阳航空航天大学自动化学院
		</p>
	</div>
</body>
</html>

