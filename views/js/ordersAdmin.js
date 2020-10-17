var roomid;
var date = 0;
var roomDateOrdersObj = {};
var roomList = {};

layui.use(['form'],function(){
    var form = layui.form;
    var $ = layui.$;

    $("#admin").className += " layui-this";
    dateItem();
    ajaxRoomList();

    //时间选择器的变动响应
    form.on('select(date)',function (data){
        console.log("时间选择器变动");
        date = data.value;
        ajaxRoomOrders();
    })
    //会议室选择器的变动响应
    form.on('select(roomid)',function (data){
        console.log("会议室选择器变动");
        roomid = data.value;
        ajaxRoomOrders();
    })
    //初始化时间下拉选择框
    function dateItem(){
        for(i=0; i<14; i++){
            var viewDay = new Date();
            viewDay.setTime(viewDay.valueOf()+86400000*i);
            $('#date').append("<option value='"+i+"'>"+viewDay.toLocaleDateString()+"</option>")
        }
    }
    //加载会议室列表目录
    function ajaxRoomList(){
        console.log("加载了会议室列表");
        $.post("/ajax/roomLists.php",
            {},
            function (data, status){
                roomList = JSON.parse(data);
                $('#roomid').empty();
                if(roomList['len']==0){
                    $('#roomid').append('<option value="">无会议室</option>');
                }
                else {
                    $('#roomid').append('<option value="">请选择会议室</option>');
                    for(i in roomList['data']){
                        $('#roomid').append('<option value="'+roomList['data'][i]['id']+'">'+roomList['data'][i]['name']+'</option>');
                    }
                }
                form.render();
            })
    }
    //加载此会议室的某日待处理的预约单
    function ajaxRoomOrders(){
        console.log("更新了主数据区");
        $.post("/ajax/roomDateOrders.php",
            {
                roomid:roomid,
                date:date,
            },
            function (data, status){
                roomDateOrdersObj = JSON.parse(data);
                //TODO:处理显示
            })
    }
})