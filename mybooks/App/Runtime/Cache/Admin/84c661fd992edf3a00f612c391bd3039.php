<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>

 <div class="xt-bt">测试管理 > 完成学生报告 > 串联pdf</div>
 
  <form name="f1" method="post" action="<?php echo U('Admin/Report/pdfgradedownload',array('tid'=>$tid,'schid'=>$schid));?>" enctype="multipart/form-data">
    
    <div class="xt-input" style="background:#FFF;">
	    <p> <span>请选择年级：</span>
	        <select name="grade">
	            <option  value="一年级" selected="selected" >一年级</option>
	            <option  value="二年级" >二年级</option>
	            <option  value="三年级" >三年级</option>
	            <option  value="四年级" >四年级</option>
	            <option  value="五年级" >五年级</option>
	            <option  value="六年级" >六年级</option>
	        </select>
	    </p>
        <input type="hidden" name="tid" value="<?php echo ($tid); ?>" />
        <input type="hidden" name="schid" value="<?php echo ($schid); ?>" />
      <p style="margin-top:15px; padding-left:40px;"> <input type="submit" value="串联书单" class="green-int" /></p>
       
    </div>
    
 </form>

</body>
</html>