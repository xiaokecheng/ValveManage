<?php
	session_start ();

	if(isset($_SESSION ["username"]) &&  isset($_SESSION ["userid"]))
	{
		unset($_SESSION['username']);    //退出之前需要删除session数据
		unset($_SESSION['userid']);
	}
	
	echo "<script>window.location.href='login.php';</script>";
?>