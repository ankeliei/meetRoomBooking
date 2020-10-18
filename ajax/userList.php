<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $sql = "select * from users";
    $con->setSql($sql);
    $res = $con->getRes();

    $arr = array();
    $arr['len']=$res->num_rows;
    if($arr['len']==0){
        $arr['sql']=$sql;
    }
    else{
        $arr['data'] = array();
        while ($row = $res->fetch_assoc()) {
            array_push($arr['data'],array(
                'id' => $row['id'],
                'name' => $row['name'],
//                'email' => $row['email'],
                'position' => $row['position']
            ));
        }
    }
    echo json_encode($arr);
?>