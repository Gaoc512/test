<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style >
.red-int{background: #DA542E none repeat scroll 0% 0%;
color: #FFF;
padding: 6px 20px;
border: medium none;
border-radius: 3px;
font-size: 14px; display:block; width:100px; text-align:center; text-decoration:none; margin-left:50px;}
</style>
</head>

<body style=" margin:0px; padding:0px; font-family:"宋体";">
<p>
	<a href="<?php echo U('Report/download',array('id'=>$sdata['id'],'tid'=>$tid));?>" class="red-int">下载word文档</a>&nbsp;<a href="<?php echo U('Report/pdfdownload',array('id'=>$sdata['id'],'tid'=>$tid));?>" class="red-int">下载pdf文档</a>
</p>

<div style=" width:96%; margin:0 auto;">
<div style="width:100%; float:right; height:800px; margin-top:15px;color:#363636; background:url(http://106.38.65.206:8010/App/Tpl/Admin/Public/img/fm_word.jpg)  top center no-repeat; background-size:32%;">
<!-- <div style="width:55%; float:left; padding-top:20px; padding-left:10px; font-size:30px;"> -->

<td align=""  style="width:100%;">
<div style="position:relative;">
<p style="position:absolute;top:100px;left:100px;display:inline-block;margin-top:100px;">fbdsjfnksdn</p>
<img   src='.$imgbg.' />
</div>
</td>
<!-- <p style="font-size:40px; line-height:60px;">小学生</p>
<p style=" font-size:48px; line-height:70px;">个性化书单</p>
<div style=" margin-top:180px; line-height:60px;">
<p>姓名：<?php echo ($sdata["username"]); ?></p>
<p>班级：<?php echo ($sdata["grade"]); echo ($sdata["class"]); ?></p>
<p>学校：<?php echo ($sdata["school"]); ?></p>
<p>日期：<?php echo ($sdata["testtime"]); ?></p> -->
<!-- </div> -->
</div>

<div style="width:40%; float:right;"><img  src="<?php echo ($imgpath1); ?>" /></div>

</div>

<div style=" width:100%; clear:both;  margin-top:15px; font-size:24px; color:#363636;">
<h1 style="font-size:24px; color:#000;">亲爱的<?php echo ($sdata["username"]); ?>同学：</h1>
<p style="text-indent:2em; line-height:2;">您好！通过这个小测试，我们更加了解你的阅读兴趣！</p>
<p style="text-indent:2em; line-height:2;">我们发现你最喜欢<?php echo ($wenzi1["name"]); ?>，<?php echo ($wenzi1["content"]); ?></p>
<p style="text-indent:2em; line-height:2;">我们还发现你比较喜欢<?php echo ($wenzi2["name"]); ?>，<?php echo ($wenzi2["content"]); ?></p>
<p style="text-indent:2em; line-height:2;">  最后我们发现你对<?php echo ($wenzi3["name"]); ?>也感兴趣，<?php echo ($wenzi3["content"]); ?></p>
<p style="text-indent:2em; line-height:2;">现在来自这三个世界的朋友们已经来到你身边了，赶快来认识他们吧~</p>
<!--<p>现在，快看看有哪些你感兴趣的书正在等着你呢，你是不是已经迫不及待了呢？（中高年级）</p>-->
</div>
<div style="width:100%; height:auto; "><img style="width:50%; height:auto; margin-left:25%; text-align:center;" src="<?php echo ($imgpath2); ?>" /></div>

<div style=" width:100%;  margin-top:15px; font-size:24px; color:#363636;">
<h1 style="text-align:center; font-size:24px; color:#000;">我最感兴趣的图书推荐</h1>
<!-- 
<?php if(is_array($rbooks)): foreach($rbooks as $key=>$vo): ?><div style=" width:100%; height:auto; padding-top:15px; clear:both;">
<p style="color:#000;">《<?php echo ($vo["book_name"]); ?>》</p>
<div style="width:28%; float:left; height:auto;">
<?php if($vo[book_picimg] == ''): ?><img src="http://123.57.23.91/mybooks/Upload/fm.png" style="width:100%;" />
<?php else: ?>
<img src="http://123.57.23.91/mybooks/Upload/picimg/<?php echo ($vo["book_picimg"]); ?>" style="width:100%;" /><?php endif; ?>
</div>
<div style="width:68%; float:right;  padding-left:15px;font-size:20px; line-height:40px;">
<p><b>作者：</b><?php echo ($vo["book_author"]); ?></p>  
<p><b>出版社：</b><?php echo ($vo["book_publiser"]); ?></p>
<p><b>主题：</b><?php echo ($vo["book_topic"]); ?></p>
<p><b>简介：</b><?php echo ($vo["book_summary"]); ?></p>
</div>
</div><?php endforeach; endif; ?>
 -->
<?php if(is_array($rbooks)): foreach($rbooks as $key=>$vo): ?><div style=" width:100%; height:auto; padding-top:15px; clear:both;">
<p style="color:#000;">《<?php echo ($vo["book_name"]); ?>》</p>
<div style="width:28%; float:left; height:auto;">
<?php if($vo[book_picimg] == ''): ?><img src="http://106.38.65.206:8010/Upload/fm.png" style="width:100%;" />
<?php else: ?>
<img src="http://106.38.65.206:8010/Upload/picimg/<?php echo ($vo["book_picimg"]); ?>" style="width:100%;" /><?php endif; ?>
</div>
<div style="width:68%; float:right;  padding-left:15px;font-size:20px; line-height:40px;">
<p><b>作者：</b><?php echo ($vo["book_author"]); ?></p>  
<p><b>出版社：</b><?php echo ($vo["book_publiser"]); ?></p>
<p><b>主题：</b><?php echo ($vo["tag_name"]); ?></p>
<p><b>简介：</b><?php echo ($vo["book_summary"]); ?></p>
</div>
</div><?php endforeach; endif; ?>

</div>


<div style=" width:100%;  margin-top:15px; font-size:24px; clear:both; color:#363636;">
<h1 style="text-align:center; font-size:24px; color:#000;">拓展图书推荐</h1>
<p>除了你所感兴趣的主题之外，我们还想为你打开一扇窗，让你看到更加丰富多彩的世界，也许在以下这些书籍中你会发现意想不到的惊喜哦！</p>
<!-- <?php if(is_array($tbooks)): foreach($tbooks as $key=>$vo): ?><div style=" width:100%; height:auto; padding-top:15px; clear:both;">
<p style="color:#000;">《<?php echo ($vo["book_name"]); ?>》</p>
<div style="width:28%; float:left; height:auto;">
<?php if($vo[book_picimg] == ''): ?><img src="http://123.57.23.91/mybooks/Upload/fm.png" style="width:100%;" />
<?php else: ?>
<img src="http://123.57.23.91/mybooks/Upload/picimg/<?php echo ($vo["book_picimg"]); ?>" style="width:100%;" /><?php endif; ?>
</div>
<div style="width:68%; float:right;  padding-left:15px;font-size:20px; line-height:40px;">
<p><b>作者：</b><?php echo ($vo["book_author"]); ?></p>  
<p><b>出版社：</b><?php echo ($vo["book_publiser"]); ?></p>
<p><b>主题：</b><?php echo ($vo["book_topic"]); ?></p>
<p><b>简介：</b><?php echo ($vo["book_summary"]); ?></p>
</div>
</div><?php endforeach; endif; ?>
 -->
<?php if(is_array($tbooks)): foreach($tbooks as $key=>$vo): ?><div style=" width:100%; height:auto; padding-top:15px; clear:both;">
<p style="color:#000;">《<?php echo ($vo["book_name"]); ?>》</p>
<div style="width:28%; float:left; height:auto;">
<?php if($vo[book_picimg] == ''): ?><img src="http://106.38.65.206:8010/Upload/fm.png" style="width:100%;" />
<?php else: ?>
<img src="http://106.38.65.206:8010/Upload/picimg/<?php echo ($vo["book_picimg"]); ?>" style="width:100%;" /><?php endif; ?>
</div>
<div style="width:68%; float:right;  padding-left:15px;font-size:20px; line-height:40px;">
<p><b>作者：</b><?php echo ($vo["book_author"]); ?></p>  
<p><b>出版社：</b><?php echo ($vo["book_publiser"]); ?></p>
<p><b>主题：</b><?php echo ($vo["tag_name"]); ?></p>
<p><b>简介：</b><?php echo ($vo["book_summary"]); ?></p>
</div>
</div><?php endforeach; endif; ?>


</div>

</div>
</body>
</html>