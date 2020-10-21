<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hello World!</title>
    <meta name="renderer" content="webkit">
    <script src="/layui/layui.js"></script>
    <link rel="stylesheet" href="layui/css/layui.css" media="all">
</head>
<body>
    <div class="layui-header">
        <ul class="layui-nav">
            <a href="https://ch.nwafu.edu.cn/index.htm" class="logo" style="width: 20%;text-align: right">
                <img style="width: 270px;padding-top: 10px" src="views/images/HSlogo.png" alt="人文社会发展学院">
            </a>
            <li class="layui-nav-item" style="width: 70%;text-align: right">
                <a href="/views/main.php">免登录查看预约</a>
            </li>
        </ul>
    </div>
    <div style="width: 1000px; margin: auto; margin-top: 120px; border: #2E2D3C 2px solid; border-radius:15px; box-shadow: 10px 5px 5px gray">
        <div style="display: inline-block; height: 100%">
            <img style="border-radius:15px; width: 100%" src="/views/images/fall-1072821_640%20.jpg" alt="">
        </div>
        <div style="display: inline-block; margin-left: 30px; text-align: center;">
            <div style="margin-top: 50px">
                <p style="text-align: center; font-size: 25px; font-family: "YouYuan",sans-serif;">
                    西北农林科技大学<br>人文社会发展学院<br>会议室预约管理系统
                </p>
            </div>
            <div style="padding-top: 40px">
                <?php
                    session_start();
                    if($_SESSION['name']==null) echo '<a class="layui-btn layui-btn-lg layui-btn-danger" href="views/login.html">点此登录</a>';
                    else echo '<a class="layui-btn layui-btn-lg layui-btn-danger" href="views/main.php">开始预约</a>';
                ?>
                <a class="layui-btn layui-btn-lg layui-btn-danger" href="views/about.php">查看说明</a>
            </div>
        </div>
    </div>
</body>
</html>