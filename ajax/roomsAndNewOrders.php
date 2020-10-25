<?php       //加载每个会议室待处理的订单数量
require_once "phpClass/Dbcon.php";
$con = new Dbcon();
$conn = new Dbcon();
$timeNow = time()*1000;

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
    while($row = $res->fetch_assoc()) {
        $ssql = "select count(*) as nums from newOrders where room = ".$row['id'].
            " and endTime > ".$timeNow.
            " and status = 0".
            " and revokeTime = 0";
        $conn->setSql($ssql);
        $ress = $conn->getRes();
        $roow = $ress->fetch_assoc();

        array_push($arr['data'], array(
            'id' => $row['id'],
            'name' => $row['name'],
            'num' => $roow['nums'],
        ));
    }
    echo json_encode($arr);
}