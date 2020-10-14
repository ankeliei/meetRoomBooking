<?php
    session_start();
    $arr = array();

    if($_SESSION['name']==null){        //状态码1表示未登录
        $arr['status'] = 1;
        echo json_encode($arr);
    }
    else{
        require_once "phpClass/Dbcon.php";
        $con = new Dbcon();
        $userid = $_SESSION['id'];
        $startTime = $_POST['startTimeSelect'];
        $endTime = $_POST['endTimeSelect'];
        $orderTxt = $_POST['orderTxt'];
        $roomid = $_POST['room'];

        $sql = " INSERT INTO newOrders (id, user, room, createTime, startTime, endTime, txt, status, revokeTime) ".
            " VALUES (NULL, '" .$userid. "', '" .$roomid."', '', '" .$startTime. "', '" .$endTime. "', '" .$orderTxt. "', '', '')";

        $con->setSql($sql);
        $res = $con->getRes();

        if($res == TRUE){
            $arr['status'] = 0;        //状态码0表示插入成功!
            echo json_encode($arr);
        }
        else{
            $arr['status'] = 2;        //状态码2表示数据库操作错误
            $arr['sql'] = $sql;
            $arr['res'] = $res;
            echo json_encode($arr);
        }
    }
