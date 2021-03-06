<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>预约主界面</title>
    <meta name="renderer" content="webkit">
    <script src="/layui/layui.js"></script>
</head>
<body>
    <?php
    include("headBar.php")
    ?>
    <?php
        $flag=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/Trident/',$flag)){
            echo "错误!<br>请使用 谷歌浏览器 或 360浏览器等 已经适配的浏览器访问!";
            echo $flag;
            exit();
        }

    ?>
    <div class="layui-fluid">
        <div class="layui-row"><br>
            <div class="layui-col-sm12 layui-col-md8">
                <form class="layui-form" lay-filter="chooseRoom">
                    <div class="layui-inline" style="width: 23%">
                        <select id="roomType" name="roomType" lay-filter="roomType">
                            <option value="">请选择会议室类型</option>
                        </select>
                    </div>
                    <div class="layui-inline" style="width: 23%">
                        <select id="roomSize" name="roomSize" lay-filter="roomSize">
                            <option value="">请选择会议室容纳量</option>
                        </select>
                    </div>
                    <div class="layui-inline" style="width: 23%">
                        <select id="mediaType" name="mediaType" lay-filter="mediaType">
                            <option value="">请选择媒体设备</option>
                        </select>
                    </div>
                    <div class="layui-inline" style="width: 23%">
                        <select id="date" name="date" lay-filter="date">
                        </select>
                    </div>
                </form>
                <div id="mainTable">
                    加载中,若长时间未响应,请刷新重试
                </div>
            </div>
            <div class="layui-col-sm12 layui-col-md4">
                <div class="something">
<!--                    会议室详情展示-->
                    <div id="info">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend id="roomName">请选择一个会议室</legend>
                        </fieldset>
                        <div id="info-in" class="bornDisplayNone">
<!--                            <div id="startAndEnd">startAndEnd</div>-->
                            <div id="infoOptions">信息加载中</div>
                            <div id="infoText">信息加载中</div>

                        </div>
                    </div>
<!--                    预约详情展示-->
                    <div id="whoUse" class="bornDisplayNone">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>占用详情：</legend>
                        </fieldset>
                        <div id="orderUser"></div>
                        <div id="orderTxt">信息加载中</div>
                    </div>
<!--                    下单表单-->
                    <div id="makeOrder" class="bornDisplayNone">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>选择预约时间：</legend>
                        </fieldset>
                        <div id="chooseStartTime">
                            <form class="layui-form" lay-filter="orderTime">

                                <div class="layui-form-itemm">
                                    <lable class="layui-form-label">开始时间</lable>
                                    <div class="layui-inline" style="width: 140px">
                                        <select id="startTimeSelect" name="startTimeSelect" lay-filter="startTimeSelect">
                                            <option value="">请选择开始时间</option>
                                        </select>
                                    </div>
                                </div><br>

                                <div class="layui-form-itemm">
                                    <lable class="layui-form-label">结束时间</lable>
                                    <div class="layui-inline" style="width: 140px">
                                        <select id="endTimeSelect" name="endTimeSelect" lay-filter="endTimeSelect">
                                            <option value="">请选择结束时间</option>
                                        </select>
                                    </div>
                                </div><br>

                                <div class="layui-form-item layui-form-text">
                                    <label class="layui-form-label">会议名称</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="orderTxt" required lay-verify="required" placeholder="请输入会议名称" autocomplete="off" class="layui-input">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label"></label>
                                    <div class="layui-input-block">
                                        <button class="layui-btn" lay-submit lay-filter="orderTime">立即提交</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
<!--                    竞争者展示-->
                    <div id="whoRe" class="bornDisplayNone">
                        <fieldset class="layui-elem-field layui-field-title">
                            <legend>同时段的其他预约：</legend>
                        </fieldset>
                        <ul id="whoReIn">

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="js/main.js"></script>
</body>
</html>