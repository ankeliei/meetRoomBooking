<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $arr = array();
    $n = 0;

    $data = json_decode($_POST['data']);
    $oldTime = $_POST['when'];
    $room = $_POST['room'];

    $ssql = "select * from newOrders where createTime > ".$oldTime." and room = ".$room;
    $con->setSql($ssql);
    $res = $con->getRes();

    if($res->num_rows>0){
        $arr = array('message'=>2);         //信号2代表更新时间过时，需要刷新页面
        echo json_encode($arr);
        exit();
    }

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