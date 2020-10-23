<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>头部导航栏</title>
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="css/style.css">
    <script src="/layui/layui.js"></script>
</head>
<body>

        <ul class="layui-nav" lay-filter="">
<!--            <li class="layui-nav-item"><a href="/index.php"><i class="layui-icon" style="font-size: 30px; color: #009688;">&#xe68e;</i></a></li>-->
            <li class="layui-nav-item"><a href="/index.php"><i class="layui-icon" style="font-size: 30px; color: #009688;">&#xe68e;</i></a></li>
<!--            <li class="layui-nav-item">-->
<!--                <a href="javascript:;">-->
<!--                        <img style="width: 300px" src="images/HSlogo.png">-->
<!--                </a>-->
<!--            </li>-->
            <li id="main" class="layui-nav-item"><a href="/views/main.php">会议室预约</a></li>
            <li id="info" class="layui-nav-item">
                <a href="javascript:;">
                    <?
                        session_start();
                        if($_SESSION['name']==null) echo "未登录！";
                        else echo $_SESSION['name'];
                    ?>
                </a>
                <dl class="layui-nav-child">
                    <?
                    if($_SESSION['name']==null) {
                        echo '<dd><a href="/views/login.html">点击登录</a></dd>';
                    }
                    else echo '<dd><a href="/views/historyOrders.php">历史预约记录</a></dd>'.
//                        '<dd><a href="/views/runningOrders.php">进行中的预约</a></dd>'.
                        '<dd><a href="/views/me.php">我的信息</a></dd>'.
                        '<dd><a href="/views/changePassword.php">修改密码</a></dd>';
                    ?>
                </dl>
            </li>

            <li id="admin" class="layui-nav-item<?php if($_SESSION['isAdmin']!=1){echo ", bornDisplayNone";}?>">
                <a href="javascript:;">系统管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="ordersAdmin.php">预约管理</a></dd>
                    <dd><a href="usersAdmin.php">用户管理</a></dd>
                    <dd><a href="roomsAdmin.php">会议室管理</a></dd>
                </dl>
            </li>
<!--            <li style="display: inline-block; position: absolute; right: 0; text-align: left; width: 60%; margin-top: 3px">-->
<!--                <img style="height: 60px" src="images/HSlogo.png">-->
<!--            </li>-->

            <li id="about" class="layui-nav-item"><a href="/views/about.php">关于</a></li>
        </ul>
<script>
    layui.use('element',function(){
        var element = layui.element;
        element.init();
    })
</script>
</body>
</html>