<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员界面</title>
    <script>
        window.onload=function(){
            document.getElementById("admin").className += " layui-this";
        }
    </script>
</head>
<body>
    <?php
    include("headBar.php")
    ?>
    这是管理员专属界面
</body>
</html>