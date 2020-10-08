<?php
require_once "phpClass/Dbcon.php";
$con = new Dbcon();
$roomSize = $_POST["roomSize"];
if($roomSize==""){$roomSize="%";}
$roomType = $_POST["roomType"];
if($roomType==""){$roomType="%";}
$sql = "select distinct mediaType from usableRooms where roomType like \""
        .$roomType
        ."\" and roomSize like \""
        .$roomSize."\"";


$con->setSql($sql);
$res = $con->getRes();

echo "<option value=\"\">请选择媒体设备</option>";

if ($res->num_rows>0){
    while( $row = $res->fetch_assoc() ){
        echo "<option value=\"" . $row["mediaType"] ."\">" . $row["mediaType"] . "</option>";
    }
}
else{
    echo "查询mediaType或连接失败<br>";
    echo $sql;
}
?>
