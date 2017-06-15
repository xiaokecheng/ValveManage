<?php
	session_start ();
	if(!isset($_SESSION ["username"]) ||  !isset($_SESSION ["userid"]))
	{
		echo "<script>window.location.href='login.php';</script>";
	}
	
	if(!isset($_SESSION ["sysid"]))
	{	
		echo "<script>window.location.href='general_view.php';</script>";
	}
	
	require_once ('connect.php');
	$username = $_SESSION ['username'];
	$sysid = $_SESSION['sysid'];
	
	$sql = "select online from valvesystem where sysid=$sysid";
	$query = mysqli_query ( $con, $sql );
	$row = mysqli_fetch_assoc($query);
	$valve_online = $row["online"];

	$valveid =1;              //通过用户系统id查询拥有的阀门，通过“显示温度”按钮将需要显示温度的阀门id赋值给它，默认对应id为1的阀门
	$sql = "SELECT watertemp,indoortemp FROM temperature WHERE  valveid='$valveid' order by time desc limit 1";  // 获取最近一条数据，两则用处，一是温度计，而是列表中的初始值
	$query = mysqli_query ( $con, $sql );
	//页面加载时的最新数据
	if ($query && mysqli_num_rows ( $query )) 
	{	
		$row = mysqli_fetch_assoc($query);
		$valve_currentAmount = $row["watertemp"];
		$indoor_currentAmount = $row["indoortemp"];
	}   
	else 
	{	
		$valve_currentAmount = 0;
		$indoor_currentAmount = 0;
	}   
	
	if(!$valve_online){
		$valve_currentAmount = 0;
		$indoor_currentAmount = 0;
	}
	
	//表格填充
	$sql = "select * from valve where sysid=$sysid ";
	$query = mysqli_query ( $con, $sql );
	if($query&&mysqli_num_rows($query)){
		while(($row = mysqli_fetch_assoc($query)) !== null){
			$data[] = $row;
		}
	}
	
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
<title>温度监控</title>
<link rel="icon" href="images\myicon.ico" />
<link rel="shortcut icon" href="images\myicon.ico" />

<!--必要样式-->
<link href="css/amazeui.css" rel="stylesheet" type="text/css" />
<link href="css/goal-thermometer.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/amazeui.datatables.min.css" />
<link rel="stylesheet" href="css/amazeui.datatables.css" />
<link type="text/css" rel="stylesheet" href="css/style.css" />

<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/goal-thermometer.js"></script>
<script type="text/javascript" src="js/amazeui.datatables.min.js"></script>
<script type="text/javascript" src="js/amazeui.datatables.js"></script>

<style>

#error-mess{
	overflow: hidden;
	background: #fff0f0;
	text-align: left;
	height: 30px;
	width: 100%;
	padding-top: 1px ;
	margin: 0 auto;
	margin-bottom: 10px;
	border: 1px solid #ffd2d2;
	color: #b74d46;
	font-size: 16px;
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	line-height: 30px;
}

#error-mess .error-icon{
	display: inline-block;
	background: url(https://passport.csdn.net/images/login-logic-icons.png) no-repeat 0 0;
	width: 18px;
	height: 18px;
	vertical-align: middle;
	margin: -4px 5px 0 5px;
}

.main{
	padding-top:10px;
}

#thermometerdisplay{
	margin-top:10px;
}

</style>
<script type="text/javascript">
var temp_valveid=1;   //目前温度计绑定的阀门ID
var valve_currentAmount = <?php echo $valve_currentAmount?>;
var indoor_currentAmount = <?php echo $indoor_currentAmount?>;

$(function() {
   	$('.am-table').DataTable();
});

function conTempDis(valveid){
	if(<?php echo $valve_online?>){
		temp_valveid = valveid;
	}
	else
		alert("当前系统不在线");
	//var id = valveid.toString();
	//alert("显示ID为 "+id+" 的阀门模块温度");
}


setInterval(function(){setTime()},5000);   //每5秒刷新一次
function setTime(){
	if(<?php echo $valve_online?>){         //判断系统在线与否
		updateTemper();
	}
	animateThermometer(indoor_currentAmount,indoor_mercuryId,indoor_tooltipId);
	animateThermometer(valve_currentAmount,valve_mercuryId,valve_tooltipId);	
}

//Ajax
function updateTemper()
{
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
			 var separator = result.indexOf(",");
			 valve_currentAmount = result.substring(0,separator);
			 indoor_currentAmount = result.substring(separator+1,result.length);
			 
			 //valvevalue_id值
			 var  id_string = temp_valveid.toString();
			 var  valvevalue_id = $("#"+"valvevalue_"+id_string);
			 var  indoorvalue_id = $("#"+"indoorvalue_"+id_string);

			 valve_currentAmount = parseFloat(valve_currentAmount);
			 valve_currentAmount = valve_currentAmount.toFixed(2);            //保留2位小数

			 valve_currentAmount = parseFloat(valve_currentAmount);
			 valve_currentAmount = valve_currentAmount.toFixed(2);            //保留2位小数
			 valvevalue_id.text(valve_currentAmount );
			 indoorvalue_id.text(indoor_currentAmount);
		  }   
	}

	var url="temperature_monitor_handle.php";
	var valveid =temp_valveid;
	url=url+"?valveid="+valveid;
	url=url+"&sid="+Math.random()
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
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
					<h4 class="M2" style="background-color: #0075B0;">
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

				<h2>温度监控</h2>
			</div>

			<div class="main">
			
				<div id="error-mess" style="display:<?php if ($valve_online) echo "none"?> ">
						<span class="error-icon"></span> <span id="error-message">当前系统不在线</span>
				</div>
				
				<div class="thermometer-select">
					<!--  <form class="am-form">  -->
					<table class="am-table am-table-striped am-table-hover">
						<form class="am-form">
							<thead>
								<tr>
									<!--	<th> </th>   -->
									<th>阀门ID</th>
									<th>名称</th>
									<th>状态</th>
									<th>创建时间</th>
									<th>当前阀门温度</th>
									<th>当前室内温度 </th>
									<th>操作</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody>
							
							  <?php 
							 	if(empty($data)){
							 		echo "当前用户未添加阀门，请联系管理员";
							 	}else{
							 		$index =1;
							 		foreach($data as $value){
							 ?>
							 <tr>
									<!--	<td><input type="checkbox" name="1" id="1" value="true" /></td>  -->
									<td><?php echo $index++?></td>
									<td><?php echo $value['valvename']?></td>
									<td id="<?php echo "valveid_".$value['valveid']?>"><?php if ($value['status']) echo "开启";else echo "关闭"?></td>
									<td><?php echo $value['createtime']?></td>
									<td ><span id="<?php echo "valvevalue_".$value['valveid']?>"> <?php  if ($value['work'] && $valve_currentAmount!==0) echo sprintf("%.2f",$valve_currentAmount); else echo 0;?></span>℃</td>
									<td ><span id="<?php echo "indoorvalue_".$value['valveid']?>"> <?php if ($value['work'] && $indoor_currentAmount!==0) echo sprintf("%.2f",$indoor_currentAmount); else echo 0;?></span>℃</td>
									<td>
										<div class="am-btn-toolbar">
											<div class="am-btn-group am-btn-group-xs">
												<button
													class="am-btn am-btn-default am-btn-xs am-text-secondary" 
													<?php if (!$value['work']) echo "disabled='disabled'" ?>
													onclick="conTempDis('<?php echo $value['valveid']?>')">
													<span></span>温度计显示
												</button>
											</div>
										</div>
									</td>
									<td><?php echo $value['ps']?></td>
								</tr>
					
							  <?php 
							 								}
							 		}
							 ?>
			
							</tbody>
						</form>
					</table>
					<!--	</form>  -->
				</div>

				<div id="thermometerdisplay">
					<div class="valve-div">
						<h3>水阀温度</h3>
						<div class="goal-thermometer" id="valve-thermometer"></div>
					</div>
					<div class="indoor-div">
						<h3>室内温度</h3>
						<div class="goal-thermometer" id="indoor-thermometer"></div>
					</div>

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
