<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>会议室管理</title>
    <script src="/layui/layui.js"></script>
    <script>
        window.onload=function(){
            document.getElementById("admin").className += " layui-this";
        }
    </script>
</head>
<body>
<?php include("headBar.php"); ?>
<?php session_start();if($_SESSION['isAdmin']!=1){echo "<h1>您权限不足或未登录！</h1>";exit();} ?>
会议室管理
</body>
</html>
