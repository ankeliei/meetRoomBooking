<?php
    session_start();
    $arr = array();

    $arr['id'] = $_SESSION['id'];
    $arr['name'] = $_SESSION['name'];
    $arr['isAdmin'] = $_SESSION['isAdmin'];

    echo json_encode($arr);
