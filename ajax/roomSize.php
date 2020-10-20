<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $roomType = $_POST["roomType"];
    if($roomType==""){$roomType="%";}
    $mediaType = $_POST["mediaType"];
    if($mediaType==""){$mediaType="%";}

    $sql = "select distinct roomSize from rooms where roomType like \""
            .$roomType
            ."\" and mediaType like \""
            .$mediaType."\" and wasdeleted = 0 and usable = 1";

    $con->setSql($sql);
    $res = $con->getRes();

    echo "<option value=\"\">请选择会议室大小</option>";

    if ($res->num_rows>0){
        while( $row = $res->fetch_assoc() ){
            echo "<option value=\"" . $row["roomSize"] ."\">" . $row["roomSize"] . "</option>";
        }
    }
    else{
        echo "查询roomSize或连接失败<br>";
        echo $sql;
    }
?>