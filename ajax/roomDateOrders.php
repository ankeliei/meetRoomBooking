<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $room = $_POST["room"];         //房间号
    $time = $_POST["time"];         //查询日期（今天、明天或后天）
    $timeEnd = $time+86400000;

    $sql = "select * from newOrders where ((" .
        $time . " <= startTime and " .
        $timeEnd . " >= startTime ) or ( " .
        $time . " <= endTime and " .
        $timeEnd . " >= endTime )) and room = " . $room;

    $con->setSql($sql);
    $res = $con->getRes();

    $arr = array();
    $arr['len'] = $res->num_rows;
    if($arr['len']==0){$arr['sql']=$sql;}
    else {
        $arr['data'] = array();
        while( $row = $res->fetch_assoc() ){    //未撤销、未结束、未处理。
            if($row['endTime']>=time()*1000&&$row['status']==0&&$row['revokeTime']==0){
                array_push($arr['data'],array(
                    'id'=>$row['id'],
                    'user'=>$row['user'],
                    'startTime'=>$row['startTime'],
                    'endTime'=>$row['endTime'],
                    'status'=>$row['status'],
                    'revokeTime'=>$row['revokeTime'],
                    'txt'=>$row['txt']));
            }
        }
    }
?>