<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>小学生图书推荐</title>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/style.css" />
<link rel="stylesheet" href="__PUBLIC__/css/examples.css">
<script src="__PUBLIC__/js/vendor/jquery-1.11.2.min.js"></script>	
<script src="__PUBLIC__/js/jquery.barrating.js"></script>
<script src="__PUBLIC__/js/examples.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".anniu1").click(function(e){
		var num=$(".example-e").length;
		var count=0;
		for(var i=1;i<=num;i++){
			
			if($("select[name='answer["+i+"]']").val()==0){
				count=count+1;
				}
			}
		
		if(count==0){
		 $("#f2").submit();
		}else{
			alert("请完成所有的题目，才可以提交");
			}
		});
});
</script>
<style>
a:hover a:visited{ color:#666;}
.tips1 ul{ margin-bottom:40px;}
</style>
</head>

<body style=" background:#ffefcd">
<div class="wapper" >
  <img style="width:100%; text-align:center;" src="__PUBLIC__/img/bgt.png"/>
  <div class="sn-content" style="padding-bottom:6% !important;">
      <div class="duze">
          <img style="width:100%;text-align:center;" src="__PUBLIC__/img/tx.png"/>
          <div class="du"><p>亲爱的同学，你好！</p>
请认真阅读以下各个题目，并在每一道题后给出1-10的评分，分数越高表示题目所描述的内容与你的想法越贴切，分数越低表示题目所描述的内容与你的想法越不贴切。</div>
      </div>
      <div class="tips1">
      <form name="f3" id="f2" method="post" action="<?php echo U('Senior/bookslist');?>">
      <?php if(is_array($datas)): $n = 0; $__LIST__ = $datas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($n % 2 );++$n;?><ul>
         
              <!--<li class="top1"  <?php if($n == 1): ?>style="margin-top:2rem !important;"<?php endif; ?>><?php echo ($n); ?>、<?php echo ($vo["title"]); ?></li>-->
              
              <li class="timu">
                  <p><?php echo ($n); ?>. <?php echo ($vo["title"]); ?></p>
				      <div class="col">
                      <div class="box box-green" >
							<div class="box-body">
								<select class="example-e" name="answer[<?php echo ($vo["id"]); ?>]" attr-id='<?php echo ($vo["id"]); ?>'>
                             <option value="0" selected="selected" >评分</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
                                	<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
								</select>
							</div>
						</div>
                   </div>
              </li>
           
          </ul><?php endforeach; endif; else: echo "" ;endif; ?>
       </form>
      </div>
      <a href="javascript:;" class="anniu1">提交</a>
  </div>
  
</div>
</body>
</html>