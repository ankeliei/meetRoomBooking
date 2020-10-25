<?php       //加载某个具体会议室待处理的订单
require_once "phpClass/Dbcon.php";
$con = new Dbcon();
$room = $_POST['room'];
$timeNow = time()*1000;

//以下一大段用来处理字符串变换
$userList = array();
$sql = "select id, name from users";
$con->setSql($sql);
$res = $con->getRes();
while ($row = $res->fetch_assoc()){
    array_push($userList,array(
        'id' => $row['id'],
        'name'=> $row['name']
    ));
}

function mydate($timestamp){
    return date("m/d",$timestamp);
}
function mydatetime($timestamp){
    return date("m/d H:i",$timestamp);
}
function mytime($timestamp){
    return date("H:i",$timestamp);
}
function changeUser($user){
    global $userList;
    foreach ($userList as $value){
        if($value['id']==$user){
            return $value['name'];
        }
    }
}

$sql = "select * from newOrders where room = ".$room.
        " and endTime > ".$timeNow.
        " and status = 0".
        " and revokeTime = 0";
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
        array_push($arr['data'], array(
            'id'=>$row['id'],
            'user'=>changeUser($row['user']),
            'cTime'=>mydate(substr($row['createTime'],0,10)),
            'sTime'=>mydatetime(substr($row['startTime'],0,10)),
            'eTime'=>mytime(substr($row['endTime'],0,10)),
            'txt'=>$row['txt'],
            'createTime'=>$row['createTime'],
            'startTime'=>$row['startTime'],
            'endTime'=>$row['endTime']
        ));
    }
    echo json_encode($arr);
}