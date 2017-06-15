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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN""http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!--
	作者：chengxiaoke
	时间：2017-06-01
	描述：温度监控
-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>消息中心</title>
<link rel="icon" href="images\myicon.ico" />
<link rel="shortcut icon" href="images\myicon.ico" />

<!--必要样式-->
<link href="css/amazeui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/amazeui.datatables.min.css" />
<link rel="stylesheet" href="css/amazeui.datatables.css" />
<link type="text/css" rel="stylesheet" href="css/style.css" />

<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>

<script type="text/javascript" src="js/amazeui.datatables.min.js"></script>
<script type="text/javascript" src="js/amazeui.datatables.js"></script>

<script type="text/javascript">

$(function() {
    $('.am-table').DataTable();
});

</script>

<style>
.info-center-content {
	margin: 10px auto;
	min-width: 1000px;
	padding: 15px 20px 10px;
	border-radius: 2px;
	border-width: 1px;
	border-style: solid;
	border-color: rgb(215, 215, 215);
	border-image: initial;
}

.info-center-content * {
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
}

.info-center-content  *:before {
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
}

.info-center-content *:after {
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
}

.info-center-title {
	height: 35px;
}

.info-center-title .pull-left {
	padding-right: 20px;
	display: inline-block;
}

.manage-title {
	color: #098cba;
	line-height: 24px;
	font-size: 14px;
}

.info-center-title span a {
	height: 30px;
	cursor: pointer;
	line-height: 30px;
	color: #656565;
	display: block;
	font-weight: 600;
	float: left;
	text-decoration: none;
}

.info-center-title span .active {
	color: #098cba;
	border-bottom: solid 2px #098cba;
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
					<h4 class="M4" style="background-color: #0075B0;">
						<span></span><a href="infor_center.php">消息中心</a>
					</h4>
				</li>

				<li>
					<h4 class="M6">
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
				<h2>消息中心</h2>
			</div>

			<div class="main">
				<div class="info-center-title">
					<span class="padding-large-right manage-title pull-left"> <a
						class="active" href="#">全部消息</a>
					</span> <span class="padding-large-right pull-left"> <a id="read"
						href="#">已读消息( <span style="color: #0e90d2;">1</span> )
					</a>
					</span> <span class="pull-left"> <a id="unread" href="#">未读消息( <span
							style="color: #0e90d2;">0</span> )
					</a>
					</span>
				</div>

				<div class="info-center-content">
					<!--  <form class="am-form">  -->
					<table class="am-table am-table-striped am-table-hover">
						<form class="am-form">
							<thead>
								<tr>
									<!--	<th><input type="checkbox" name="0" id="0" value="true" /> </th>  -->
									<th>ID</th>
									<th>消息名称</th>
									<th>消息类型</th>
									<th>时间</th>

									<th>操作</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<!--	<td><input type="checkbox" name="1" id="1" value="true" /></td>   -->
									<td>1</td>
									<td><a class="info-name" style="cursor: pointer;">实验室1号阀门关闭提醒</a></td>
									<td>已读</td>
									<td>2017-05-19 09:23:10</td>

									<td>
										<div class="am-btn-toolbar">
											<div class="am-btn-group am-btn-group-xs">
												<button
													class="am-btn am-btn-default am-btn-xs am-text-secondary"
													style="margin-right: 5px;">标为已读</button>
												<button
													class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only">删除</button>
											</div>
										</div>
									</td>
									<td></td>
								</tr>


							</tbody>
						</form>
					</table>
					<!--	</form>  -->
				</div>

			</div>

		</div>
	</div>

	<div class="bottom"></div>
	<div id="footer">
		<p>Copyright© 2017 版权所有 沈阳航空航天大学自动化学院</p>
	</div>

</body>
</html>
