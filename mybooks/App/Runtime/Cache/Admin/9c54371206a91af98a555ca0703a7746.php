<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="__PUBLIC__/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript">
 $(document).ready(function () {

        $("#checkedAll").click(function () {

            //alert("aa");


            if ($(this).attr("checked")) { // 全选 

                $("input[name='checkbox_name[]']").each(function () {
                    $(this).attr("checked", true);
                });
            }
            else { // 取消全选 

                $("input[name='checkbox_name[]']").each(function () {
                    $(this).attr("checked", false);
                });
            }
        });
       
	   $("#pldel").click(function(e){
		   var ids = new Array();
		    $(".checked").each(function(){
		    	if($(this).attr('checked')) {
		    		ids.push($(this).val());
		    	}
		    })
		    if(ids.length >0 ){
		    	var delurl = "<?php echo U('Books/dellists');?>";
		    	$.ajax({
		    		type:'POST',
		    		url: delurl,
		    		data:{id:ids},
		    		success:function(data){
		    			if(data.status == '1') {
		    				 alert('删除成功！');
		    				 location.reload();
		    			} else if(data.status == '0')  {
		    				alert('删除失败!');
		    			}
		    		},
		    		dataType:'json'
		    	})
		    }else{
				alert("错误操作");
				}
		   
		   
		   })
     
    }); 
</script>

<script>
    //弹出调用的方法
    function showDivFun(){
        document.getElementById('popDiv').style.display='block';
    }
    //关闭事件
    function closeDivFun(){
        document.getElementById('popDiv').style.display='none';
    }
     
    </script>
</head>


<body>

 <div class="xt-bt">图书管理 > 图书管理</div>
 
 <div class="tab">
 <a class="green-int"  style="display:block; text-align:center; margin-bottom:10px; width:80px; float:left;" href="<?php echo U('Books/leadin');?>">导入图书</a>      <a class="yellow-int"  style="display:block; margin-left:20px; text-align:center; float:left; width:80px;" href="<?php echo U('Books/add');?>">录入图书</a> <a class="red-int"  style="display:block; margin-left:20px; text-align:center; float:left; width:80px;" href="<?php echo U('Books/search');?>">查重</a><a class="blue-int"  style="display:block; margin-left:20px; text-align:center; float:left; width:80px;" href="<?php echo U('Books/grabdangdang');?>">抓取当当网</a><a class="blue-int"  style="display:block; margin-left:20px; text-align:center; float:left; width:80px;" href="<?php echo U('Books/lists2');?>">残缺书籍</a><!-- <a class="blue-int"  style="display:block; margin-left:20px; text-align:center; float:left; width:80px;" href="<?php echo U('Books/lists3');?>">缺少信息</a> -->
 </div>
     <div class="xt-input" style="clear:both;">
     <form name="f1" method="post" action="<?php echo U('Admin/Books/lists');?>">
        <span>书名</span>
        <input type="text" class="int-text" name="book_name" value="<?php echo ($book_name); ?>"/>
        <span>书号</span><input type="text" class="int-text" name="book_code" value="<?php echo ($book_code); ?>"/>
        <span>出版社</span>
        <input type="text" class="int-text" name="book_publiser" value="<?php echo ($book_publiser); ?>"/>
        <!--<span>来源</span><input type="text" class="int-text" />-->
      <!--  <input type="button" value="确 定" class="green-int" />-->
        <input type="submit" value="确 定" class="yellow-int" />
         <a style=" margin-left:20px;" href="<?php echo U('Books/gsearch');?>"  class="green-int" >高级搜索</a>
        </form>
       
    </div>
    <div class="xt-table">
    
        <table cellpadding="0" cellspacing="0" border="0" bgcolor="#dcdcdc" width="100%">
            <tr>
            <th><input type="checkbox" class="selectall" id="checkedAll" /></th>
            <th width="20%">书名</th>
            <th>书号</th>
            <th>作者</th>
            <th>译者</th>
            <th>出版社</th>
            <th>出版年月</th>
            <th>价格</th>
            <th>年级分级</th>
            <th>分类</th>
            <th>主题</th>
            <th>标签</th>
            <th>创建时间</th>
            <th>操作</th>
            </tr>
            <?php if(empty($data)): ?><tr><td colspan="12"></td></tr>
            <?php else: ?>
            <tr>
            <?php if(is_array($data)): foreach($data as $key=>$vo): ?><td><input type="checkbox" class="checked" name="checkbox_name[]" value="<?php echo ($vo["id"]); ?>" /></td>
                <td><?php echo ($vo["book_name"]); ?></td>
                <td><?php echo ($vo["book_code"]); ?></td>
                <td><?php echo ($vo["book_author"]); ?></td>
                <td><?php echo ($vo["book_translater"]); ?></td>
                <td><?php echo ($vo["book_publiser"]); ?></td>
                <td><?php echo ($vo["book_publishtime"]); ?></td>
                <td><?php echo ($vo["book_price"]); ?></td>
                <td><?php echo ($vo["book_level"]); ?></td>
                <td><?php echo ($vo["book_class"]); ?></td>
                <td><?php echo ($vo["book_topic"]); ?></td>
                <td><?php echo ($vo["booklabel"]); ?></td>
                <td><?php echo ($vo["createtime"]); ?></td>
                <td><a href="<?php echo U('Admin/Books/edit',array('id'=>$vo[id],'p'=>$p));?>" class="yellow-xt">编辑</a><a  onclick="return window.confirm('是否确认删除该条信息？？');" href="<?php echo U('Admin/Books/del',array('id'=>$vo[id]));?>" class="blue-xt">删除</a><a href="<?php echo U('Admin/Books/book_supply_single',array('id'=>$vo[id]));?>" class="yellow-xt">补充</a></td>
            </tr><?php endforeach; endif; ?>
           <tr><td colspan="1" align="left" style="text-align:left;"><a href="javascript:;" id="pldel" class="blue-xt">批量删除</a></td>
                <td colspan="12" align="left" style="text-align:left;"><a class="blue-int" href="javascript:showDivFun()">部分删除</a></td></tr>
           <div id="popDiv" class="mydiv" style="display:none;">
                <form name="f1" method="post" action="<?php echo U('Admin/Books/partdel');?>" enctype="multipart/form-data">
                <p><span>开始页码：</span>
                     <input type="text" name="startpage" class="text" />
                </p>
                <p> <span>截止页码：</span>
                    <input type="text" name="endpage" class="text"  />
                </p>
                <p style="margin-top:15px; padding-left:40px;">
                 <input type="submit" value="确定" class="green-int" />
                 <a class="red-int" href="javascript:closeDivFun()">关闭</a>
                </p>
                
                </form>
            </div>
           <tr><td colspan="13"><?php echo ($page); ?></td></tr><?php endif; ?>
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