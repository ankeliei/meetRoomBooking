<?php
require_once "phpClass/Dbcon.php";
$con = new Dbcon();
$id = $_POST['id'];

$sql = "delete from newOrders where id = '".$id."'";

$con->setSql($sql);
$res = $con->getRes();

echo $res;
