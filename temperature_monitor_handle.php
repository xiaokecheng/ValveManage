<?php
session_start ();
require_once ('connect.php');
// 操作之前，首先要对利用Ajax传输的数据，进行核验
if (! (isset ( $_GET ['valveid'] ) && (! empty ( $_GET ['valveid'] )))) {
	echo "";
	exit ();
}

$valveid = mysqli_real_escape_string ( $con, $_GET ['valveid'] );

$sql = "SELECT watertemp,indoortemp FROM temperature WHERE  valveid='$valveid' order by time desc limit 1";  // 获取最近一条数据

$query = mysqli_query ( $con, $sql );

if ($query && mysqli_num_rows ( $query )) {
	while ( ($row = mysqli_fetch_assoc ( $query )) !== null ) {
		$data [] = $row;
	}
} else {
	echo "";
	exit ();
}

if (empty ( $data )) {  
	echo "";
	exit ();
} else {
	foreach ( $data as $value ) {
		    $result = $value["watertemp"].",".$value["indoortemp"];
			echo $result;
		}
	}

?>