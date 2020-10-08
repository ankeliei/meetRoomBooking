<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>预约主界面</title>
    <script src="/layui/layui.js"></script>
</head>
<body>
    <?php
        include("headBar.html")
    ?>
    <div class="layui-container">
        <div class="layui-row">
            <div class="layui-col-md9">
                这里是左侧表格页面
                <form class="layui-form" lay-filter="chooseRoom">
<!--                    <label class="layui-form-label">在此筛选：</label>-->
                    <div class="layui-inline" style="width: 140px">
                        <select id="roomType" name="roomType" lay-filter="roomType">
                            <option value="">请选择会议室类型</option>
                            <!--TODO: 应该动态加载可选项-->
                        </select>
                    </div>
                    <div class="layui-inline" style="width: 140px">
                        <select id="roomSize" name="roomSize" lay-filter="roomSize">
                            <option value="">请选择会议室容纳量</option>
                            <!--TODO: 应该动态加载可选项-->
                        </select>
                    </div>
                    <div class="layui-inline" style="width: 140px">
                        <select id="mediaType" name="mediaType" lay-filter="mediaType">
                            <option value="">请选择媒体设备</option>
                            <!--TODO: 应该动态加载可选项-->
                        </select>
                    </div>
                    <div class="layui-inline" style="width: 140px">
                        <select id="date" name="date" lay-filter="date">

                            <!--TODO: 应该动态加载可选项-->
                        </select>
                    </div>
                </form>
                <div id="mainTable">
                    这里是会议室预约详情大表位置
                </div>
            </div>
            <div class="layui-col-md3">
                这里是右侧详情信息
            </div>
        </div>
    </div>
    <script src="js/main.js"></script>
</body>
</html>