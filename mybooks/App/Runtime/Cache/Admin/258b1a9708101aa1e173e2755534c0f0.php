<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.2.min.js"></script>
<script language="javascript" type="text/javascript" src="__PUBLIC__/js/My97DatePicker/WdatePicker.js"></script>
<style>
.Span:hover{
    cursor: pointer;
}
</style>
</head>

<body>

 <div class="xt-bt">测试管理 > 测试学校</div>
    <script type="text/javascript">
    function test(k){
        //var s='<?php echo U("Child/ajaxFinishedbooks");?>';
        var id=$("#id"+k).val();
        $.ajax({
                type:"post",
                url:'<?php echo U("Test/downloadControl");?>',
                data:{id:id},
                success:function(data){
                   alert(data);
                    //$("#data").html(data);
                }
            });
        //window.location('<?php echo U("Report/school",array('tid'=>$tid));?>');
        //location.reload(true);
         location.replace(location.href);
        
    }

    $(document).ready(function(e) {
        $("#opt-select-all1").on('click', function(){
                if($(this).prop('checked'))
                {
                    $(".aid1").prop('checked', true);
                }
                else
                {
                    $(".aid1").prop('checked', false);
                }
            });

        $("#opt-select-all2").on('click', function(){
                if($(this).prop('checked'))
                {
                    $(".aid2").prop('checked', true);
                }
                else
                {
                    $(".aid2").prop('checked', false);
                }
            });
            
            $("#test-del").click(function(){
                var schids = [];
                $(".aid1").each(function(){
                    if($(this).prop('checked')) schids.push($(this).val());
                });
                
                if(schids.length > 0)
                {
                    var flag = confirm('确定删除学校？');
                    if(flag)
                    {
                        var params = {};
                        params.schids = schids.join(',');
                        params.id = $(".tid").val();
                        $.getJSON('<?php echo U("Test/ajaxDelschool");?>', params, function(json){
                            alert(json.msg);
                            if(json.status)
                            {
                                location.reload();
                            }
                        });
                    }
                }
                else
                {
                    alert('请选择学校');
                }
            });

            $("#test-add").click(function(){
                var schids = [];
                $(".aid2").each(function(){
                    if($(this).prop('checked')) schids.push($(this).val());
                });
                
                if(schids.length > 0)
                {
                    var flag = confirm('确定增加学校？');
                    if(flag)
                    {
                        var params = {};
                        params.schids = schids.join(',');
                        params.id = $(".tid").val();
                        $.getJSON('<?php echo U("Test/ajaxAddschool");?>', params, function(json){
                            alert(json.msg);
                            if(json.status)
                            {
                                location.reload();
                            }
                        });
                    }
                }
                else
                {
                    alert('请先选择学校！');
                }
            });
            
    });
    </script> 

    <script>
    //弹出调用的方法
    function showDivFun(k){
        document.getElementById('popDiv'+k).style.display='block';
    }
    //关闭事件
    function closeDivFun(k){
        document.getElementById('popDiv'+k).style.display='none';
    }
     
    </script>
    <input type="hidden" class="tid" value="<?php echo ($id); ?>" />
<div style="display: inline-block; width: 55%; float: left;">
    <div style="margin:20px;">
        <form name="f1" method="post" action="<?php echo U('Admin/Test/editschool',array('id'=>$id));?>" enctype="multipart/form-data">
            <input type="text" class="search_in" name='search_in' value=""/>
            <input type="submit" value="搜索" class="white-int">
        </form>
    </div>
    <div class="xt-table">
        <p>已选择的学校列表：</p>
        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#dcdcdc" width="100%">
            <tr>
                <th><input type="checkbox" class="selectall1" id="opt-select-all1" />全选</th>
                <th>学校名称</th>
                <th>下载权限</th>
                <th>考试时间</th>
            </tr>


            <?php if(empty($data_in)): ?><tr><td colspan="3"></td></tr>
            <?php else: ?>
            <tr>
                <?php if(is_array($data_in)): foreach($data_in as $k=>$vo): ?><input type="hidden" value="<?php echo ($vo["test_school_id"]); ?>" id="id<?php echo ($k); ?>"/>
                    <td><input type="checkbox" class="aid1" value="<?php echo ($vo["id"]); ?>" /></td>
                    <td><?php echo ($vo["schoolname"]); ?></td>
                    <td onclick="test(<?php echo ($k); ?>)"><span class="Span"><?php echo ($vo["download"]); ?></span></td>
                    <td><a class="blue-int" href="javascript:showDivFun(<?php echo ($k); ?>)">设置</a></td>

                    <div id="popDiv<?php echo ($k); ?>" class="mydiv" style="display:none;">
                        <form name="f1" method="post" action="<?php echo U('Admin/Test/testtime',array('schid'=>$vo[id],'tid'=>$id));?>" enctype="multipart/form-data">
                        <p><span>学校名称：<?php echo ($vo['schoolname']); ?></span></p>
                        <p><span>开始时间：</span>
                             <input type="datetime" name="starttime" class="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo ($vo["starttime"]); ?>"  readonly="readonly" >
                        </p>
                        <p> <span>截止时间：</span>
                            <input type="datetime" name="endtime" class="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo ($vo["endtime"]); ?>"  readonly="readonly"  />
                        </p>
                        <p style="margin-top:15px; padding-left:40px;"> <input type="submit" value="保存" class="green-int" /></p>
                        <a class="red-int" href="javascript:closeDivFun(<?php echo ($k); ?>)">关闭</a>
                        </form>
                    </div>
            </tr><?php endforeach; endif; ?>
            <tr><td colspan="4"><?php echo ($show_in); ?></td></tr><?php endif; ?>
        </table>
    </div>
</div>


    <div style="display: inline-block; text-align: bottom; width: 2%; height:200px;">
    <a id="test-add" class="blue-xt"> <<<< </a>
    <br />
    <br />
    <a id="test-del" class="blue-xt"> >>>> </a>
    </div>
<div style="display: inline-block; width: 35%; float: right;">

    <div style="margin:20px;">
        <form name="f1" method="post" action="<?php echo U('Admin/Test/editschool',array('id'=>$id));?>" enctype="multipart/form-data">
            <input type="text" class="search_out" name='search_out' value="" />
            <input type="submit" value="搜索" class="white-int">
        </form>
    </div>
    <div class="xt-table" >
        <p>未选择的学校列表：</p>
        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#dcdcdc" width="100%">
            <tr>
                <th><input type="checkbox" class="selectall2" id="opt-select-all2" />全选</th>
                <th>学校名称</th>
            </tr>


            <?php if(empty($data_out)): ?><tr><td colspan="2"></td></tr>
            <?php else: ?>
            <tr>
                <?php if(is_array($data_out)): foreach($data_out as $key=>$vo): ?><td><input type="checkbox" class="aid2" value="<?php echo ($vo["id"]); ?>" /></td>
                    <td><?php echo ($vo["schoolname"]); ?></td>
                    
            </tr><?php endforeach; endif; ?>
            <tr><td colspan="2"><?php echo ($show_out); ?></td></tr><?php endif; ?>
        </table>
    </div>
</div>
    
</body>
</html>