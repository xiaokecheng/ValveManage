<?php
session_start ();
require_once ('connect.php');
// 操作之前，首先要对利用Ajax传输的数据，进行核验
if (! (isset ( $_GET ['startdate'] ) && (! empty ( $_GET ['startdate'] )))) {
	echo "wrong_1";
	exit ();
}

if (! (isset ( $_GET ['enddate'] ))) {
	echo "wrong_2";
	exit ();
}

$startDate = mysqli_real_escape_string ( $con, $_GET ['startdate'] );
$endDate = mysqli_real_escape_string ( $con, $_GET ['enddate'] );


$sql = "select degree,createtime from opening WHERE  valveid=1 and createtime<'$startDate' and createtime>'$endDate'";    

$query = mysqli_query ( $con, $sql );

if ($query && mysqli_num_rows ( $query )) {
	while ( ($row = mysqli_fetch_assoc ( $query )) !== null ) {
		$data [] = $row;
	}
} else {
	echo "wrong";
	exit ();
}

?>