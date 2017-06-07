<?php
	session_start ();
	if(!isset($_SESSION ["username"]) ||  !isset($_SESSION ["userid"]))
	{
		echo "<script>window.location.href='login.php';</script>";
	}
	
	require_once ('connect.php');
	$username = $_SESSION ['username'];
	$sql = "select * from article order by createdatetime desc";

	$query = mysqli_query ( $con, $sql );

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>历史数据</title>

<link rel="icon" href="images\myicon.ico" />
<link rel="shortcut icon" href="images\myicon.ico" />

<link type="text/css" rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="/css/amazeui.css" />


<style type="text/css">
.card-box {
	padding: 20px;
	border-radius: 5px;
	border: 1px solid;
	border-color: rgb(215, 215, 215);
	margin-bottom: 20px;
	background-color: #ffffff;
}
</style>

</head>


<body>

	<div class="top"></div>
	<div id="header">
		<div class="logo">无线智能暖气水阀用户系统</div>
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
					<h4 class="M6" style="background-color: #0075B0;">
						<span></span><a href="history_data.php">历史数据</a>
					</h4>
				</li>

				<li>
					<h4 class="M10">
						<span></span><a href="user_setting.php">用户设置</a>
					</h4>
				</li>

			</ul>
		</div>

		<div class="m-right">
			<div class="right-nav">
				<h2>历史数据</h2>
			</div>

			<div class="main">
				<!-- Start content -->
				<div class="content">

					<div class="am-g">
						<div class="am-u-md-6">
							<!-- 大数据面积图  -->
							<div class="card-box">
								<div id="shuju" style="width: 100%; height: 250px;"></div>
							</div>
						</div>
					</div>

					<div class="remind">
						<p style="color: #555555;">注意：仅保留一个月的历史数据。</p>
						<p style="color: #555555; padding-top: 10px;">操作方法：通过滑动条可以查看一个月内每天的数据。</p>
					</div>
				</div>
			</div>
			<!-- end right Content here -->
			<!--</div>-->
		</div>
	</div>

	<div class="bottom"></div>
	<div id="footer">
		<p>
			Copyright© 2017 版权所有 沈阳航空航天大学自动化学院 
		</p>
	</div>


	<script type="text/javascript" src="js/jquery-2.1.0.js"></script>
	<script type="text/javascript" src="js/amazeui.min.js"></script>
	<script type="text/javascript" src="js/echarts.min.js"></script>
	<script type="text/javascript" src="js/lineChart.js"></script>

</body>

</html>

