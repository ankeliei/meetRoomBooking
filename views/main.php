<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>预约主界面</title>
    <script src="/layui/layui.js"></script>
</head>
<body>
    <?php
    include("headBar.php")
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
                <div class="something">
                    <div id="info">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>请选择一个会议室</legend>
                        </fieldset>
                        <div id="info-in" class="bornDisplayNone">
                            <div id="freeOrUsed">freeOrUsed</div>
                            <div id="startAndEnd">startAndEnd</div>
                            <div id="infoOptions">infoOptions</div>
                            <div id="infoText">infoText</div>
                        </div>
                    </div>
                    <div id="whoUse" class="bornDisplayNone">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>使用人：</legend>
                        </fieldset>
                        <div id="orderInfo">orderInfo</div>
                    </div>
                    <div id="makeOrder" class="bornDisplayNone">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>选择预约时间：</legend>
                        </fieldset>
                        <div id="chooseStartTime">chooseStartTime</div>
                        <div id="chooseEndtTime">chooseEndtTime</div>
                        <div id="choosed">choosed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/main.js"></script>
</body>
</html>