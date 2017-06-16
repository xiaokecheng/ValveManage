<?php
session_start ();
require_once ('connect.php');
// 操作之前，首先要对利用Ajax传输的数据，进行核验
if (! (isset ( $_GET ['valveid'] ) && (! empty ( $_GET ['valveid'] )))) {
	echo "wrong_1";
	exit ();
}

if (! (isset ( $_GET ['openingvalue'] ))) {
	echo "wrong_2";
	exit ();
}

$valveid = mysqli_real_escape_string ( $con, $_GET ['valveid'] );
$valvestatus = mysqli_real_escape_string ( $con, $_GET ['openingvalue'] );

if (!$_GET ['openingvalue']){
	$sql_status = "update valve set status=0 WHERE  valveid='$valveid'";     //如果开度为0的话，相当于阀门关闭，那么也要更新阀门状态
}else 
{
	$sql_status = "update valve set status=1 WHERE  valveid='$valveid'";     //开度为非零，那么阀门状态就为开启
}

$sql_opening = "update valve set opendegree='$valvestatus' WHERE  valveid='$valveid'";

$query_status = mysqli_query ( $con, $sql_status );
$query_opening = mysqli_query ( $con, $sql_opening );

if ($query_status && $query_opening) {
	echo "success";
} else {
	echo "wrong_3";
	exit ();
}

?>