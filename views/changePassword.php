<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改密码</title>
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="/layui/css/layui.css">
    <link rel="stylesheet" href="css/style.css">
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
<div class="login-main">
<header class="layui-elip">修改密码</header>
<br>
<form class="layui-form">
    <div class="layui-input-block">
        <input type="password" name="passwd1" required lay-verify="required" placeholder="新密码" autocomplete="off"
               class="layui-input">
    </div>
    <br>
    <div class="layui-input-block">
        <input type="password" name="passwd2" required lay-verify="required" placeholder="重复密码" autocomplete="off"
               class="layui-input">
    </div>
    <br>
    <div class="layui-input-block login-btn">
        <button lay-submit lay-filter="makeChange" class="layui-btn layui-btn-fluid">确认修改</button>
    </div>
</form>
</div>

<script src="/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(['form','layer','jquery'], function () {

        // 操作对象
        var form = layui.form;
        var $ = layui.jquery;
        form.on('submit(makeChange)',function (data) {
            // console.log(data.field);
            console.log(data.field.passwd1);
            console.log(data.field.passwd2);
            if (data.field.passwd1 != data.field.passwd2){
                layui.layer.msg('确认密码需要需要与新设置的密码保持一致');
            }
            else{
                $.ajax({
                    url:'/ajax/passwdChange.php',
                    data:data.field,
                    dataType:'text',
                    type:'post',
                    success:function (data) {
                        if (data == '0'){
                            layer.msg("密码修改成功！即将重新登录",function (){
                                window.location.href="login.html";
                            });
                        }
                        else if (data == '2'){
                            layer.msg("处于登录状态才能修改密码！");
                        }
                        else{
                            layer.msg('出现了错误');
                        }
                    }
                })
            }
            return false;
        })
    });
</script>
</body>
</html>