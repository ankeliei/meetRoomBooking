<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>预约管理</title>
    <meta name="renderer" content="webkit">
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

    <div class="layui-row">
        <div id="rooms">
            <fieldset class="layui-elem-field layui-field-title"><legend id="roomName">会议室：</legend></fieldset>
            <div id="rooms-in">

            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md9 layui-col-sm12">
            <div>
                <fieldset class="layui-elem-field layui-field-title"><legend id="whichRoom">请选择一个会议室</legend></fieldset>
                <div id="whichRoom-in">

                </div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div id="makeSure" class="bornDisplayNone" style="text-align: center">
                <fieldset class="layui-elem-field layui-field-title"><legend>确认通过此预约吗？</legend></fieldset>
                <div id="areYouSure">
                    <div class="layui-card">
                        <div class="layui-card-header">请注意</div>
                        <div class="layui-card-body">
                            因多个预约所申请的时间冲突<br>
                            若同意您选中的预约单（黄色）则将自动拒绝与其冲突的其他预约（红色）
                        </div>
                    </div>
                </div>
                <button class="layui-btn" onclick="agree()">同意此预约</button>
                <button class="layui-btn" onclick="disagree()">拒绝此预约</button>
            </div>
        </div>
    </div>
<script src="js/newOrdersAdmin.js"></script>
</body>
</html>
