<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="Shortcut Icon" href="__PUBLIC__/images/logo.png" type="image/x-icon" />
<title>小学生图书推荐系统</title>
<link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
</head>

<script>
function windowHeight() {
	var de = document.documentElement;
	return self.innerHeight||(de && de.clientHeight)||document.body.clientHeight;
}
window.onload=window.onresize=function(){
	var wh=windowHeight();
	document.getElementById("xt-left").style.height = document.getElementById("xt-right").style.height = (wh-document.getElementById("xt-top").offsetHeight)+"px";
}
</script>

<body>
<!-- top -->
<div id="xt-top">
    <div class="xt-logo"><img src="__PUBLIC__/images/logo.png" /></div>
    <div class="xt-geren">
        <div class="xt-exit"><span class="xt-span">您好!欢迎你，<?php echo ($username); ?>管理员，</span>
            <a href="<?php echo U('Admin/Index/logout');?>" title="退出" class="exit">退出</a></div>
    </div>
</div>
<!-- left -->
<div class="xt-center">
<div id="xt-left">
    <div class="xt-logo"></div>
    <div class="xt-menu">
        <ul>
            <li><a href="<?php echo U('Admin/Books/lists');?>" target="right" class="hover"><em class="one"></em>图书管理</a></li>
        </ul>
        <ul>
            <li><a href="<?php echo U('Admin/Statistics/classification');?>" target="right"><em class="five"></em>图书统计</a></li>
        </ul>
       <ul>
            <li><a href="<?php echo U('Admin/Topic/index');?>" target="right" ><em class="four"></em>图书主题管理</a></li>
        </ul>
        <ul>
            <li><a href="<?php echo U('Admin/Label/index');?>" target="right"><em class="five"></em>图书标签1管理</a></li>
        </ul>
        <ul>
            <li><a href="<?php echo U('Admin/School/index');?>" target="right" ><em class="two"></em>学校管理</a></li>
        </ul>
        <ul>
            <li><a href="<?php echo U('Admin/Test/index');?>" target="right" ><em class="two"></em>测试管理</a></li>
        </ul>
        <ul>
            <li><a href="<?php echo U('Admin/Report/index');?>" target="right" ><em class="three"></em>报表数据</a></li>
        </ul>
        <ul>
            <li><a href="<?php echo U('Admin/User/index');?>" target="right" ><em class="seven"></em>修改密码</a></li>
        </ul>
        
           
    </div>
</div>
<!-- right -->
<div id="xt-right">
<iframe name="right" id="rightMain" src="<?php echo U('Admin/Books/lists');?>" frameborder="no" scrolling="auto" width="100%" height="100%" allowtransparency="true"></iframe>

   
</div>
</div>

</body>
</html>