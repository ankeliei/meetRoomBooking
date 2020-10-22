<?php       #构建某日某会议室的可选、已选状态
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
    //TODO:SQL语句可以优化
    $con->setSql($sql);
    $res = $con->getRes();

    $arr = array();
    $arrs = array('mark'=>array());
    if($res->num_rows>0){
        while( $row = $res->fetch_assoc() ){
            array_push($arr,array(
                'id'=>$row['id'],
                'user'=>$row['user'],
                'startTime'=>$row['startTime'],
                'endTime'=>$row['endTime'],
                'status'=>$row['status'],
                'revokeTime'=>$row['revokeTime'],
                'txt'=>$row['txt']));
        }
        $markTime = $time+28800000;
        $waitList = array();
        foreach ($arr as $value){
            if($value['status']==0){   //还未取得管理员同意的预约单
                array_push($waitList,$value);
                array_push($arrs['mark'],"一次未确认单：".$value['id']);
            }
            if($value['status']==1){   //订单已经得到管理员同意
                array_push($arrs['mark'],"一次已确认单：".$value['id']);
                if($value['startTime']!=$markTime){    //此确认订单没有紧接着上一次
                    array_push($arrs,array(     //构建此订单前的一个空白区
                        'style'=>'free',
                        'startTime'=>$markTime,
                        'endTime'=>$value['startTime'],
                        'orders'=>$waitList
                    ));
                }
                array_push($arrs,array(         //构建此订单
                    'style'=>'used',
                    'startTime'=>$value['startTime'],
                    'endTime'=>$value['endTime'],
                    'orders'=>$value
                ));
                $markTime = $value['endTime'];         //初始化空白区的标记
                $waitList = array();
            }
        }
        if($time+79200000!=$markTime){                  //构建最后一个空白区
            array_push($arrs,array(
                'style'=>'free',
                'startTime'=>$markTime,
                'endTime'=>$time+79200000,              //$time+79200000即晚上10点
                'orders'=>$waitList
            ));
        }
    }
    if(count($arr)==0){                //当天此房间没有预约单的情况
        array_push($arrs,array(
            'style'=>'free',
            'startTime'=>$time+28800000,
            'endTime'=>$time+79200000,
            'orders'=>array()
        ));
    }
    echo json_encode($arrs);