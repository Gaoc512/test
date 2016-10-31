<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript">
    function test(k){
        //var s='<?php echo U("Child/ajaxFinishedbooks");?>';
        var id=$("#id"+k).val();
        $.ajax({
                type:"post",
                url:'<?php echo U("Report/downloadControl");?>',
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

$("#opt-delall").click(function(){

    alert(22);
            // $.ajax({
            //     type:"get",
            //     url:"./ss_u.php",
            //     data:{username:223, content:33},
            //     success:function(data){
            //         //alert(data);
            //         $("#data").html(data);
            //     }
            // });
        
       });
</script>
</head>

<body>



 <div class="xt-bt">报表数据 > 测试学校</div>
 
<div class="tab" style="margin-bottom:70px;">
    <form name="f1" method="post" action="<?php echo U('Admin/Report/school',array('tid'=>$tid));?>" enctype="multipart/form-data">
            <input type="text" style="display:block; margin-left:20px; text-align:center; float:left; width:150px;" name='search' value=""/>
            <input type="submit" style="display:block; margin-left:20px; text-align:center; float:left; width:60px;" value="搜索">
        </form>
    <a class="red-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/relist3',array('tid'=>$tid));?>">未测试名单</a>
    <a class="blue-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/expAnswer',array('tid'=>$tid,'type'=>1));?>">低年级学生作答统计</a>
    <a class="blue-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/expAnswer',array('tid'=>$tid,'type'=>2));?>">高年级学生作答统计</a>
    <a class="green-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/expAnswerAvg',array('tid'=>$tid,'type'=>1));?>">低年级作答统计</a>
    <a class="green-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/expAnswerAvg',array('tid'=>$tid,'type'=>2));?>">高年级作答统计</a>
</div>
    <div class="xt-table">
        
    
        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#dcdcdc" width="100%">
            <tr>
                <th>测试名称</th>
                <th>学校名称</th>
                <th>起始时间</th>
                <th>结束时间</th>
                <th>下载权限</th>
                <th>报告数据</th>
                <th>报告统计</th>
            </tr>


            <?php if(empty($data)): ?><tr><td colspan="6"></td></tr>
            <?php else: ?>
            <tr>
                <?php if(is_array($data)): foreach($data as $k=>$vo): ?><input type="hidden" value="<?php echo ($vo["id"]); ?>" id="id<?php echo ($k); ?>"/>
                    <td><?php echo ($vo["testname"]); ?></td>
                    <td><?php echo ($vo["schoolname"]); ?></td>
                    <td><?php echo ($vo["starttime"]); ?></td>
                    <td><?php echo ($vo["endtime"]); ?></td>
                    <td onclick="test(<?php echo ($k); ?>)"><a><?php echo ($vo["download"]); ?></a></td>
                    <td>
                        <a class="green-xt" href="<?php echo U('Admin/Report/relist',array('tid'=>$vo[tid],'schid'=>$vo[schid]));?>">查看完成学生报告</a>
                        <a class="green-xt" href="<?php echo U('Admin/Report/relist2',array('tid'=>$vo[tid],'schid'=>$vo[schid]));?>">查看未完成学生名单</a>
                    </td>
                    <td><a class="blue-xt" href="<?php echo U('Admin/Report/expShudantongji',array('tid'=>$vo[tid],'schid'=>$vo[schid]));?>">下载统计列表</a></td>
                                </tr><?php endforeach; endif; ?>

           <tr><td colspan="11"><?php echo ($page); ?></td></tr><?php endif; ?>
        </table>
    </div>

</body>
</html>