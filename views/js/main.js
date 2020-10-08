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

    //加载鼠标悬浮提示框
    function showLayer(id){
        console.log("打开提示框");
    }
    //关闭提示框
    function closeLayer(){
        console.log("关闭提示框");
    }
    //初始化时间下拉选择框
    function dateItem(){
        var mydate = new Date();            //今天
        console.log("now:"+mydate);
        var nextday = new Date()            //明天
        nextday.setTime(nextday.valueOf()+86400000);
        var nnday = new Date();             //后天
        nnday.setTime(nnday.valueOf()+86400000+86400000);

        var html = "<option value='0'>"+mydate.toLocaleDateString()+"</option>"
                  +"<option value='1'>"+nextday.toLocaleDateString()+"</option>"
                  +"<option value='2'>"+nnday.toLocaleDateString()+"</option>";

        $('#date').html(html);
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
                    $('#mainTable').append("<hr class='layui-bg-orange'>"); //首行横线
                    for(i in mainTableObj.rooms){
                        viewRoom(mainTableObj.rooms[i].id, mainTableObj.rooms[i].name);
                    }
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
        console.log("加载会议室--"+id+"---"+name+"--的预约详情");
        $('#mainTable').append("<div id='room_"+ id + "'>" + name + "</div>");
        $('#room_'+id).append("<div id='room-btn-group_"+ id + "\' class= \'layui-btn-group\'></div>");
        // $.post("/ajax/roomSchedule.php",
        //     {
        //         room:id,
        //         time:new Date(new Date().toLocaleDateString()).getTime()+86400000*date,
        //     },
        //     function (data, status){
        //
        //         var Ewidth = $('#mainTable').width();
        //
        //         viewRoomObj = JSON.parse(data);
        //         if(viewRoomObj.len==0){
        //             console.log(name+"无预约安排");
        //         }
        //         else {
        //             for(i in viewRoomObj.orders){
        //
        //                 start = new Date(Number(viewRoomObj.orders[i].startTime));
        //                 end = new Date(Number(viewRoomObj.orders[i].endTime))
        //                 takeTime = (end-start).valueOf();
        //
        //                 useWidth = Ewidth*(takeTime/84/600000);
        //
        //                 startH = start.getHours()>9?
        //                     start.getHours():"0"+start.getHours();
        //                 startM = start.getMinutes()>9?
        //                     start.getMinutes():"0"+start.getMinutes();
        //                 endH = end.getHours()>9?
        //                     end.getHours():"0"+end.getHours();
        //                 endM = end.getMinutes()>9?
        //                     end.getMinutes():"0"+end.getMinutes();
        //
        //                 $('#room-btn-group_'+id).append(
        //                     "<button style='width: "+useWidth+"px' " +
        //                     "type='button' class='layui-btn layui-btn-primary'" +
        //                     "$(this).hover(showLayer("+id+"), closeLayer()) >" +
        //                     startH+":"+startM+
        //                     "-"+endH+":"+endM+
        //                     "</button>"
        //                 )
        //             }
        //         }
        //     //    TODO 这里可能需要更新视图；
        //     })
        $.post("/ajax/roomDate.php",
            {
                room:id,
                time:new Date(new Date().toLocaleDateString()).getTime()+86400000*date,
            },
                function (data, status){
                console.log(data);
                }
            )

        $('#mainTable').append("<hr class='layui-bg-orange'>");
        console.log(""+id+": "+name);
    }
});