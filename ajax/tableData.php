<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();

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
        while($row = $res->fetch_assoc() ){
            array_push($rooms,array('id'=>$row['id'],'name'=>$row['name']));
        }
        $sql = "select ";
    }
?>
