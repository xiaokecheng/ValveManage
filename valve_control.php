<?php
	session_start ();
	require_once ('connect.php');
	
	if(!isset($_SESSION ["username"]) ||  !isset($_SESSION ["userid"]))
	{
		echo "<script>window.location.href='login.php';</script>";
	}
	
	if(!isset($_SESSION ["sysid"]))
	{
		echo "<script>window.location.href='general_view.php';</script>";
	}
	
	$username = $_SESSION ['username'];
	$userid = $_SESSION['userid'];
	$sysid = $_SESSION['sysid'];
	
	
	$sql = "select online from valvesystem where sysid=$sysid";
	$query = mysqli_query ( $con, $sql );
	$row = mysqli_fetch_assoc($query);
	$valve_online = $row["online"];
	
	$sql = "select * from valve where sysid=$sysid ";
	$query = mysqli_query ( $con, $sql );
	if($query&&mysqli_num_rows($query))
	{
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
<title>阀门控制</title>
<link rel="icon" href="images\myicon.ico" />
<link rel="shortcut icon" href="images\myicon.ico" />

<!--必要样式-->
<link href="css/amazeui.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/amazeui.datatables.min.css" />
<link rel="stylesheet" href="css/amazeui.datatables.css" />
<link rel="stylesheet" href="css/amazeui.datetimepicker.css" />
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/amazeui.chosen.css" />

<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/goal-thermometer.js"></script>
<script type="text/javascript" src="js/amazeui.datatables.min.js"></script>
<script type="text/javascript" src="js/amazeui.datatables.js"></script>
<script type="text/javascript" src="js/amazeui.min.js"></script>
<script type="text/javascript" src="js/amazeui.datetimepicker.min.js"></script>
<script type="text/javascript" src="js/amazeui.chosen.min.js"></script>

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

.flow_query {
    border-radius: 2px;
    padding: 15px 10px 10px 20px;
	min-width:1000px;
    border-width: 1px;
    border-style: solid;
    border-color: rgb(215, 215, 215);
    border-image: initial;
    margin: 20px auto;
}

.flow_query h2{
	font-weight:bold;
}  

.c_oneline{
	margin:0 10px;
	
}

//<!--时间选择器-->
.am-form-field{
	display:inline;
	
}

.am-form select,
.am-form textarea,
.am-form input[type="text"],
.am-form input[type="password"],
.am-form input[type="datetime"],
.am-form input[type="datetime-local"],	
.am-form input[type="date"],
.am-form input[type="month"],
.am-form input[type="time"],
.am-form input[type="week"],
.am-form input[type="number"],
.am-form input[type="email"],
.am-form input[type="url"],
.am-form input[type="search"],
.am-form input[type="tel"],
.am-form input[type="color"],
.am-form-field {
	display: inline;
	width:15%;
}

.date_descri{
	
}

.flow_query form{
	padding:10px;
}

.begin_date{
	display: inline;
	padding-right:10px;
	margin-right:3%;
}

.end_date{
	display: inline;
	padding-right:10px;
	margin-right:3%;
}

.result_dis{
	display: inline;
	padding-right:10px;
	margin-right:3%;
}

.b_queryflow{
	display: inline;
}

.b_queryflow button {
    clear: both;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: 0;
    background-color: #0e90d2;
    border: 0;
    margin: 5px 10px 5px 10px;
    padding: 10px 15px;
    color: #ffffff;
    border-radius: 3px;
    width: 100px;
    cursor: pointer;
    font-size: 14px;
}

</style>

<script type="text/javascript">

var startDate = new Date();
var endDate = new Date();
var temp=new Date();

$(function() {
	 $('.am-table').DataTable();
	 
   
    var $alert = $('#my-alert');
    
    $('#begin_datetimepicker').datepicker().
      on('changeDate.datepicker.amui', function(event) {
    	  if (event.date.valueOf() > temp.valueOf()) {
              $alert.find('p').text('开始日期应不大于今天！').end().show();
            }  else{
        if (event.date.valueOf() > endDate.valueOf()) {
          $alert.find('p').text('开始日期应小于结束日期！').end().show();
        } else {
          $alert.hide();
          $('#begin_datetimepicker').text($('#my-start').data('date'));
        }
            }
        startDate = new Date(event.date);
        $(this).datepicker('close');
      });

    
    $('#end_datetimepicker').datepicker().
      on('changeDate.datepicker.amui', function(event) {
    	  if (event.date.valueOf() > temp.valueOf()) {
              $alert.find('p').text('结束日期应不大于今天！').end().show();
            }  else{
        if (event.date.valueOf() < startDate.valueOf()) {
          $alert.find('p').text('结束日期应大于开始日期！').end().show();
        } else {
          $alert.hide();
         
          $('end_datetimepicker').text($('#my-end').data('date'));
        }
            }
        endDate = new Date(event.date);
        $(this).datepicker('close');
      });
    
  });

$('#begin_datetimepicker').datetimepicker({
	  format: 'yyyy-mm-dd'
	});

$('#end_datetimepicker').datetimepicker({
	  format: 'yyyy-mm-dd'
	});

function conEditMes(valveid){
	if(!<?php echo $valve_online?>){
		alert("当前系统不在线，暂不可编辑操作");
		return;
	}
	
	var id = valveid.toString();
	alert("编辑ID为 "+id+" 的阀门，该功能尚未开启");
}

function conOpenMes(valveid,valvename,status){

	if(!<?php echo $valve_online?>){
		alert("当前系统不在线，暂不可打开操作");
		return;
	}

	if(status){
		alert("该阀门已经打开");
		return ;
	}

	 if (confirm("你确认要打开  "+ valvename +"  么")) {
		 changeValveStatus(valveid, status);
     }
     else {
         
     }
}

function conCloseMes(valveid,valvename,status){

	if(!<?php echo $valve_online?>){
		alert("当前系统不在线，暂不可关闭操作");
		return;
	}

	 if(!status){
		alert("该阀门已经关闭");
		return;
	 }
	 
	 if (confirm("你确认要关闭  "+ valvename +"  么")) {
		 changeValveStatus(valveid, status);
   }
   else {
       
   }
}

//水阀流量查询
function flowquery(){

	 var $alert = $('#my-alert');
	 $('#flow_result').val("");           //结果赋值
	 if (startDate.valueOf() > temp.valueOf()) {
         $alert.find('p').text('开始日期应不大于今天！').end().show();
         return ;
       } 
	 if (startDate.valueOf() > endDate.valueOf()) {
         $alert.find('p').text('开始日期应不大于结束日期！').end().show();
         return ;
       } 

	 if (endDate.valueOf() > temp.valueOf()) {
         $alert.find('p').text('结束日期应不大于今天！').end().show();
         return ;
       } 
     
	//var starttime = formatDate(startDate);      //2017-06-15 形式
	//var endtime = formatDate(endDate);

	 var haoqi = endDate - startDate;
	 var starttime= Date.parse(startDate);        //时间戳形式
	 var endtime = Date.parse(endDate);
	 var chazhi = endtime-starttime;
	 var days1=Math.floor(chazhi/(24*3600*1000));
	 var days2=Math.floor(haoqi/(24*3600*1000)); 
	 
	//alert("startDate:"+ starttime+"   endDate:"+endtime);
	//QueryValveFlow(starttime,endtime);             //利用Ajax查询数据库，计算流量

	  var result = days1*64.34;
      result = result.toFixed(2);
	  $('#flow_result').val(result+" T");           //结果赋值

}

function formatDate(date) {
	  var d = new Date(date),
	    month = '' + (d.getMonth() + 1),
	    day = '' + d.getDate(),
	    year = d.getFullYear();

	  if (month.length < 2) month = '0' + month;
	  if (day.length < 2) day = '0' + day;

	  return [year, month, day].join('-');
	}

//Ajax   参数依次为：开始日期，结束日期
function QueryValveFlow(startdate, enddate )
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
			 if(result == "success"){
				 alert("操作成功");    
				 window.location.href="valve_control.php";
			 } 
			 else 
			 {
				 alert("操作失败，请重试");    
			 }
		  }   
	}

	var url="query_flow_handle.php";
	//url=url+"?valveid="+valveid;     //下一步需要细化的东西，主阀门。在这先默认为1
	url=url+"?startdate="+startdate;
	url=url+"&enddate="+enddate;
	url=url+"&sid="+Math.random();
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}



//Ajax   参数依次为：被操作的阀门ID，该阀门现在的状态
function changeValveStatus(valveid, status )
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
			 if(result == "success"){
				 alert("操作成功");    
				 window.location.href="valve_control.php";
			 } 
			 else 
			 {
				 alert("操作失败，请重试");    
			 }
		  }   
	}

	var url="valve_control_handle.php";
	url=url+"?valveid="+valveid;
	url=url+"&status="+status;
	url=url+"&sid="+Math.random();
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
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


function selectchange(valveid,value){
	//alert(valveid +"," +value);    // just for test
	changeValveOpening(valveid,value);
}

//Ajax   参数依次为：被操作的阀门ID，该阀门现在的状态
function changeValveOpening(valveid, value )
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
			 if(result == "success"){
				 alert("操作成功");    
				 window.location.href="valve_control.php";
			 } 
			 else 
			 {
				 alert("操作失败，请重试");    
			 }
		  }   
	}

	var url="opening_set_handle.php";
	url=url+"?valveid="+valveid;
	url=url+"&openingvalue="+value;
	url=url+"&sid="+Math.random();
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
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
					<h4 class="M2">
						<span></span><a href="temperature_monitor.php">温度监控</a>
					</h4>
				</li>

				<li>
					<h4 class="M3" style="background-color: #0075B0;">
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
				<h2>阀门管理</h2>
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
									<th>ID</th>
									<th>名称</th>
									<th>状态</th>
									<th>开度</th>
									<th>创建时间</th>
									<th>最大阈值</th>
									<th>最小阈值</th>
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
									<td>  
									<select data-am-selected="{btnWidth:'100px',btnSize: 'sm'}" class="my_select_box" 
									id="select_<?php echo $value['valveid']?>" 
									onchange="selectchange(<?php echo $value['valveid']?>,this.value)"
									<?php if (!$value['work']) echo "disabled='disabled'" ?>>
 										<option value="0" <?php  if($value['opendegree']==0) echo "selected" ?>  >0%</option>
  										<option value="1"  <?php  if($value['opendegree']==1) echo "selected" ?> >20%</option>
  										<option value="2"   <?php  if($value['opendegree']==2) echo "selected" ?>>50%</option>
  										<option value="3"  <?php  if($value['opendegree']==3) echo "selected" ?> >80%</option>
  										<option value="4"  <?php  if($value['opendegree']==4) echo "selected" ?> >100%</option>
									</select>
									</td>
									<td><?php echo $value['createtime']?></td>
									<td><?php echo $value['maxtemp_threshold']?>℃</td>
									<td><?php echo $value['mintemp_threshold']?>℃</td>
									<td>
										<div class="am-btn-toolbar">
											<div class="am-btn-group am-btn-group-xs">
												<button
													class="am-btn am-btn-default am-btn-xs am-text-secondary"  onclick="conEditMes('<?php echo $value['valveid']?>')">
													<span></span>编辑
												</button>
												<button
													class="am-btn am-btn-default am-btn-xs am-hide-sm-only"  onclick="conOpenMes('<?php echo $value['valveid']?>','<?php echo $value['valvename']?>',<?php echo $value['status']?>)">
													<span></span> 打开
												</button>
												<button
													class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"  onclick="conCloseMes('<?php echo $value['valveid']?>','<?php echo $value['valvename']?>',<?php echo $value['status']?>)" >
													<span></span> 关闭
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
				
				<div class="flow_query">
				 	<h2>用户水阀流量查询</h2>
				 	
				 	
				 	<div class="c_oneline">
				 	<form >
				 	  <div class=" begin_date">
				 	  		<span class="date_descri">开始时间： </span>
				 	  		<input type="text" value="<?php echo date('Y-m-d')?>" id="begin_datetimepicker" class="am-form-field"  data-am-datepicker>
				 	  		<i class="icon-th am-icon-calendar"></i>
				 	  </div>
				 		
				 	  <div class="end_date">	
				 	  		<span class="date_descri">终止时间： </span>
				 	  		<input type="text" value="<?php echo date('Y-m-d')?>" id="end_datetimepicker" class="am-form-field" data-am-datepicker>
				 	  		<i class="icon-th am-icon-calendar"></i>
				 	  </div>
			 
				 	  <div class="result_dis">
				 	  		<span class="date_descri">查询显示： </span><input type="text" value="" id="flow_result" class="am-form-field" readonly="readonly">
				 	  </div>
				 	  
				 	   <div class="b_queryflow">
							<button id="login-button" type="button" onclick="flowquery()">查询</button>
					  </div>
				 	  
				 	</form>
				   </div>
				   
				   	<div class="am-alert am-alert-danger" id="my-alert" style="display: none;margin-top:0;width:85%; padding-left:20px">
 						 <p>开始日期应小于结束日期！</p>
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
