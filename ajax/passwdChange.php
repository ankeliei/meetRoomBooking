<?php
session_start();
if($_SESSION['id']==null){
    echo 2;
    return;
}

$pwd = $_POST['passwd1'];
//连接数据库
require_once "phpClass/Dbcon.php";
$con = new Dbcon();
$sql = "update users set passwd = '".$pwd."' where id = '".$_SESSION['id']."'";
$con->setSql($sql);
$res = $con->getRes();

if ($res == 1){
    echo 0;
    return;
}
else{
    echo 1;
    return;
}
