<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $room = $_POST["room"];
    $time = $_POST["time"];
    $timeEnd = $time+86400000;
    $sql = "select * from newOrders where ((" .
            $time . " <= startTime and " .
            $timeEnd . " >= startTime ) or ( " .
            $time . " <= endTime and " .
            $timeEnd . " >= endTime )) and room = " . $room;
    $con->setSql($sql);
    $res = $con->getRes();

    $arr = array('len'=>$res->num_rows,orders=>array());
    if ($res->num_rows>0){
        while( $row = $res->fetch_assoc() ){
            array_push($arr['orders'],array(  'user'=>$row['user'],
                                                    'startTime'=>$row['startTime'],
                                                    'endTime'=>$row['endTime'],
                                                    'status'=>$row['status'],
                                                    'revokeTime'=>$row['revokeTime'],
                                                    'txt'=>$row['txt']));
        }
        echo json_encode($arr);
    }
    else{
        array_push($arr['orders'],"查询会议室预约详情失败或连接失败<br>", $sql);
        echo json_encode($arr);
    }
?>