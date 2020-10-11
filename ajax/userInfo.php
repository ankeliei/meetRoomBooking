<?php
    require_once "phpClass/Dbcon.php";
    $con = new Dbcon();
    $id = (int)$_POST["id"];
    $sql = "select * from user where wasdeleted = 0 and id = " . $id;
    $con->setSql($sql);
    $res = $con->getRes();

    $arr = array();
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $arr['status'] = 0;
            $arr['id'] = $row['id'];
            $arr['name'] = $row['name'];
            $arr['email'] = $row['email'];
            $arr['position'] = $row['position'];
        }
    } else {
        $arr['status'] = 1;
        $arr['sql'] = $sql;
    }
    echo json_encode($arr);