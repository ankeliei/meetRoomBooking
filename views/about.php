<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>关于-会议室预约管理系统</title>
    <meta name="renderer" content="webkit">
    <script>
        window.onload=function(){
            document.getElementById("about").className += " layui-this";
        }
    </script>
</head>
<body>
    <?php
    include("headBar.php")
    ?>
    <div class="layui-row">
        <div class="layui-col-md7">
<!--            左侧说明页 9/12-->
            <div class="layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">每次都要登录好麻烦</h2>
                    <div class="layui-colla-content">
                        1. 只有 提交预约 查看个人预约历史 查看个人信息 删除预约 等功能要求您必须登录<br>
                        2. 您可以在欢迎页面点击右上角的 免登录查看预约 查看预约主页<br>
                        3. 想查看自己的预约有没有被审核通过可以在免登录查看的状态下点击自己所预约的时间段<br>
                        <br>
                        4. 显示您预约的时间段 已被占用 且占用详情中显示的 确实是您的预约则表示此订单已经被审批通过了<br>
                        5. 显示您的预约单在 同时段其他预约 中,表示您的预约还未被审核处理<br>
                        6. 若未被通过 也未出现在 同时段其他预约 中,则可能您的预约已经被拒绝,具体可以登录后查看您的预约历史<br>
                    </div>
                </div>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">登录与退出登录问题</h2>
                    <div class="layui-colla-content">
                        您的账户为您的学工号<br>
                        您的初始登录密码为123456<br>
                        登陆成功之后请及时修改初始密码<br>
                        <br>
                        需要退出登录请完全关闭您的浏览器即可(无关页面也要关闭,手机端请杀掉浏览器后台)<br>
                        也可以<a href="login.html">点此重新登录</a>,重新登录成功后会替换原来的用户
                    </div>
                </div>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">如何修改密码</h2>
                    <div class="layui-colla-content">
                        1. 您需要处于登录状态(页面最上边的导航栏上有您的名字)<br>
                        2. 点击 您的名字 -> 修改密码<br>
                        3. 重复两次填写您的新密码 -> 点击确认<br>
                        4. 请注意: 修改密码成功后会自动跳转到登陆界面要求您重新登陆.
                    </div>
                </div>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">如何预约</h2>
                    <div class="layui-colla-content">
                        1. 在 预约主界面 (登陆后自动跳转到此页面,或点击导航栏上的"会议室预约")<br>
                        2. 选择 您想预约的 日期 (默认是今天)<br>
                        3. 点击 页面上展示的众多会议室对应的"可选"按钮(按钮的长短代表空闲时间的长短)<br>
                        4. 填写 您要预约的时间段与会议名称(填写区域在右侧出现,小屏幕在下侧出现)<br>
                        5. 检查 填写区域所展示的 同时段其他预约,尽量避免时间段冲突,否则管理员只会同意其中一个<br>
                        6. 最后检查 您所选的 日期 及 会议室 是否正确<br>
                        7. 确认无误则点击提交
                    </div>
                </div>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">怎么查看自己的预约记录</h2>
                    <div class="layui-colla-content">
                        1. 在登录状态下点击导航栏上 您的名字<br>
                        2. 点击 历史预约记录<br>
                        3. 进入历史记录页面即可查看自己的预约记录(空则表示您还没有预约记录,有疑问请刷新页面)<br>
                    </div>
                </div>
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">预约错了怎么办</h2>
                    <div class="layui-colla-content">
                        1. 查看自己的预约记录(有疑问请查看上一条说明)<br>
                        2. 仔细核对后找到自己想撤销的预约记录<br>
                        3. 点击对应的 撤销按钮 后点击 确认(确认后不可撤销)<br>
                        注意!!! 撤销预约将从系统中完全抹除此预约的一切信息,包括管理员已经同意的也将失去为您分配的会议室时间段
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md5">
<!--            右侧时间轴 3/12-->
            <ul class="layui-timeline">
                <li class="layui-timeline-item">
                    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                    <div class="layui-timeline-content layui-text">
                        <h3 class="layui-timeline-title">2020年10月23日更新</h3>
                        <p>第四次更新</p>
                        <ul>
                            <li>新增: 说明页,解答一些常见问题</li>
                            <li>优化: 优化弱网络环境下的某些用户体验</li>
                            <li>优化: 预约页日期选择框改为中文显示</li>
                        </ul>
                    </div>
                </li>
                <li class="layui-timeline-item">
                    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                    <div class="layui-timeline-content layui-text">
                        <h3 class="layui-timeline-title">2020年10月23日更新</h3>
                        <p>第三次更新</p>
                        <ul>
                            <li>新增: 用户可修改密码</li>
                            <li>新增: 用户可查看自己的预约历史</li>
                            <li>新增: 用户可以撤销自己的某项预约</li>
                            <li>修复: 某些情况下预约页日程显示混乱</li>
                        </ul>
                    </div>
                </li>
                <li class="layui-timeline-item">
                    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                    <div class="layui-timeline-content layui-text">
                        <div class="layui-timeline-title">过去</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script>
        //注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
        layui.use('element', function(){
            var element = layui.element;

            //…
        });
    </script>
</body>
</html>