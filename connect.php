<?php
require_once('config.php');
//连库
$con = mysqli_connect(HOST, USERNAME, PASSWORD);
if(!$con){
    echo mysql_error();
}
//选择数据库
if(!mysqli_select_db($con,'dianzidasai')){
    echo mysql_error();
}
//字符集
if(!mysqli_query($con,'set names utf8')){
    echo mysql_error();
}

?>