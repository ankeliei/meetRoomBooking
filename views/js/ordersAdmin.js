var roomid;                 //会议室id
var roomName;               //会议室名
var date = 0;               //选中的日期
var numInOrders = 0;        //选中的订单在roomDateOrdersObj中的位置
var roomDateOrdersObj = {};     //此会议室此日期的待处理订单列表
var otherOrders = new Array();  //与选中的订单相冲突的订单
var roomList = {};              //会议室列表
var userList = {};              //用户列表

//加载此会议室的某日待处理的预约单
function ajaxRoomOrders(){
    layui.$.post("/ajax/roomDateOrders.php",
        {
            room:roomid,
            time:new Date(new Date().toLocaleDateString()).getTime()+86400000*date,
            timeNow:new Date().valueOf(),
        },
        function (data, status){
            roomDateOrdersObj = JSON.parse(data);
            layui.$('#roomName').html(roomName+"的待审批预约");
            if(roomDateOrdersObj['len']==0||roomDateOrdersObj['data'].length==0){
                layui.$('#info-in').empty();
                layui.$('#info-in').append('<li>无待处理的预约申请！</li>');
            }
            else{
                layui.$('#info-in').empty();
                for(i in roomDateOrdersObj['data']){
                    var roomOrderId = roomDateOrdersObj['data'][Number(i)]['id'];
                    var roomOrderuser = roomDateOrdersObj['data'][Number(i)]['user'];
                    var roomOrdertxt = roomDateOrdersObj['data'][Number(i)]['txt'];
                    roomOrderStartTime =new Date(Number(roomDateOrdersObj['data'][Number(i)]['startTime'])).toTimeString().slice(0,5);
                    roomOrderEndTime =new Date(Number(roomDateOrdersObj['data'][Number(i)]['endTime'])).toTimeString().slice(0,5);
                    layui.$('#info-in').append('<button class="layui-btn layui-btn-fluid"' +
                        'onclick="orderOnclock('+ roomOrderId +')"' +
                        'id="order_'+ roomOrderId +'">' +
                        '<p style="text-align: left">' +
                        roomOrderStartTime+'-'+roomOrderEndTime+
                        ' 用户：'+roomOrderuser+
                        ' 备注：'+roomOrdertxt+
                        '</p>'+
                        '</button>'+'<hr>')
                }
            }
        })
    console.log("更新了主数据区");
}

layui.use(['form'],function(){
    var form = layui.form;
    var $ = layui.$;

    $('#admin').addClass('layui-this');
    dateItem();
    ajaxRoomList();
    ajaxUserList();

    //时间选择器的变动响应
    form.on('select(date)',function (data){
        console.log("时间选择器变动");
        date = data.value;
        ajaxRoomOrders();
        $('#makeSure').hide();
    })
    //会议室选择器的变动响应
    form.on('select(roomid)',function (data){
        console.log("会议室选择器变动");
        roomid = data.value;
        $('#makeSure').hide();
        ajaxRoomOrders();
        for(i in roomList['data']){
            if (roomList['data'][Number(i)]['id']==roomid){
                roomName = roomList['data'][Number(i)]['name'];
                break;
            }
        }
    })
    //初始化时间下拉选择框
    function dateItem(){
        date = 0;
        for(i=0; i<14; i++){
            var viewDay = new Date();
            viewDay.setTime(viewDay.valueOf()+86400000*i);
            $('#date').append("<option value='"+i+"'>"+viewDay.toLocaleDateString()+"</option>")
        }
    }
    //加载用户列表
    function ajaxUserList(){
        console.log("加载了用户列表");
        $.post("/ajax/userList.php",
            {},
            function (data, status){
                userList = JSON.parse(data);
            })
    }
    //加载会议室列表目录
    function ajaxRoomList(){
        roomid = 0;
        roomName = "";
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
})

function orderOnclock(id){
    layui.use([],function (){
        var selectStartTime = 0;
        var selectEndTime = 0;
        otherOrders = []

        var $ = layui.$;

        $('#info-in').children("button").attr("class","layui-btn layui-btn-fluid"); //清除所有的按钮上色

        for(i in roomDateOrdersObj['data']){
            if(roomDateOrdersObj['data'][i]['id'] == id){
                numInOrders = i;
                selectStartTime = roomDateOrdersObj['data'][i]['startTime'];
                selectEndTime = roomDateOrdersObj['data'][i]['endTime'];
            }
        }
        for(i in roomDateOrdersObj['data']){
            if((roomDateOrdersObj['data'][i]['startTime'] <= selectStartTime && roomDateOrdersObj['data'][i]['endTime'] > selectStartTime)
            ||(roomDateOrdersObj['data'][i]['startTime'] < selectEndTime && roomDateOrdersObj['data'][i]['endTime'] >= selectEndTime)
            ||(roomDateOrdersObj['data'][i]['startTime'] >= selectStartTime && roomDateOrdersObj['data'][i]['endTime'] <= selectEndTime)){
                $('#order_'+roomDateOrdersObj['data'][i]['id']).addClass('layui-btn-danger');
                otherOrders.push(i);
            }
        }
        $('#order_'+id).attr("class","layui-btn layui-btn-fluid layui-btn-warm");
        $('#makeSure').show();
        if(otherOrders.length==1){
            console.log("无冲突");
            $('#areYouSure').hide();
        }
        else{
            $('#areYouSure').show();
        }
    })
}

//用户点击同意
function agree(){
    var arr =new Array();
    var arrTemp = new Array();

    arrTemp.push(roomDateOrdersObj['data'][numInOrders]['id'],1);
    arr.push(arrTemp);

    for(i in otherOrders){
        if(roomDateOrdersObj['data'][otherOrders[i]]['id']!=roomDateOrdersObj['data'][numInOrders]['id']){
            arrTemp = [roomDateOrdersObj['data'][otherOrders[i]]['id'], 2];
            arr.push(arrTemp);
        }
    }
    arr = JSON.stringify(arr);
    console.log("agree!!!!!"+roomDateOrdersObj['data'][numInOrders]['txt']);
    layui.$.post("/ajax/agree.php",
        {
            data:arr,
        },function (data,status){
            var reInfo = JSON.parse(data);
            if(reInfo['message']==0){
                layer.msg("已同意此预约申请");
                layui.$('#makeSure').hide();
                ajaxRoomOrders();
            }
            else {
                console.log(reInfo['sql']);
                layer.msg("出了一些问题");
                layui.$('#makeSure').hide();
                ajaxRoomOrders();
            }
        })
}
//用户点击拒绝
function disagree(){
    console.log("disagree!!!!!");
    var arr =new Array();
    var arrTemp = new Array();

    arrTemp.push(roomDateOrdersObj['data'][numInOrders]['id'],2);
    arr.push(arrTemp);
    arr = JSON.stringify(arr);
    console.log(JSON.parse(arr));
    layui.$.post("/ajax/agree.php",
        {
            data:arr,
        },function (data,status){
            var reInfo = JSON.parse(data);
            if(reInfo['message']==0){
                layer.msg("已拒绝此预约申请");
                layui.$('#makeSure').hide();
                ajaxRoomOrders();
            }
            else {
                console.log(reInfo['sql']);
                layer.msg("出了一些问题");
                layui.$('#makeSure').hide();
                ajaxRoomOrders();
            }
        })
}
