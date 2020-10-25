layui.use(['jquery', 'table', 'layer'],function (){
    var table = layui.table;
    var $ = layui.jquery;
    var layer = layui.layer;

    table.on('tool(mainTable)',function (obj){
        var data = obj.data;
        console.log(obj);
        if(obj.event === 'del'){
            layer.confirm('<div style="text-align: center">真的删除预约么?<br>删除后不可恢复<br>此订单将不再会被管理员审批或被分配有会议室使用时间</div>', function(index){
                obj.del();
                console.log(obj);
                $.post('/ajax/delOrder.php',{
                    id:obj.data.id
                },function (data,status){console.log(data)})
                layer.close(index);
            });
        }
    })
});