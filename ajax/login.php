<?php
session_start();
//获取post的数据
$account = $_POST['account'];
$pwd = $_POST['password'];
//连接数据库
require_once "phpClass/Dbcon.php";
$con = new Dbcon();
$sql = "select * from users where id = \"{$account}\" and passwd = \"{$pwd}\" and wasdeleted = 0";
//查找未删除的、用户名和口令匹配的用户

$con->setSql($sql);
$res = $con->getRes();

if($res->num_rows==0){
    echo 0;
}
else{
    $row = $res->fetch_assoc();
    $_SESSION['id'] = $account;
    $_SESSION['name'] = $row['name'];
    $_SESSION['isAdmin'] = $row['isAdmin'];
    echo 1;
}
