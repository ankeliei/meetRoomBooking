<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $sql = "select * from rooms where wasdeleted = 0";
    $con->setSql($sql);
    $res = $con->getRes();

    $arr = array();
    $arr['len'] = $res->num_rows;

    if($arr['len'] == 0){
        $arr['sql'] = $sql;
        echo json_encode($arr);
    }
    else{
        $arr['data'] = array();
        while($row = $res->fetch_assoc()){
            array_push($arr['data'],array(
                'id'=>$row[id],
                'name'=>$row['name'],
                'roomType'=>$row['roomType'],
                'roomSize'=>$row['roomSize'],
                'mediaType'=>$row['meidaType'],
                'usable'=>$row['usable'],
                'stat'=>$row['stat'],
            ));
        }
        echo json_encode($arr);
    }