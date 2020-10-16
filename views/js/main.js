var roomDateObj;
layui.use(['form','mobile'], function(){
    var form = layui.form;
    var $ = layui.$;

    var roomType = "";
    var roomSize = "";
    var mediaType = "";
    var date = 0;

    document.getElementById("main").className += " layui-this";
    dateItem();
    ajaxMainTable();
    ajaxRoomType();
    ajaxRoomSize();
    ajaxMediaType();
    //这里写上三个筛选项的变动响应
    form.on('select(roomType)',function (data){
        console.log(data.value);
        roomType = data.value;
        ajaxMainTable();
        chooseChange("roomType");
    })
    form.on('select(roomSize)',function (data){
        console.log(data.value);
        roomSize = data.value;
        ajaxMainTable();
        chooseChange("roomSize");
    })
    form.on('select(mediaType)',function (data){
        console.log(data.value);
        mediaType = data.value;
        ajaxMainTable();
        chooseChange("mediaType");
    })
    form.on('select(date)',function (data){
        console.log(data.value);
        date = data.value;
        ajaxMainTable();
    })

    //初始化时间下拉选择框
    function dateItem(){
        for(i=0; i<14; i++){
            var viewDay = new Date();
            viewDay.setTime(viewDay.valueOf()+86400000*i);
            $('#date').append("<option value='"+i+"'>"+viewDay.toLocaleDateString()+"</option>")
        }
    }
    //处理筛选下拉框的变动
    function chooseChange(a){
        console.log(a+"触发了其他下拉选择框的更新");
        if (a=="roomType"){
            if(roomSize==""){
                ajaxRoomSize();
            }
            if(mediaType==""){
                ajaxMediaType();
            }
        }
        if (a=="roomSize"){
            if(roomType==""){
                ajaxRoomType();
            }
            if(mediaType==""){
                ajaxMediaType();
            }
        }
        if (a=="mediaType"){
            if(roomType==""){
                ajaxRoomType();
            }
            if(roomSize==""){
                ajaxRoomSize();
            }
        }
    }
    //加载符合筛选条件的会议室
    function ajaxMainTable(){
        roomDateObj = {};
        console.log("更新了主数据区");
        $.post("/ajax/mainTable.php",
            {
                roomType:roomType,
                roomSize:roomSize,
                mediaType:mediaType,
                date:date,
            },
            function (data, status) {
                mainTableObj = JSON.parse(data);
                if(mainTableObj.len==0){
                    console.log("ajaxError:"+mainTableObj.rooms);
                }
                else {
                    $('#mainTable').empty();
                    for(i in mainTableObj.rooms){
                        viewRoom(mainTableObj.rooms[i].id, mainTableObj.rooms[i].name);
                    }
                    $('#mainTable').append("<hr class='layui-bg-orange'>"); //尾行横线
                }
            })
    }
    //筛选项的动态加载
    function ajaxRoomType(){
        console.log("更新了roomType下拉选择框");
        $.post("/ajax/roomType.php",
            {
                roomSize:roomSize,
                mediaType:mediaType,
            },
            function (data, status) {
                $("#roomType").html(data);
                form.render("select","chooseRoom");
                // form.render();
            })
    }
    function ajaxRoomSize(){
        console.log("更新了roomSize下拉选择框");
        $.post("/ajax/roomSize.php",
            {
                roomType:roomType,
                mediaType:mediaType,
            },
            function (data, status) {
                $("#roomSize").html(data);
                form.render("select","chooseRoom");
            })
    }
    function ajaxMediaType(){
        console.log("更新了mediaType下拉选择框");
        $.post("/ajax/mediaType.php",
            {
                roomType:roomType,
                roomSize:roomSize,
            },
            function (data, status) {
                $("#mediaType").html(data);
                form.render("select","chooseRoom");
            })
    }
    //绘制某个会议室
    function viewRoom(id,name){
        console.log("used viewRoom()");
        $('#mainTable').append("<hr class='layui-bg-orange'>");
        console.log("加载会议室--"+id+"---"+name+"--的预约详情");
        $('#mainTable').append("<div id='room_"+ id + "'></div>");
        $('#room_'+id).append("<div class='room_name'>"+name+"</div>");
        $('#room_'+id).append("<div class='layui-btn-group my-btn-group'></div>");

        $.post("/ajax/roomDate.php",
            {
                room:id,
                time:new Date(new Date().toLocaleDateString()).getTime()+86400000*date,
            },
                function (data, status)
            {
                console.log(data);

                roomDateObj[id] = JSON.parse(data);

                for(i in roomDateObj[id]){

                start = new Date(Number(roomDateObj[id][i].startTime));
                end = new Date(Number(roomDateObj[id][i].endTime))
                takeTime = (end-start).valueOf();

                useWidth = takeTime/84/6000;    //此段时长所占百分比

                if(roomDateObj[id][i].style == "free"){
                    $('#room_' +id+ ' .layui-btn-group').append(
                        "<button onclick='roomDateOnclick(roomDateObj["+id+"]["+ i +"],"+id+",\""+name+"\")' " +
                        "style='width:"+ useWidth +"%' type=\"button\" class=\"layui-btn\">可选</button>"
                    );
                }
                if(roomDateObj[id][i].style == "used"){
                    $('#room_' +id+ ' .layui-btn-group').append(
                        "<button onclick='roomDateOnclick(roomDateObj["+id+"]["+ i +"],"+id+",\""+name+"\")' " +
                        "style='width:"+ useWidth +"%' type=\"button\" class=\"layui-btn layui-btn-primary\">已占</button>"
                    );
                }
                //TODO: 在这里绘制后台返回的某会议室的日程安排
            }
        })
        console.log(""+id+": "+name);
    }
});

function roomDateOnclick(obj,id,name){
    layui.use('form',function () {
        var $ = layui.$;
        var form = layui.form;
        console.log(obj);

        
        $('#info-in').css('display','none');
        $('#whoUse').css('display','none');
        $('#makeOrder').css('display','none');
        $('#whoRe').css('display','none');

        var roomInfo = {};
        $.post("/ajax/roomInfo.php",
            {
                id : id,
            },function (data, status){
                roomInfo = JSON.parse(data);
                $('#infoOptions').html(
                    "会议室类型："+roomInfo['roomType']+"<br>"+
                    "最大容纳量："+roomInfo['roomSize']+"<br>"+
                    "多媒体设备："+roomInfo['mediaType']);
                $('#infoText').html("用途说明："+roomInfo['stat']);
            })

        $('#info-in').css('display','block');           //设置会议室信息div显示
        var timeStringTitle = " | "+
            new Date(Number(obj['startTime'])).toTimeString().slice(0,5)+"-"+
            new Date(Number(obj['endTime'])).toTimeString().slice(0,5);
        $('#roomName').html(name+timeStringTitle);      //设置会议室名与时间段显示显示

        //空闲区的点击事件处理
        if(obj['style']=="free"){
            //对下单表单显示
            $('#makeOrder').css('display','block');
            //TODO：填充开始时间
            setStartTimeOptions(obj['startTime'],obj['endTime']);
            setEndTimeOptions(obj['startTime'],obj['endTime']);
            //TODO：填充结束时间
            //TODO：检查txt是否合法

            //竞争者区块的展示
            $('#whoReIn').empty();
            $('#whoRe').css('display','block');

            if(obj['orders'].length==0){
                $('#whoReIn').append("此时间段内还没有其他预约...");
            }
            else {
                $.ajaxSettings.async = false;                   //关闭ajax的异步加载
                for(var i = 0; i<obj['orders'].length; i++){
                    $.post("/ajax/userInfo.php",
                        {
                            id : obj['orders'][i]['user'],
                        },function (data, status){
                            var userInfo = JSON.parse(data);
                            $('#whoReIn').append(
                                "<li>"+
                                new Date(Number(obj['orders'][i]['startTime'])).toTimeString().slice(0,5)+"-"+
                                new Date(Number(obj['orders'][i]['endTime'])).toTimeString().slice(0,5)+" "+
                                userInfo['name']+" 的预约："+obj['orders'][i]['txt']+"</li>");
                        })
                }
                $.ajaxSettings.async = true;
            }
        }

        //占用区的点击事件处理
        if(obj['style']=="used"){
            //对预约详情部分显示
            $('#whoUse').css('display','block');
            $.post("/ajax/userInfo.php",
                {
                    id : obj['orders']['user'],
                },function (data, status){
                    var userInfo = JSON.parse(data);
                    $('#orderUser').html(userInfo['name']);
                })
            $('#orderTxt').html(obj['orders']['txt']);
        }

        //预约提交响应
        form.on('submit(orderTime)',function (data){
            console.log("点击了提交按钮");
            data['field']['room'] = id;
            console.log(data);
            $.ajax({
                url:'/ajax/makeOrder.php',
                data:data.field,
                dataType:'text',
                type:'post',
                success:function (data){

                    resObj = JSON.parse(data);
                    if(resObj['status'] == 1){
                        window.location.replace("login.html");
                    }
                    if(resObj['status'] == 0){
                        layer.open({
                            type: 1,
                            content: "预约提交成功！等待管理员审核!"
                        })
                        roomDateOnclick(obj,id,name);   //重新刷新右侧选择区
                    }
                }
            })
            return false;
        });

        //设置开始时间下拉框
        function setStartTimeOptions(startTimeArg,endTimeArg){

            let startTime = Number(startTimeArg);
            let endTime = Number(endTimeArg)-600000;

            $('#startTimeSelect').empty();
            $('#startTimeSelect').append("<option value=\"\">请选择开始时间</option>");

            for(startTime; startTime <= endTime; startTime = startTime+600000){

                var timePointObj = new Date(startTime);
                var timeString = timePointObj.toTimeString().slice(0,5)

                $('#startTimeSelect').append(
                    "<option value='"+ startTime +"'>"+ timeString +"</option>"
                );
            }
            form.render("select","orderTime");
        }
        //设置结束时间下拉框
        function setEndTimeOptions(startTimeArg,endTimeArg){

            let startTime = Number(startTimeArg)+600000;
            let endTime = Number(endTimeArg);

            $('#endTimeSelect').empty();
            $('#endTimeSelect').append("<option value=\"\">请选择结束时间</option>");

            for(startTime; startTime <= endTime; startTime = startTime+600000){

                var timePointObj = new Date(startTime);
                var timeString = timePointObj.toTimeString().slice(0,5)

                $('#endTimeSelect').append(
                    "<option value='"+ startTime +"'>"+ timeString +"</option>"
                );
            }
            form.render("select","orderTime");
        }
    })
}