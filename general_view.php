<?php
	session_start ();
	if(!isset($_SESSION ["username"]) ||  !isset($_SESSION ["userid"]))
	{
		echo "<script>window.location.href='login.php';</script>";
	}
	require_once ('connect.php');
	
	$username = $_SESSION ['username'];
	$userid = $_SESSION['userid'];
	
	//联结  根据用户ID查询对应系统
	$sql = "select user.sysid ,online from valvesystem,user where user.userid=$userid and user.sysid=valvesystem.sysid";  
	$query = mysqli_query ( $con, $sql );
	
	if ($query && mysqli_num_rows ( $query )) {
		while ( ($row = mysqli_fetch_assoc ( $query )) !== null ) {
			$_SESSION['sysid'] = $row['sysid'];   //将用户对应的系统id保存到session中
			$sysid = $row['sysid'];              
			$online  = $row['online'];           // 0 表示该用户阀门系统现在不在线，1表示在线   根据状况来决定显示元素样式
		}
	} 
	//该用户系统下包含的阀门数
	$sql = "select count(sysid) from valve where sysid= $sysid";     
	$query = mysqli_query ( $con, $sql );
	
	if ($query && mysqli_num_rows ( $query )) {
		while ( ($row = mysqli_fetch_array ($query,2)) !== null ) {
			$valve_count  = $row[0];        
		}
	}
	
?>
<!DOCTYPE>
<html>
<head>
<!--
    	作者：chengxiaoke
    	时间：2017-06-01
    	描述：信息概览
    -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>系统总览</title>

<link rel="icon" href="images\myicon.ico" />
<link rel="shortcut icon" href="images\myicon.ico" />

<link type="text/css" rel="stylesheet" href="css/style.css" />

<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/menu.js"></script>


<style>
.infor-title {
	width: 100%;
	height: 70px;
	margin: 0 auto 20px auto;
	padding-top: 5px;
}

strong {
	font-weight: 700;
}

.info-title-left h3 {
	margin-top: 10px;
	font-size: 18px;
}

.info-title-left {
	float: left;
	color: #333;
}

.info-title-left p {
	line-height: 25px;
	margin: 0 0;
}

.info-title-right {
	float: right;
	height: 60px;
}

.info-title-right p {
	line-height: 25px;
}

#year {
	font-size: 24px;
}

.info-title-right .right-year-month {
	padding: 5px;
	background-color: #0e90d2;
	height: 100%;
	color: #FFF;
}

.right-year-month {
	float: left;
}

.right-hour-minute {
	float: right;
}

.right-hour-minute p {
	float: right;
	color: #0e90d2;
	line-height: 70px;
	background-color: #FFF;
	padding-left: 10px;
	padding-right: 15px;
	font-weight: 700;
	font-size: 34px;
}

.general-descri {
	margin: 30px auto;
	min-width: 1000px;
	height: 300px;
	padding: 20px 20px 10px;
	border-radius: 4px;
	border-width: 1px;
	border-style: solid;
	border-color: rgb(215, 215, 215);
	border-image: initial;
}

.general-descri-content {
	margin: 0 auto;
	padding: 10px 10px 10px;
	height: 200px;
}

.general-descri-content-text {
	text-align: center;
	vertical-align: middle;
	font-size: 14px;
	padding: 0px 10px 10px;
	margin: 0 auto;
}
/*  圆形进度条 */
.circleProgress_wrapper {
	width: 190px;
	height: 190px;
	margin: 10px auto;
	position: relative;
	border: 1px;
}

.wrapper {
	width: 95px;
	height: 190px;
	position: absolute;
	top: 0;
	overflow: hidden; /*重要*/
}

.left {
	left: 0;
}

.right {
	right: 0;
}

.wrapper .left {
	vertical-align: middle;
}

/*正常异常*/
.circleProgress_wrapper p {
	line-height: 40px;
	font-size: 40px;
	font-weight: 700;
	color: green;
}

.circleProgress_lefttext {
	padding-right: 5px;
	padding-top: 75px;
	float: right;
}

.circleProgress_righttext {
	padding-left: 5px;
	padding-top: 75px;
	float: left;
}

.circleProgress {
	width: 160px; /*圆的大小*/
	height: 160px;
	border: 15px solid transparent;
	border-radius: 50%;
	position: absolute;
	top: 0;
	/*-webkit-transform: rotate(-135deg);  */
}

.rightcircle {
	/*border-top: 15px solid green;
	border-right: 15px solid green;  */
	right: 0;
	-webkit-animation: circleProgressLoad_right 1.5s linear;
	-webkit-animation-fill-mode: forwards;
	animation: circleProgressLoad_right 1.5s linear;
	animation-fill-mode: forwards;
	z-index: 1;
}

.leftcircle {
/*	border-bottom: 15px solid green;
	border-left: 15px solid green; */
	left: 0;
	-webkit-animation: circleProgressLoad_left 1.5s linear;
	/*将@keyframes规则绑定到选择器上，否则不会产生动画效果*/
	-webkit-animation-fill-mode: forwards;
	animation: circleProgressLoad_left 1.5s linear;
	/*将@keyframes规则绑定到选择器上，否则不会产生动画效果*/
	animation-fill-mode: forwards;
	z-index: 2;
}
/* @keyframes规则 ，Chrome和Safari需要加前缀-webkit-*/
@-webkit-keyframes circleProgressLoad_right{
	0%{
		-webkit-transform: rotate(-135deg);
	}
	50%{
		-webkit-transform: rotate(45deg);
	}
	100%{
		-webkit-transform: rotate(46deg);
	}
}
@-webkit-keyframes circleProgressLoad_left{
	0%{
		-webkit-transform: rotate(-136deg);
	}
	50%{
		-webkit-transform: rotate(-136deg);
	}
	100%{
		-webkit-transform: rotate(44deg);
	}
}

@keyframes circleProgressLoad_right{
	0%{
		transform: rotate(-135deg);
	}
	50%{
		transform: rotate(45deg);
	}
	100%{
		transform: rotate(46deg);
	}
}
@keyframes circleProgressLoad_left{
	0%{
		transform: rotate(-136deg);
	}
	50%{
		transform: rotate(-136deg);
	}
	100%{
		transform: rotate(44deg);
	}
}

#valvecount {
	font-size: 36px;
	color: #0e90d2;
	font-style: normal;
	font-weight: normal;
}
</style>

<script>

	$(document).ready(function(){
		if(<?php echo $online?>){
		    $(".rightcircle").css({"border-top": "15px solid green","border-right": "15px solid green"});
		    $(".leftcircle").css({"border-bottom": "15px solid green","border-left": "15px solid green"});
		 }
		else{
			$(".circleProgress_wrapper p ").css("color","red");
			$(".rightcircle").css({"border-top": "15px solid red","border-right": "15px solid red"});
		    $(".leftcircle").css({"border-bottom": "15px solid red","border-left": "15px solid red"});	
		}
	});
	
	function setTime(){
		var dateObj = new Date();
		var year = dateObj.getFullYear();//年
   		var month = dateObj.getMonth()+1;//月  (注意：月份+1)    返回值为0-11
   		var daydate = dateObj.getDate();  //月份中的某一天， 返回值为1-31之间的一个整数
    	var dayweek = dateObj.getDay(); //星期中的某一天，返回值是0（周日）到6（周六）之间的一个整数
    	var weeks = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
    	var week = weeks[dayweek];//根据day值，获取星期数组中的星期数。
    	var hours = dateObj.getHours();//小时
    	var minutes = dateObj.getMinutes();//分钟
    	
    	if(month<10){
       		 month = "0"+month;
        }
    	if(daydate<10){
        	daydate = "0"+daydate;
    	}
    	if(hours<10){
        	hours = "0"+hours;
    	}
   		if(minutes<10){
        	minutes = "0"+minutes;
    	}
   		
   		$("#year").html(year);
   		$("#mouth").html(month);
   		$("#week").html(week);
   		$("#day").html(daydate);
   		
   		$("#hour-minute").html(hours+":"+minutes);
	}
	setInterval(function(){setTime()},500);
</script>

</head>

<?php
function weekday() {
	$i = date ( 'w' );
	switch ($i) {
		case 0 :
			$str = "星期日";
			break;
		case 1 :
			$str = "星期一";
			break;
		case 2 :
			$str = "星期二";
			break;
		case 3 :
			$str = "星期三";
			break;
		case 4 :
			$str = "星期四";
			break;
		case 5 :
			$str = "星期五";
			break;
		case 6 :
			$str = "星期六";
			break;
	}
	return $str;
}
?>

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
					<h4 class="M1" style="background-color: #0075B0;">
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
					<h4 class="M10">
						<span></span><a href="user_setting.php">用户设置</a>
					</h4>
				</li>
			</ul>
		</div>

		<div class="m-right">
			<div class="right-nav">
				<h2>用户总览</h2>
			</div>

			<div class="main">

				<!--first layer-->
				<div class="infor-title">
					<div class="info-title-left">
						<h3>
							<strong>Administrator,</strong>
						</h3>
						<p>欢迎登录暖气水阀用户系统!</p>
					</div>
					<div class="info-title-right">
						<div class="right-year-month">
							<p id="week"><?php echo weekday()?></p>
							<!--php中解决初始值问题-->
							<p>
								<span id="year"><?php echo date("Y")?></span> 年 <span id="mouth"><?php echo date("m")?></span>
								月 <span id="day"><?php echo date("d")?></span> 日
							</p>
						</div>
						<div class="right-hour-minute">
							<p id="hour-minute"><?php echo date("H:i")?></p>
						</div>
					</div>
				</div>
				
				<!--second layer-->
				<div class="general-descri">
					<div class="general-descri-title">
						<h3>账户状态</h3>
					</div>

					<div class="general-descri-content">
						<!--圆形滚动条-->
						<div class="circleProgress_wrapper" >
							<div class="wrapper left">
								<div class="circleProgress leftcircle" ></div>
								<div class="circleProgress_lefttext">
									<p><?php if ($online) echo "正";else echo "异"?></p>
								</div>
							</div>

							<div class="wrapper right">
								<div class="circleProgress rightcircle"></div>
								<div class="circleProgress_righttext">
									<p>常</p>
								</div>
							</div>

						</div>

						<div class="general-descri-content-text">
							<p>
								您管理 <span id="valvecount">1</span> 个阀门，
								<span ><?php if ($online) echo "目前都处于正常运行中";else echo "目前系统未在线"?></span>
							</p>
						</div>
					</div>
				</div>


			</div>

		</div>
	</div>
	<div class="bottom"></div>
	<div id="footer">
		<p>Copyright© 2017 版权所有 沈阳航空航天大学自动化学院</p>
	</div>
	<script>navList(12);</script>
</body>
</html>

