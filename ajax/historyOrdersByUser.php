<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    session_start();
    $user = $_SESSION['id'];
    $sql = "select * from newOrders where user = '".$user."'";
    $con->setSql($sql);
    $res = $con->getRes();

    $arr = array();
    $arr['code'] = 0;
    $arr['msg'] = "";
    $arr['data'] = array();
    $arr['count'] = $res->num_rows;
    if($res->num_rows > 0){
        while ($row = $res->fetch_assoc()){
            array_push($arr['data'], array(
               'id'=>$row['id'],
                'room'=>$row['room'],
                'createTime'=>$row['createTime'],
                'startTime'=>$row['startTime'],
                'endTime'=>$row['endTime'],
                'txt'=>$row['txt'],
                'status'=>$row['status']
            ));
        }
    }
    else{
        $arr['sql'] = $sql;
    }
    echo json_encode($arr);
?>