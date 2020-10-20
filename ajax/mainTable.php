<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $roomSize = $_POST["roomSize"];
    if($roomSize==""){$roomSize="%";}
    $roomType = $_POST["roomType"];
    if($roomType==""){$roomType="%";}
    $mediaType = $_POST["mediaType"];
    if($mediaType==""){$mediaType="%";}
    $sql = "select id, name from rooms where roomType like \""
            .$roomType
            ."\" and roomSize like \""
            .$roomSize
            ."\" and mediaType like \""
            .$mediaType."\" and wasdeleted = 0 and usable = 1";
    $con->setSql($sql);
    $res = $con->getRes();

    $arr = array('len'=>$res->num_rows,rooms=>array());
    if ($res->num_rows>0){
        while( $row = $res->fetch_assoc() ){
            array_push($arr['rooms'],array('id'=>$row['id'],'name'=>$row['name']));
        }
        echo json_encode($arr);
    }
    else{
        array_push($arr['rooms'],"查询可用会议室失败或连接失败<br>", $sql);
        echo json_encode($arr);
    }
?>