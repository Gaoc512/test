<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

 <div class="xt-bt">报表数据 > 学生报告</div>
 <div class="tab" style="margin-bottom:50px;">
 <!--
<a class="red-int"  style="display:block; margin-left:20px; text-align:center; float:left; width:80px;" href="<?php echo U('Report/piliang',array('id'=>$tid));?>">批量生成</a>
-->
<div style="display:block; margin-left:20px; text-align:center; float:left;">
<form name="f1" method="post" action="<?php echo U('Admin/Report/relist',array('tid'=>$tid,'schid'=>$schid));?>" enctype="multipart/form-data">
    <input type="text" class="search" name='search' value="" />
    <input type="submit" value="搜索"/>
</form>
</div>
<a class="blue-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/expAnswer',array('tid'=>$tid,'type'=>1,'schid'=>$schid));?>">低年级学生作答统计</a>
<a class="blue-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/expAnswer',array('tid'=>$tid,'type'=>2,'schid'=>$schid));?>">高年级学生作答统计</a>
<a class="green-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/expAnswerAvg',array('tid'=>$tid,'type'=>1,'schid'=>$schid));?>">低年级学生作答统计</a>
<a class="green-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Admin/Report/expAnswerAvg',array('tid'=>$tid,'type'=>2,'schid'=>$schid));?>">高年级学生作答统计</a>
<a class="red-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Report/wordchuanlian',array('tid'=>$tid,'schid'=>$schid));?>">串联word</a>
<a class="red-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Report/pdfchuanlian',array('tid'=>$tid,'schid'=>$schid));?>">串联pdf</a>
<a class="red-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Report/piliang',array('tid'=>$tid,'schid'=>$schid));?>">批量word</a>
<a class="red-int"  style="display:block; margin-left:20px; text-align:center; float:right; width:80px;" href="<?php echo U('Report/pdfpiliang',array('tid'=>$tid,'schid'=>$schid));?>">批量pdf</a>

 </div>

    <div class="xt-table">
    
        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#dcdcdc" width="100%">
            <tr>
            <th>学生姓名</th>
            <th>学校</th>
            <th>测试</th>
            <th>年级</th>
            <th>班级</th>
            <th>编号</th>
            <th>测试时间</th>
            <th>操作</th>
            </tr>
            <?php if(empty($data)): ?><tr><td colspan="10"></td></tr>
            <?php else: ?>
            <tr>
            <?php if(is_array($data)): foreach($data as $key=>$vo): ?><td><?php echo ($vo["stuname"]); ?></td>
                <td><?php echo ($vo["schoolname"]); ?></td>
                <td><?php echo ($vo["testname"]); ?></td>
                <td><?php echo ($vo["grade"]); ?></td>
                <td><?php echo ($vo["class"]); ?></td>
                <td><?php echo ($vo["stu_code"]); ?></td>
                <td><?php echo ($vo["createtime"]); ?></td>
                <td>
                    <a class="green-xt"   href="<?php echo U('Admin/Report/preview',array('tid'=>$tid,'stuid'=>$vo[id]));?>">预览报告</a>
                </td>
            </tr><?php endforeach; endif; ?>
           <tr><td colspan="11"><?php echo ($page); ?></td></tr><?php endif; ?>
        </table>
    </div>
    <!--<div class="xt-fenye">
    <?php echo ($page); ?>
        <!--<div class="xt-fenye-left">当前第 1 / 270 页,每页10条，共 2696条记录</div>
        <div class="xt-fenye-right">
            <a href="#">首页</a>
            <a href="#">上一步</a>
            <a href="#">下一步</a>
            <a href="#">尾页</a>
            <input type="text" name="text" />
            <a href="#" class="xt-link">跳转</a>
        </div>
    </div>-->


</body>
</html>