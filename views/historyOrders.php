<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>历史预约记录</title>
    <meta name="renderer" content="webkit">
    <script src="/layui/layui.js"></script>
    <script>
        window.onload=function(){
            document.getElementById("info").className += " layui-this";
        }
    </script>
</head>
<body>
    <?php
    include("headBar.php")
    ?>
    <table id="main" lay-filter="mainTable" class="layui-table" lay-data="{url:'/ajax/historyOrdersByUser.php/'}">
        <thead>
            <tr>
                <th lay-data="{field:'id', width:80, sort: true,     fixed: true}">编号</th>
                <th lay-data="{field:'room', width:120}">会议室</th>
                <th lay-data="{field:'createTime', width:160, sort: true}">创建时间</th>
                <th lay-data="{field:'startTime', width:160, sort: true}">开始时间</th>
                <th lay-data="{field:'endTime', width:160, sort: true}">结束时间</th>
                <th lay-data="{field:'txt', width:240}">会议名称</th>
                <th lay-data="{field:'status', width:160}">审核状态</th>
                <th lay-data="{fixed: 'right', width:80, align:'center', toolbar: '#delbut'}">操作</th>
            </tr>
        </thead>
    </table>

    <script type="text/html" id="delbut">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">撤销</a>
    </script>

    <script src="js/userHistory.js"></script>
</body>
</html>