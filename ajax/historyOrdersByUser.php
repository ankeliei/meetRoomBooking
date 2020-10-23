<?php
    function mydate($timestamp){
        return date("Y 年 m 月 d 日",$timestamp);
    }
    function mydatetime($timestamp){
        return date("Y 年 m 月 d 日 H 点 i 分",$timestamp);
    }
    function mytime($timestamp){
        return date("H 点 i 分",$timestamp);
    }


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
                'createTime'=>mydate(substr($row['createTime'],0,10)),
                'startTime'=>mydatetime(substr($row['startTime'],0,10)),
                'endTime'=>mytime(substr($row['endTime'],0,10)),
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