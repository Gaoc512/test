<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

 <div class="xt-bt">测试管理 </div>
 
 <div class="tab" style="height:30px;">
    <a class="yellow-int"  style="display:block; margin-left:20px; margin-bottom:10px;text-align:center; float:left; width:80px;" href="<?php echo U('Test/add');?>">新增测试</a>
 </div>
    <!-- <div class="xt-input" style="clear:both;">
     <form name="f1" method="post" action="<?php echo U('Admin/Books/lists');?>">
        <span>书名</span>
        <input type="text" class="int-text" name="book_name" />
        <span>书号</span><input type="text" class="int-text" name="book_code" />
        <span>出版社</span>
        <input type="text" class="int-text" name="book_publiser" />
       
        <input type="submit" value="确 定" class="yellow-int" />
        </form>
    </div>-->
    <div class="xt-table">
    
        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#dcdcdc" width="100%">
            <tr>
                <th>编号</th>
                <th>测试名称</th>
                <th>考试学校</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>


            <?php if(empty($data)): ?><tr><td colspan="6"></td></tr>
            <?php else: ?>
            <tr>
                <?php if(is_array($data)): foreach($data as $key=>$vo): ?><td><?php echo ($vo["id"]); ?></td>
                    <td><?php echo ($vo["name"]); ?></td>
                    <td><a class="blue-int" href="<?php echo U('Test/editschool',array('id'=>$vo[id]));?>">设置</a></td>
                    <td><?php echo ($vo["createtime"]); ?></td>
                    <td><a href="<?php echo U('Admin/Test/edit',array('id'=>$vo[id]));?>" class="yellow-xt">编辑</a>
                        <a  onclick="return window.confirm('是否确认删除该条信息？？');" href="<?php echo U('Admin/Test/deltest',array('id'=>$vo[id]));?>" class="blue-xt">删除</a></td>
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