<?php
session_start ();
require_once ('connect.php');
// 操作之前，首先要对利用Ajax传输的数据，进行核验
if (! (isset ( $_GET ['valveid'] ) && (! empty ( $_GET ['valveid'] )))) {
	echo "wrong_1";
	exit ();
}

if (! (isset ( $_GET ['status'] ))) {
	echo "wrong_2";
	exit ();
}

$valveid = mysqli_real_escape_string ( $con, $_GET ['valveid'] );
$valvestatus = mysqli_real_escape_string ( $con, $_GET ['status'] );

if ($_GET ['status']){
	$sql = "update valve set status=0 WHERE  valveid='$valveid'";     //根据目前的状态进行改变
}else 
{
	$sql = "update valve set status=1 WHERE  valveid='$valveid'";
}


$query = mysqli_query ( $con, $sql );

if ($query) {
	echo "success";
} else {
	echo "wrong_3";
	exit ();
}

?>