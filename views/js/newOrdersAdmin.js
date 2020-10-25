var roomAndOrders = {};
var orderList = {};
var choosedRoom = 0;
var choosedOrder = 0;
var choosedRoomName = "";
var otherOrders = new Array();  //与选中的订单相冲突的订单
var now = new Date().valueOf(); //记录更新的时间，用于检查某些不同步的情况

ajaxRoomsAndNewOrders();


function ajaxRoomsAndNewOrders(){
    layui.use(['jquery'],function (){
        var $ = layui.jquery;

        $('#rooms-in').empty()
        $.post('/ajax/roomsAndNewOrders.php',{},function (data,status){
            roomAndOrders = JSON.parse(data);
            console.log(roomAndOrders);
            for(i in roomAndOrders['data']){
                if(roomAndOrders['data'][i]['num']!=0){
                    $('#rooms-in').append("<button " +
                        "id = 'room_"+roomAndOrders['data'][i]['id']+"' "+
                        "class='layui-btn' " +
                        "onclick='showOrders("+
                        roomAndOrders['data'][i]['id']+", \""+
                        roomAndOrders['data'][i]['name']+"\")'>" +
                        roomAndOrders['data'][i]['name']+
                        "<span class=\"layui-badge\">"+
                        roomAndOrders['data'][i]['num']+
                        "</span></button>");
                }
                else {
                    $('#rooms-in').append("<button " +
                        "id = 'room_"+roomAndOrders['data'][i]['id']+"' "+
                        "class='layui-btn' " +
                        "onclick='showOrders("+roomAndOrders['data'][i]['id']+", \""+
                        roomAndOrders['data'][i]['name']+"\")'>" +
                        roomAndOrders['data'][i]['name']+
                        "</button>");
                }
            }
        });
    })
}


function showOrders(room, name){
    now = new Date().valueOf();
    choosedRoom = room;
    choosedRoomName = name;
    choosedOrder = 0;
    layui.use('jquery',function (){
        var $ = layui.jquery;
        $('#whichRoom').html(name+"  的待预约审批：");

        $('#whichRoom-in').empty();
        $('#makeSure').hide();
        $('#areYouSure').hide();
        $('#areYouSure').hide();


        $.post('/ajax/newOrdersByRoom.php',{room:choosedRoom},function (data,status){
            orderList = JSON.parse(data);
            if(orderList['len'] == 0){
                console.log("没有预约")
                $('#whichRoom-in').html("<p>此会议室暂时还没有待处理的预约!</p>");
            }
            else {
                for(i in orderList['data']){
                    console.log(orderList['data'][i]);
                    $('#whichRoom-in').append('<button class="layui-btn layui-btn-fluid"' +
                        'onclick="orderOnclick('+ orderList['data'][i]['id'] +')"' +
                        'id="order_'+ orderList['data'][i]['id'] +'">' +
                        '<p style="text-align: left">' +
                        ' 创建时间:'+orderList['data'][i]['cTime']+' '+
                        ' 开始:'+orderList['data'][i]['sTime']+
                        ' 结束:'+orderList['data'][i]['eTime']+
                        ' 用户:'+orderList['data'][i]['user']+
                        ' 会议名:'+orderList['data'][i]['txt']+
                        '</p>'+
                        '</button>'+'<hr>')
                }
            }
        })
    })
}

function orderOnclick(id){
    choosedOrder = id;
    layui.use([],function (){
        var selectStartTime = 0;
        var selectEndTime = 0;
        otherOrders = []

        var $ = layui.$;

        $('#whichRoom-in').children("button").attr("class","layui-btn layui-btn-fluid"); //清除所有的按钮上色

        for(i in orderList['data']){
            if(orderList['data'][i]['id'] == id){
                numInOrders = i;
                selectStartTime = orderList['data'][i]['startTime'];
                selectEndTime = orderList['data'][i]['endTime'];
            }
        }
        for(i in orderList['data']){
            if((orderList['data'][i]['startTime'] <= selectStartTime && orderList['data'][i]['endTime'] > selectStartTime)
                ||(orderList['data'][i]['startTime'] < selectEndTime && orderList['data'][i]['endTime'] >= selectEndTime)
                ||(orderList['data'][i]['startTime'] >= selectStartTime && orderList['data'][i]['endTime'] <= selectEndTime)){
                $('#order_'+orderList['data'][i]['id']).addClass('layui-btn-danger');
                otherOrders.push(i);
            }
        }
        $('#order_'+id).attr("class","layui-btn layui-btn-fluid layui-btn-warm");
        $('#makeSure').show();
        if(otherOrders.length===1){
            console.log("无冲突");
            $('#areYouSure').hide();
        }
        else{
            $('#areYouSure').show();
        }
    })
}
//用户点击拒绝
function disagree(){
    layui.use(['layer','jquery'],function (){
        var layer = layui.layer;
        var $ = layui.jquery;

        console.log("disagree!!!!!");
        var arr =new Array();
        var arrTemp = new Array();

        arrTemp.push(choosedOrder,2);
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
                    $('#makeSure').hide();
                    showOrders(choosedRoom);
                    ajaxRoomsAndNewOrders();
                }
                else {
                    console.log(reInfo['sql']);
                    layer.msg("出了一些问题");
                    $('#makeSure').hide();
                    showOrders(choosedRoom);
                    ajaxRoomsAndNewOrders();
                }
            })
    })
}
//用户点击同意
function agree(){
    layui.use(['layer','jquery'],function (){
        var layer = layui.layer;
        var $ = layui.jquery;

        var arr =new Array();
        var arrTemp = new Array();

        arrTemp.push(choosedOrder,1);
        arr.push(arrTemp);

        for(i in otherOrders){
            if(orderList['data'][otherOrders[i]]['id']!=choosedOrder){
                arrTemp = [orderList['data'][otherOrders[i]]['id'], 2];
                arr.push(arrTemp);
            }
        }
        arr = JSON.stringify(arr);
        console.log("agree!!!!!"+choosedOrder);
        layui.$.post("/ajax/agree.php",
            {
                data:arr,
                when:now,           //带上记录最后更新的时间
                room:choosedRoom,
            },function (data,status){
                var reInfo = JSON.parse(data);
                if(reInfo['message']==0){
                    layui.layer.msg("已同意此预约申请");
                    layui.$('#makeSure').hide();
                    ajaxRoomsAndNewOrders();
                    showOrders(choosedRoom);
                }
                else if(reInfo['message']==2){
                    layui.layer.msg("有新的申请可能冲突，请重新处理");
                    layui.$('#makeSure').hide();
                    ajaxRoomsAndNewOrders();
                    showOrders(choosedRoom);
                }
                else {
                    console.log(reInfo['sql']);
                    layui.layer.msg("出了一些问题");
                    layui.$('#makeSure').hide();
                    ajaxRoomsAndNewOrders();
                    showOrders(choosedRoom);
                }
            })
    })
}