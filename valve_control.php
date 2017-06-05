<?php 
    session_start();
	require_once('connect.php');
	$username = $_SESSION['username'];
	$sql = "select * from article order by createdatetime desc";   
	
	$query = mysqli_query($con,$sql);
	
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
<link rel="stylesheet" href="css/amazeui.datatables.min.css"/>
<link rel="stylesheet" href="css/amazeui.datatables.css"/>
<link type="text/css" rel="stylesheet" href="css/style.css" />

<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="js/goal-thermometer.js"></script>
<script type="text/javascript" src="js/amazeui.datatables.min.js"></script>
<script type="text/javascript" src="js/amazeui.datatables.js"></script>

<script type="text/javascript">

$(function() {
    $('.am-table').DataTable();
});

</script>

</head>
<body>  

<div class="top"></div>
<div id="header">
	<div class="logo">无线智能暖气水阀用户系统</div>
	<div class="navigation">
		<ul>
		 	<li>欢迎您！</li>
			<li><a href="user_setting.php"><?php echo $username?></a></li>
			
			<li><a href="">退出</a></li>
		</ul>
	</div>
</div>

<div id="content">
	<div class="left_menu">
	  <ul id="nav_dot">
       <li>
          <h4 class="M1"><span></span><a href="general_view.php">用户总览</a></h4>
        </li>
        
        <li>
          <h4 class="M2"><span></span><a href="temperature_monitor.php">温度监控</a></h4>
        </li>
        
        <li>
          <h4 class="M3" style="background-color: #0075B0;"><span></span><a href="valve_control.php">阀门管理</a></h4>
        </li>
        
		<li>
          <h4 class="M4"><span></span><a href="infor_center.php">消息中心</a></h4>
        </li>
        
		<li>
          <h4  class="M6"><span></span><a href="history_data.php">历史数据</a></h4>
       </li>
        
		<li>
          <h4   class="M10"><span></span><a href="user_setting.php">用户设置</a></h4>
        </li>
      </ul>
	</div>
	
	<div class="m-right">
		<div class="right-nav">
			<h2>阀门管理</h2>
		</div>
		
	   <div class="main">	
	   	
	   		<div class="thermometer-select" >
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
           				     <th>最大温度阈值</th>
           				     <th>最小温度阈值</th>
           				    <th>操作</th>
           				    <th>备注</th>
       				    </tr>
    				</thead>
    				<tbody>
        				<tr>
        				<!--	<td><input type="checkbox" name="1" id="1" value="true" /></td>  -->
            				<td>1</td>
            				<td>实验室1号阀门</td>
            				<td>开</td>
            				<td>2017-05-19 09:23:10</td>
            				<td>49℃</td>
            				<td>8℃</td>
            				<td>
            				 	<div class="am-btn-toolbar">
                   					 <div class="am-btn-group am-btn-group-xs">
                      						<button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span ></span>编辑</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span></span> 打开</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span></span> 关闭</button>
                                	 </div>
                 				 </div>
            				</td>
            				<td></td>
        				</tr>
        				<tr>
        				<!--	<td><input type="checkbox" name="2" id="2" value="true" /></td> -->
            				<td>2</td>
            				<td>实验室2号阀门</td>
            				<td>关</td>
            				<td>2017-05-19 09:23:10</td>
            				<td>49℃</td>
            				<td>8℃</td>
            				<td>
            					<div class="am-btn-toolbar">
                   					 <div class="am-btn-group am-btn-group-xs">
                      						<button class="am-btn am-btn-default am-btn-xs am-text-secondary" ><span ></span>编辑</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span></span> 打开</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span></span> 关闭</button>
                                	 </div>
                 				 </div>
            				</td>
            				<td>暂未开通</td>
        				</tr>
        				<tr >
        				<!--	<td><input type="checkbox" name="3" id="3" value="true" /></td>  -->
            				<td>3</td>
            				<td>实验室3号阀门</td>
            				<td>关</td>
            				<td>2017-05-19 09:23:10</td>
            				<td>49℃</td>
            				<td>8℃</td>
            				<td>
   								<div class="am-btn-toolbar">
                   					 <div class="am-btn-group am-btn-group-xs">
                      						<button class="am-btn am-btn-default am-btn-xs am-text-secondary" ><span ></span>编辑</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span></span> 打开</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span></span> 关闭</button>
                                	 </div>
                 				 </div>            				
            				</td>
            				<td>暂未开通</td>
        				</tr>
      					<tr>
      					<!--	<td><input type="checkbox" name="4" id="4" value="true" /></td>  -->
            				<td>4</td>
            				<td>办公室1号阀门</td>
            				<td>关</td>
            				<td>2017-05-19 09:23:10</td>
            				<td>49℃</td>
            				<td>8℃</td>
            				<td>
    							<div class="am-btn-toolbar">
                   					 <div class="am-btn-group am-btn-group-xs">
                      						<button class="am-btn am-btn-default am-btn-xs am-text-secondary" ><span ></span>编辑</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span></span> 打开</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span></span> 关闭</button>
                                	 </div>
                 				 </div>           				
            				</td>
            				<td>暂未开通</td>
        				</tr>
        				<tr>
        				<!--	<td><input type="checkbox" name="5" id="5" value="true" /></td>   -->
             				<td>5</td>
            				<td>办公室2号阀门</td>
            				<td>关</td>
            				<td>2017-05-19 09:23:10</td>
            				<td>49℃</td>
            				<td>8℃</td>
            				<td>
    							<div class="am-btn-toolbar">
                   					 <div class="am-btn-group am-btn-group-xs">
                      						<button class="am-btn am-btn-default am-btn-xs am-text-secondary"><span ></span>编辑</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-hide-sm-only"><span></span> 打开</button>
                      						<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span></span> 关闭</button>
                                	 </div>
                 				 </div>           				
            				</td>
            				<td>暂未开通</td>
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
<div id="footer"><p>Copyright©  2017 版权所有 沈阳航空航天大学自动化学院 </p></div>
<script>navList(12);</script>

</body>
</html>
