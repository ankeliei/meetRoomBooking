<?php   #待处理订单页头部一览表的数据构建
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();

    $nowTime = time()*1000;
    $rooms = array();
    $arr = array();
    $sql = "select id,name from rooms where wasdeleted = 0";

    $con->setSql($sql);
    $res = $con->getRes();

    $arr['code'] = 0;
    if($res->num_rows == 0){
        $arr['msg'] = "无待处理或出错了";
        $arr['count'] = 0;
        $arr['data'] = array(array());
    }
    else{
        while($row = $res->fetch_assoc() ){     //拉取会议室列表
            array_push($rooms,array('id'=>$row['id'],'name'=>$row['name']));
        }
        $sql = "select * from newOrders where ";
    }
?>
