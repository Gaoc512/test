<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

 <div class="xt-bt">报表数据 </div>
 

    <div class="xt-table">
    
        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#dcdcdc" width="100%">
            <tr>
                <th>编号</th>
                <th>测试名称</th>
                <th>创建时间</th>
                <th>考试学校</th>
            </tr>


            <?php if(empty($data)): ?><tr><td colspan="6"></td></tr>
            <?php else: ?>
            <tr>
                <?php if(is_array($data)): foreach($data as $key=>$vo): ?><td><?php echo ($vo["id"]); ?></td>
                    <td><?php echo ($vo["name"]); ?></td>
                    <td><?php echo ($vo["createtime"]); ?></td>
                    <td><a href="<?php echo U('Admin/Report/school',array('tid'=>$vo[id]));?>" class="yellow-xt">查看</a>
                        </tr><?php endforeach; endif; ?>
            
           <tr><td colspan="11"><?php echo ($page); ?></td></tr><?php endif; ?>
        </table>
    </div>

</body>
</html>