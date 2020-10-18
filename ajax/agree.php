<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $arr = array();
    $n = 0;

    $data = json_decode($_POST['data']);

    foreach ($data as $value){
        $sql = 'update newOrders set status = '.$value[1].' where id = '.$value[0];
        $con->setSql($sql);
        $res = $con->getRes();
        if($res == 1){$n = $n+1;}
        else{array_push($arr,$sql);}
    }
    if($n == count($data)){$arr = array('message'=>0);}
    echo json_encode($arr);
?>