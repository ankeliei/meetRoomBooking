<?php
    $roomList = array();
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();

    $sql = "select id, name from rooms";
    $con->setSql($sql);
    $res = $con->getRes();
    while ($row = $res->fetch_assoc()){
        array_push($roomList,array(
            'id' => $row['id'],
            'name'=> $row['name']
        ));
    }

    function mydate($timestamp){
        return date("Y 年 m 月 d 日",$timestamp);
    }
    function mydatetime($timestamp){
        return date("Y 年 m 月 d 日 H 点 i 分",$timestamp);
    }
    function mytime($timestamp){
        return date("H 点 i 分",$timestamp);
    }
    function changeStatus($status){
        if($status == 0){
            return "待审核";
        }else if($status == 1){
            return "已通过";
        }else if($status == 2){
            return "被拒绝";
        }
    }
    function changeRoom($room){
        global $roomList;
        foreach ($roomList as $value){
            if($value['id']==$room){
                return $value['name'];
            }
        }
    }

    session_start();
    $user = $_SESSION['id'];
    $sql = "select * from newOrders where user = '".$user."' order by id DESC";
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
                'room'=>changeRoom($row['room']),
                'createTime'=>mydate(substr($row['createTime'],0,10)),
                'startTime'=>mydatetime(substr($row['startTime'],0,10)),
                'endTime'=>mytime(substr($row['endTime'],0,10)),
                'txt'=>$row['txt'],
                'status'=>changeStatus($row['status'])
            ));
        }
    }
    else{
        $arr['sql'] = $sql;
    }
    echo json_encode($arr);
?>