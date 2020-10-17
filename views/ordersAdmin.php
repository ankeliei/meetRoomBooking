<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>预约管理</title>
    <script src="/layui/layui.js"></script>
</head>
<body>
<?php include("headBar.php"); ?>
<?php session_start();if($_SESSION['isAdmin']!=1){echo "<h1>您权限不足或未登录！</h1>";exit();} ?>
<div class="layui-fluid">
    <div class="layui-row">
        <div class="layui-col-sm12 layui-col-md6">
            这里是左侧表格页面
            <form class="layui-form" lay-filter="chooseRoom">
                <div class="layui-inline" style="width: 45%">
                    <select id="roomid" name="roomid" lay-filter="roomid">
                        <option value="">请选择会议室</option>
                    </select>
                </div>
                <div class="layui-inline" style="width: 45%">
                    <select id="date" name="date" lay-filter="date">
                    </select>
                </div>
            </form>
            <div id="mainTable">
                这里是会议室预约详情大表位置
            </div>
        </div>
        <div class="layui-col-sm12 layui-col-md6">
            <div class="something">
                <!--                    会议室详情展示-->
                <div id="info">
                    <fieldset class="layui-elem-field layui-field-title"><legend id="roomName">请选择一个订单</legend></fieldset>
                    <div id="info-in" class="bornDisplayNone">
                        <div id="infoOptions">infoOptions</div>
                        <div id="infoText">infoText</div>
                    </div>
                </div>
                <!--                    竞争者展示-->
                <div id="whoRe" class="bornDisplayNone">
                    <fieldset class="layui-elem-field layui-field-title"><legend>同时段的其他预约：</legend></fieldset>
                    <ul id="whoReIn"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/ordersAdmin.js"></script>
</body>
</html>