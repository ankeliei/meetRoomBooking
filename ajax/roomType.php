<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $roomSize = $_POST["roomSize"];
    if($roomSize==""){$roomSize="%";}
    $mediaType = $_POST["mediaType"];
    if($mediaType==""){$mediaType="%";}

    $sql = "select distinct roomType from usableRooms where mediaType like \""
        .$mediaType
        ."\" and roomSize like \""
        .$roomSize."\"";

    $con->setSql($sql);
    $res = $con->getRes();

    echo "<option value=\"\">请选择会议室类型</option>";

    if ($res->num_rows>0){
        while( $row = $res->fetch_assoc() ){
            echo "<option value=\"" . $row["roomType"] ."\">" . $row["roomType"] . "</option>";
        }
    }
    else{
        echo "查询roomType或连接失败<br>";
        echo $sql;
    }
?>
