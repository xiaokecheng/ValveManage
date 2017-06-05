<?php
    session_start();
	require_once('connect.php');
	//把传递过来的信息入库,在入库之前对所有的信息进行校验。
	if(!(isset($_POST['username'])&&(!empty($_POST['username'])))){
		echo "<script>alert('用户名不能为空');window.location.href='login.php';</script>";
	}
	
	$user =mysqli_real_escape_string($con,$_POST['username']);
	$pwd = mysqli_real_escape_string($con,$_POST['password']);
	$sql = "SELECT * FROM user WHERE username='$user' AND password='$pwd'";
	
	$query = mysqli_query($con,$sql);
	
	if($query&&mysqli_num_rows($query)){
	    while(($row = mysqli_fetch_assoc($query))!==null){
	        $data[] = $row;
	    }
	}
	else echo "<script>alert('密码错误');window.location.href='login.php';</script>";
	
	if(empty($data)){
	    echo "<script>alert('密码错误');window.location.href='login.php';</script>";
	}else{
	    foreach($data as $value){
	        
	        if ($value['username']==$user && $value['password']==$pwd)
	        {
	            $_SESSION["username"] = $user;  //session变量保存的信息是单一用户的，可供应用程序的所有页面使用，是服务器端的临时储藏室
	            $_SESSION["userid"] =$value['userid'];//在用户离开网站后将被删除
	            echo "<script>window.location.href='general_view.php';</script>";
	        }
	    }
	    echo "<script>alert('密码错误');window.location.href='login.php';</script>";
	}

?>