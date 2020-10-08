<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hello World!</title>
    <link rel="stylesheet" href="layui/css/layui.css" media="all">
</head>

<body>

    <?php
        echo "Hello World! 你好！";
    ?>

    <button type="button" class="layui-btn" id = "test1">
        <i class="layui-icon">&#xe67c;</i>上传图片
    </button>

    <a href="views/main.php">主页</a>

    <?php
        $servername = "localhost";
        $username = "reserveSystem";
        $password = "2533";
        $dbname = "reserveSystem";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        echo "<br>连接成功<br>";
        $sql = "SELECT DISTINCT name FROM `usableRooms` ";
        $res = $conn->query($sql);

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
//                echo "a:" . $row["a"] . "b:" . $row["b"] . "c:" . $row["c"] . "d:" . $row["d"] . "<br>";
//                echo "b:" . $row["b"] . "<br>";
                echo "name: " . $row["name"] . "<br>";
            }
        } else {
            echo "0结果";
        }
        $conn->close();
    ?>

<div class="layui-row">
    <div class="layui-col-md9">

    </div>
    <div class="layui-col-md3">
        你的内容 3/12
    </div>
</div>

</body>
</html>