<?php
class BooksAction extends CommonAction {

	/**
	 * @link http://www.phpddt.com
	 */
	public function url_exists($url) {
	    $ch = curl_init(); 
	    curl_setopt ($ch, CURLOPT_URL, $url); 
	    //不下载
	    curl_setopt($ch, CURLOPT_NOBODY, 1);
	    //设置超时
	    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3); 
	    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	    curl_exec($ch);
	    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
	    if($http_code == 200) {
	        return true;
	    }
	    return false;
	}




	public function lists(){

		$sql="1=1";
		if($_POST){
			$book_name=str_replace(' ', '',I("book_name"));
			$book_code=I("book_code");
			$book_publiser=str_replace(' ', '',I("book_publiser"));
		
			if($book_name!=''){
				$this->assign('book_name',$book_name);
				$sql.=" and replace(`book_name`,' ','') like '%$book_name%'";
			}
			if($book_code!=''){
				$this->assign('book_code',$book_code);
				$sql.=" and book_code='$book_code'";
			}
			if($book_publiser!=''){
				$this->assign('book_publiser',$book_publiser);
				$sql.=" and replace(`book_publiser`,' ','')='$book_publiser'";
			}
		}
	//	echo $sql;
	    import('ORG.Util.Page');// 导入分页类
		$count = M("books")->where($sql)->count();// 查询满足要求的总记录数 $map表示查询条件
		//$p=I('p',1);
	   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出
	    $data=M("books")->where($sql)->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
	    //$booklabels = M("booklabel")->where("title!='其它'")->getField('title',true);
	    //var_dump($booklabels);die;
	    foreach($data as $key=>$value){
	    	$booklabel = M("tags")->where("bid=$value[id]")->getField('tag_name',true);
	    	$labels = implode(',',$booklabel);
	    	/*
	    	foreach($booklabel as $key1=>$value1){
	    		if(in_array($value1['tagname'],$booklabels)){
	    			$label = $value1['tagname'];
	    		}
	    	}
	    	*/
	    	$data[$key]['booklabel'] = $labels;
	    }
	    //echo M("books")->getlastsql();
	    $this->assign('data',$data);
	    $this->assign('page',$show);// 赋值分页输出
	    //$this->assign('p',$p);
	    $this->display();
		
	}
	
	
	public function impUser(){
	       header("Content-type:text/html;charset=utf-8");
           if (!empty($_FILES)) {
               import('ORG.Net.UploadFile');
                $config=array(
                    'allowExts'=>array('xlsx','xls'),
                    'savePath'=>'./Upload/Excel/',
                    'saveRule'=>'time',
                );
                $upload = new UploadFile($config);
                if (!$upload->upload()) {
                    $this->error($upload->getErrorMsg());
                } else {
                    $info = $upload->getUploadFileInfo();
                    
                }
            
                vendor("PHPExcel.PHPExcel.IOFactory");
                    $file_name=$info[0]['savepath'].$info[0]['savename'];
                    $objReader = PHPExcel_IOFactory::createReader('Excel5');
                    $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow(); // 取得总行数
                    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                    for($i=2;$i<=$highestRow;$i++)
                    {   
					
                       $data['book_name']=  (string)$objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue(); 
                       $data['book_code']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                       $data['book_author']= (string)$objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
                       $data['book_translater'] = $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
                        $data['book_publiser'] = $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
                        $data['book_publishtime']= $this->excelTime($objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue());
                        $data['book_price']= $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
                        $data['book_summary']= (string)$objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
                        $data['book_level']= $objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue();
                        $data['book_link']= $objPHPExcel->getActiveSheet()->getCell("K".$i)->getValue();
                        $data['book_class']= $objPHPExcel->getActiveSheet()->getCell("L".$i)->getValue();
                        $data['book_topic']= $objPHPExcel->getActiveSheet()->getCell("M".$i)->getValue();                       
                        $data['createtime']=date("Y-m-d H:i:s");                              
                        $bid=M('books')->add($data);
                        $tag1=$objPHPExcel->getActiveSheet()->getCell("N".$i)->getValue();  
                        $array=array("bid"=>$bid,'tag_name'=>$tag1);  
                        M("tags")->add($array);
                       $tag2=$objPHPExcel->getActiveSheet()->getCell("O".$i)->getValue();  
                       if($tag2!=""){
                       	 $array1=array("bid"=>$bid,'tag_name'=>$tag2); 
                       	  M("tags")->add($array1);
                       }
                       $tag3=$objPHPExcel->getActiveSheet()->getCell("P".$i)->getValue();  
                       if($tag3!=""){
                       	 $array2=array("bid"=>$bid,'tag_name'=>$tag3); 
                       	  M("tags")->add($array2);
                       }
                       $tag4=$objPHPExcel->getActiveSheet()->getCell("Q".$i)->getValue();  
                       if($tag4!=""){
                       	 $array3=array("bid"=>$bid,'tag_name'=>$tag4); 
                       	  M("tags")->add($array3);
                       }
                       $tag5=$objPHPExcel->getActiveSheet()->getCell("R".$i)->getValue();  
                       if($tag5!=""){
                       	 $array4=array("bid"=>$bid,'tag_name'=>$tag5); 
                       	  M("tags")->add($array4);
                       }
                       $tag6=$objPHPExcel->getActiveSheet()->getCell("S".$i)->getValue();  
                       if($tag6!=""){
                       	 $array5=array("bid"=>$bid,'tag_name'=>$tag6); 
                       	  M("tags")->add($array5);
                       }
                        $tag7=$objPHPExcel->getActiveSheet()->getCell("T".$i)->getValue();  
                       if($tag7!=""){
                       	 $array6=array("bid"=>$bid,'tag_name'=>$tag7); 
                       	  M("tags")->add($array6);
                       }
                         $tag8=$objPHPExcel->getActiveSheet()->getCell("U".$i)->getValue();  
                       if($tag8!=""){
                       	 $array7=array("bid"=>$bid,'tag_name'=>$tag8); 
                       	  M("tags")->add($array7);
                       }
                        $tag9=$objPHPExcel->getActiveSheet()->getCell("V".$i)->getValue();  
                       if($tag9!=""){
                       	 $array8=array("bid"=>$bid,'tag_name'=>$tag9); 
                       	  M("tags")->add($array8);
                       }
                       $tag10=$objPHPExcel->getActiveSheet()->getCell("W".$i)->getValue();  
                       if($tag10!=""){
                       	 $array9=array("bid"=>$bid,'tag_name'=>$tag10); 
                       	  M("tags")->add($array9);
                       }
                    } 
                  $this->success('导入成功！',U('lists'));
            }else
                {
                    $this->error("请选择上传的文件");
                }     
             
        }

        public function impBooks_save(){
	       header("Content-type:text/html;charset=utf-8");
           if (!empty($_FILES)) {
               import('ORG.Net.UploadFile');
                $config=array(
                    'allowExts'=>array('xlsx','xls'),
                    'savePath'=>'./Upload/Excel/',
                    'saveRule'=>'time',
                );
                $upload = new UploadFile($config);
                if (!$upload->upload()) {
                    $this->error($upload->getErrorMsg());
                } else {
                    $info = $upload->getUploadFileInfo();
                    
                }
            
                vendor("PHPExcel.PHPExcel.IOFactory");
                    $file_name=$info[0]['savepath'].$info[0]['savename'];
                    $objReader = PHPExcel_IOFactory::createReader('Excel5');
                    $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow(); // 取得总行数
                    $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                    for($i=2;$i<=$highestRow;$i++)
                    {   
						$data['id']= $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
                        $data['book_name']=  (string)$objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue(); 
                        $data['book_code']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                        $data['book_author']= (string)$objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
                        $data['book_translater'] = $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
                        $data['book_publiser'] = $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
                        $data['book_publishtime']= $this->excelTime($objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue());
                        $data['book_price']= $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
                        $data['book_summary']= (string)$objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
                        $data['book_level']= $objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue();
                        $data['book_link']= $objPHPExcel->getActiveSheet()->getCell("K".$i)->getValue();
                        $data['book_class']= $objPHPExcel->getActiveSheet()->getCell("L".$i)->getValue();
                        $data['book_topic']= $objPHPExcel->getActiveSheet()->getCell("M".$i)->getValue();                       
                        $data['createtime']=date("Y-m-d H:i:s");                              
                        
                        M('books')->save($data);
                    } 
                  $this->success('导入成功！',U('lists'));
            }else
                {
                    $this->error("请选择上传的文件");
                }     
             
        }
        
     //excel日期转换函数
	function excelTime($days, $time=false){
	    if(is_numeric($days)){
       //based on 1900-1-1
	        $jd = GregorianToJD(1, 1, 1970);
	        $gregorian = JDToGregorian($jd+intval($days)-25569);
	        $myDate = explode('/',$gregorian);

	        $myDateStr = str_pad($myDate[2],4,'0', STR_PAD_LEFT)

	                ."-".str_pad($myDate[0],2,'0', STR_PAD_LEFT)

	                ."-".str_pad($myDate[1],2,'0', STR_PAD_LEFT)

	                .($time?" 00:00:00":'');

	        return $myDateStr;

	    }

	    return $days;

	}
	
	
      //录入
      public function add(){
      	if($_POST){
      		if($_FILES['book_picimg']['name']!=''){
      		import('ORG.Net.UploadFile');
		//导入上传类
		$upload = new UploadFile();
		//设置上传文件大小
		$upload->maxSize = 3292200;
		//设置上传文件类型
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		//设置附件上传目录
		$upload->savePath = './Upload/picimg/';
		 //设置需要生成缩略图，仅对图像文件有效 
		        $upload->thumb = true; 
		//设置需要生成缩略图的文件后缀 
        $upload->thumbPrefix = 'm_';  //生产2张缩略图 
        //设置缩略图最大宽度 
        $upload->thumbMaxWidth = '190'; 
        //设置缩略图最大高度 
        $upload->thumbMaxHeight = '230'; 

if (!$upload->upload()) {
    //捕获上传异常
    $this->error($upload->getErrorMsg());
} else {
	 $uploadList = $upload->getUploadFileInfo();
	 $picimg=$uploadList[0]['savename'];
	 $book_thumnpic='m_'.$picimg;
}
      }else{
		$picimg=I('book_picimg');  
		  }
      		$adddata=array(
      		'book_name'=>I('book_name'),
      		'book_code'=>I('book_code'),
      		'book_author'=>I('book_author'),
      		'book_translater'=>I('book_translater'),
      		'book_publiser'=>I('book_publiser'),
      		'book_publishtime'=>I('book_publishtime'),
      		'book_price'=>I('book_price'),
      		'book_summary'=>I('book_summary'),
      		'book_level'=>I('book_level'),
      		'book_link'=>I('book_link'),
      		'book_topic'=>I('book_topic'),
      		'book_class'=>I('book_class'),
      		'book_picimg'=>$picimg,
      		'createtime'=>date("Y-m-d H:i:s"),
			'book_thumnpic'=>$book_thumnpic
      		);
      		$bid=M("books")->add($adddata);
      		$tags=I('tags');
			if(!empty($tags)){
      		foreach ($tags as $key=>$val){
				if($val!=''){
      			$adddata1=array(
      			'bid'=>$bid,
      			'tag_name'=>$val
      			);
      		M("tags")->add($adddata1);
				}
      		}
			}
      		if($bid==true){
      			 $this->success('录入成功！',U('lists'));
      		}else{
      			$this->error("录入失败");
      		}
      		//print_r($_POST);
      	}else {
      		$class=M("bookclass")->select();
			$this->assign('class',$class);
			$topics=M("booktopic")->select();
			$this->assign('topics',$topics);
			$labels=M("booklabel")->select();
			$this->assign('labels',$labels);
      	$this->display();		
      	}
      }
	
	//编辑
	public function edit(){
	    $p=I('p');
		if($_POST){
			if($_FILES['book_picimg']['name']==''){
				
				$picimg=I("oldbook_picimg");
				$book_thumnpic=I("oldbook_thumnpic");
			}else{
				import('ORG.Net.UploadFile');
				//导入上传类
				$upload = new UploadFile();
				//设置上传文件大小
				$upload->maxSize = 3292200;
				//设置上传文件类型
				$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
				//设置附件上传目录
				$upload->savePath = './Upload/picimg/';
				//设置需要生成缩略图，仅对图像文件有效 
				        $upload->thumb = true; 
				//设置需要生成缩略图的文件后缀 
				        $upload->thumbPrefix = 'm_';  //生产2张缩略图 
				        //设置缩略图最大宽度 
				        $upload->thumbMaxWidth = '190'; 
				        //设置缩略图最大高度 
				        $upload->thumbMaxHeight = '230'; 
				
				if (!$upload->upload()) {
				    //捕获上传异常
				    $this->error($upload->getErrorMsg());
				} else {
					 $uploadList = $upload->getUploadFileInfo();
					 $picimg=$uploadList[0]['savename'];
					 $book_thumnpic='m_'.$picimg;
				}
				//删除原图
				$oldbook_picimg=I("oldbook_picimg");
				if($oldbook_picimg!=""){
				unlink('./Upload/picimg/'.$oldbook_picimg);
				unlink('./Upload/picimg/m_'.$oldbook_picimg);
				}
			}
		
			$adddata=array(
      		'book_name'=>I('book_name'),
      		'book_code'=>I('book_code'),
      		'book_author'=>I('book_author'),
      		'book_translater'=>I('book_translater'),
      		'book_publiser'=>I('book_publiser'),
      		'book_publishtime'=>I('book_publishtime'),
      		'book_price'=>I('book_price'),
      		'book_summary'=>I('book_summary'),
      		'book_level'=>I('book_level'),
      		'book_link'=>I('book_link'),
      		'book_topic'=>I('book_topic'),
      		'book_class'=>I('book_class'),
      		'book_picimg'=>$picimg,
			'book_thumnpic'=>$book_thumnpic
      		);
      		$id=I('id');
      		$bid=M("books")->where("id=$id")->save($adddata);

      		$book_label = I('book_label');
      		//var_dump($book_label);die;
      		$tags=I('tags');
      		foreach ($tags as $key=>$val){
      			$adddata1=array(
	      			'bid'=>$id,
	      			'tag_name'=>$val
	      			);	
	      		$res=M("tags")->add($adddata1);		
      		}
      		if(!empty($book_label)){
  				$adddata2 = array('bid'=>$id,'tag_name'=>$book_label);

  				$tagdata=M("tags")->where("bid=$id")->select();
			    $labels=M('booklabel')->select();
			    foreach($labels as $key=>$value){
			    	foreach($tagdata as $key1=>$value1){
			    		if($value['title']==$value1['tag_name']){
			    			$label = $value['title'];
			    			break;
			    		}
			    	}
			    }
			    M('tags')->where("bid=$id and tag_name='$label'")->delete();
  			}
  			//var_dump($adddata2);die;
  			$res=M("tags")->add($adddata2);
      		if($bid==true || $res==true){
//      			 $this->success('修改成功！',U('lists'));
				$this->success('修改成功！',U('lists',array('p'=>$p)));
      		}else{
      			//$this->error("修改失败");
      			$this->redirect('lists');
      		}
		}else{
			$id=I("id");
			if(!empty($id)){
			   
				$data=M("books")->where("id=$id")->find();
			    $tagdata=M("tags")->where("bid=$id")->select();
			    $class=M("bookclass")->select();
			    $topics=M("booktopic")->select();
			    $labels=M('booklabel')->select();

			    foreach($labels as $key=>$value){
			    	foreach($tagdata as $key1=>$value1){
			    		if($value['title']==$value1['tag_name']){
			    			$data['book_label'] = $value['title'];
			    			unset($tagdata[$key1]);
			    			break;
			    		}
			    	}
			    }

				$this->assign('class',$class);
				$this->assign('topics',$topics);
				$this->assign('labels',$labels);
				$this->assign('p',$p);
			    $this->assign('tagdata',$tagdata);
			    $this->assign('data',$data);
			    $this->display();		
			}
		}
	}
    
	//删除标签
	public function deltag(){
		$id=I("id");
		$re=M("tags")->where("id=$id")->delete();
		if($re==true){
			echo 1;
		}else{
			echo 2;
		}
	}  
	
	//删除
	public function del(){
		$id=I("id");
		//查重标志
		$type=I('type');
		$pic=M("books")->where("id=$id")->getField('book_picimg');
		
		if($pic!=""){
		unlink('./Upload/picimg/'.$pic);
		unlink('./Upload/picimg/m_'.$pic);
		}
		$re=M("books")->where("id=$id")->delete();
		if($re==true){
			if($type==1){
				 $this->success('删除成功！',u('search'));
			}else{
			 $this->success('删除成功！');
			}
		}else{
			 $this->error('删除失败！');
		}
	}  
	
	
	
	//导入
	public function leadin(){
		$this->display();	
	}
	
public function search(){
    import('ORG.Util.Page');// 导入分页类
	$count = M("books")->group("book_code,replace(`book_name`,' ',''),book_publiser")->having("count(*)>1")->count();// 查询满足要求的总记录数 $map表示查询条件
//echo M("books")->getlastsql();
	$Page = new Page($count,15);// 实例化分页类 传入总记录数
   	$show = $Page->show();// 分页显示输出
    $data=M("books")->field("*,count(*) as bcount")->group("book_code,replace(`book_name`,' ',''),book_publiser")->having("count(*)>1")->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    //echo M("books")->getlastsql();
//    print_r($data);
    $this->assign('data',$data);
    $this->assign('page',$show);// 赋值分页输出
    $this->display();
		
	}

	//重复的详情
	public function cdetail(){
		$id=I("id");
		$data=M("books")->where("id=$id")->find();
		if($data['book_name']!=''){
		$book_name=str_replace(' ', '', $data['book_name']);
		$bdata=M("books")->where("replace(`book_name`,' ','')='$book_name' and book_code='$data[book_code]' and book_publiser='$data[book_publiser]'")->order('createtime desc')->select();
		}else{
		
		$bdata=M("books")->where("`book_name` is NULL and book_code='$data[book_code]' and book_publiser='$data[book_publiser]'")->order('createtime desc')->select();
		}

      //echo M("books")->getlastsql();
		$this->assign('data',$bdata);
    
    $this->display();
	}

	public function book_supply_single(){

		header("Content-type:text/html;charset=utf-8");
		vendor("Dom.simple_html_dom");
		$id = I('id');
		$book = M('books')->where("id=$id")->find();

		$searchUrl="http://search.dangdang.com/?key=".$book['book_name']."&act=input";//当当网搜索图书信息
		$html1 = file_get_html($searchUrl); 
		$info = $html1->find('.line1 .pic',0)->attr;
		$url = $info['href'];
		if(empty($url)){
			$this->error("当当网搜索不到该书籍信息");
		}
		$html = file_get_html($url);
		// var_dump($searchUrl);
		// var_dump($info);
		// var_dump($url);//die;

		//判断有没有丛书
		$cong=$html->find('.book_messbox .clearfix .show_info_left', 0)->innertext;

		$data=array();
	    // 当当价
		$data['book_price']=$html->find('.price_m', 0)->innertext;
		//作     者
	    if( iconv('GB2312', 'UTF-8', str_replace('&nbsp;','',$cong))=="丛书名"){
			//有丛书
			$data['book_author']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.show_info_right ', 7)->find('.c_green', 0)->innertext));
			  //出版社
		    $data['book_publiser']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.show_info_right ', 8)->find('.c_green', 0)->innertext));
		    //出版时间
		    $data['book_publishtime']=$html->find('.max_width', 3)->innertext;
		    //ＩＳＢＮ
		    $data['book_code']=$html->find('.max_width', 4)->innertext;
		}else{
			//没丛书
			$data['book_author']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1 a', 0)->innertext));
			//出版社
		    $data['book_publiser']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1 ', 1)->find('a', 0)->innertext));
		    //出版时间
		    $book_publishtime=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1', 2)->innertext));
			$data['book_publishtime']=substr($book_publishtime,strrpos($book_publishtime,':')+1);
		    //ＩＳＢＮ
		   	$book_code=iconv('GB2312', 'UTF-8', strip_tags($html->find('.key', 0)->find('li', 9)->innertext));
		    $data['book_code']=substr($book_code,strrpos($book_code,'：')+3);
		}
		//内容简介
		$data['book_summary']=iconv('GB2312', 'UTF-8', strip_tags($html->find('#content textarea',0)->innertext));
		$data['book_summary']=str_replace(' ','',$data['book_summary']);
		//var_dump($img);//die;
		preg_match_all('/\d+/',$data['book_price'],$data['book_price']);

		if(!$this->url_exists($book['book_picimg'])){
			$smallImg = $html1->find('.line1 .pic img',0)->attr;//小图
			if(empty($smallImg)){
				continue;
			}
			$this->GrabImage($smallImg['src'],$value['book_thumnpic']);
			
			$info = $html1->find('.line1 .pic',0)->attr;
			$url = $info['href'];
			if(empty($url)){
				continue;
			}
			$html2 = file_get_html($url);
			$bigImg=$html2->find('#largePicDiv #largePic',0)->attr;//大图
			$this->GrabImage($bigImg['src'],$value['book_picimg']);
		}
				


		$re = M('books')->where("id=$id")->save($data);

		$this->success("操作成功");
	}

	//补全书库书籍图片
	public function book_supply(){
		header("Content-type:text/html;charset=utf-8");
		vendor("Dom.simple_html_dom");

		set_time_limit(0);
		$picUrl = UPLOAD;
		$books = M('books')
			->field('book_picimg,id,book_thumnpic,book_name,canque')
			->where("canque!=0")
			->select();
		foreach($books as $key=>$value){
			if($value['canque']==2){//当当抓取缺少图片的书籍信息
				$searchUrl="http://search.dangdang.com/?key=".$value['book_name']."&act=input";//当当网搜索图书信息
				$html1 = file_get_html($searchUrl);
				if(!is_object($html1)){
					continue;
				}
				$smallImg = $html1->find('.line1 .pic img',0)->attr;//小图
				if(empty($smallImg)){
					continue;
				}
				$this->GrabImage2($smallImg['src'],$value['book_thumnpic']);
				
				$info = $html1->find('.line1 .pic',0)->attr;
				$url = $info['href'];
				if(empty($url)){
					continue;
				}
				$html2 = file_get_html($url);
				if(!is_object($html2)){
					continue;
				}
				$bigImg=$html2->find('#largePicDiv #largePic',0)->attr;//大图
				$this->GrabImage2($bigImg['src'],$value['book_picimg']);

				$num1++;	
			}else if($value['canque'] == 1 and !empty($value['book_name'])){
				$searchUrl="http://search.dangdang.com/?key=".$value['book_name']."&act=input";//当当网搜索图书信息
				$html1 = file_get_html($searchUrl);
				if(!is_object($html1)){
					continue;
				} 
				$info = $html1->find('.line1 .pic',0)->attr;
				$url = $info['href'];
				if(empty($url)){
					continue;
				}
				$html = file_get_html($url);
				if(!is_object($html)){
					continue;
				}
				// var_dump($searchUrl);
				// var_dump($info);
				// var_dump($url);die;

				//判断有没有丛书
				$cong=$html->find('.book_messbox .clearfix .show_info_left', 0)->innertext;

				$data=array();
			    // 当当价
				$data['book_price']=$html->find('.price_m', 0)->innertext;
				//作     者
			    if( iconv('GB2312', 'UTF-8', str_replace('&nbsp;','',$cong))=="丛书名"){
					//有丛书
					$data['book_author']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.show_info_right ', 7)->find('.c_green', 0)->innertext));
					  //出版社
				    $data['book_publiser']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.show_info_right ', 8)->find('.c_green', 0)->innertext));
				    //出版时间
				    $data['book_publishtime']=$html->find('.max_width', 3)->innertext;
				    //ＩＳＢＮ
				    $data['book_code']=$html->find('.max_width', 4)->innertext;
				}else{
					//没丛书
					$data['book_author']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1 a', 0)->innertext));
					//出版社
					if(!is_object($html->find('.t1 ', 1))) {
						continue;
					}
				    $data['book_publiser']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1 ', 1)->find('a', 0)->innertext));
				    //出版时间
				    $book_publishtime=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1', 2)->innertext));
					$data['book_publishtime']=substr($book_publishtime,strrpos($book_publishtime,':')+1);
				    //ＩＳＢＮ
				   	$book_code=iconv('GB2312', 'UTF-8', strip_tags($html->find('.key', 0)->find('li', 9)->innertext));
				    $data['book_code']=substr($book_code,strrpos($book_code,'：')+3);
				}
				//内容简介
				$data['book_summary']=iconv('GB2312', 'UTF-8', strip_tags($html->find('#content-show textarea',0)->innertext));
				$data['book_summary']=str_replace(' ','',$data['book_summary']);
				//var_dump($img);//die;
				preg_match_all('/\d+/',$data['book_price'],$data['book_price']);
				$re = M('books')->where("id=$value[id]")->save($data);
			}



			/*else if(!$this->url_exists($picUrl.$value['book_thumnpic'])){//补全书籍小图信息
				$searchUrl="http://search.dangdang.com/?key=".$value['book_name']."&act=input";//当当网搜索图书信息
				$html1 = file_get_html($searchUrl);
				$smallImg = $html1->find('.line1 .pic img',0)->attr;//小图
				$this->GrabImage2($smallImg['src'],$value['book_thumnpic']);
			}*/
		}
		//$this->display('lists');
	}

//查看大图和小图缺少数量
	public function lists2(){

	    $num = 0;
		$picUrl = UPLOAD;
		$books = M('books')->select();
		foreach($books as $key=>$value){
			$tdata=M("tags")->where("bid=$value[id]")->select();
			if(!$this->url_exists($picUrl.$value['book_picimg']) || !$this->url_exists($picUrl.$value['book_thumnpic']) ){
				$num++; 
				$bookids[]=$value['id'];

				$value['canque'] = 2;//缺图片
				if(!$this->url_exists($picUrl.$value['book_picimg'])){
					$value['book_picimg'] = $value['book_code'].'.jpg';
				}
				if(!$this->url_exists($picUrl.$value['book_thumnpic'])){
					$value['book_thumnpic'] = 'm_'.$value['book_code'].'.jpg';
				}
				$re = M('books')->where("id=".$value['id'])->save($value);
			}else if(    empty($value['book_code'])  || empty($value['book_author'])  || empty($value['book_publiser'])
					  || empty($value['book_level']) || empty($value['book_class'])  || empty($value['book_topic']) 
					  || empty($value['book_summary']) || empty($tdata) || empty($value['book_name']) ){
				$num++; 
				$bookids[]=$value['id'];

				$value['canque'] = 1;//缺信息
				$re = M('books')->where("id=".$value['id'])->save($value);
			}else{
				$value['canque'] = 0;
				$re = M('books')->where("id=".$value['id'])->save($value);
			}
		}
		if($num==0){
			$bookids = '0';
		}else{
			$bookids = implode(",",$bookids);
		}
		import('ORG.Util.Page');// 导入分页类
	   	$Page = new Page($num,15);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出
	    $data=M("books")->where("id in($bookids)")->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();

	    $this->assign('type',2);
	    $this->assign('page',$show);
	    $this->assign('data',$data);
	    $this->display();
	}

	//查看大图和小图缺少数量
	public function lists3(){

	    $num = 0;
		$picUrl = UPLOAD;
		$books = M('books')->select();
		foreach($books as $key=>$value){
			$tdata=M("tags")->where("bid=$value[id]")->select();
			if(!$this->url_exists($picUrl.$value['book_picimg']) || !$this->url_exists($picUrl.$value['book_thumnpic']) ){

				$value['canque'] = 2;//缺图片
				$re = M('books')->where("id=".$value['id'])->save($value);
			}else if(    empty($value['book_code'])  || empty($value['book_author'])  || empty($value['book_publiser'])
					  || empty($value['book_level']) || empty($value['book_class'])  || empty($value['book_topic']) 
					  || empty($value['book_summary']) || empty($tdata) || empty($value['book_name']) ){
				$num++; 
				$bookids[]=$value['id'];

				$value['canque'] = 1;//缺信息
				$re = M('books')->where("id=".$value['id'])->save($value);
			}else{
				$value['canque'] = 0;
				$re = M('books')->where("id=".$value['id'])->save($value);
			}
		}
		if($num==0){
			$bookids = '0';
		}else{
			$bookids = implode(",",$bookids);
		}
		import('ORG.Util.Page');// 导入分页类
	   	$Page = new Page($num,15);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出
	    $data=M("books")->where("id in($bookids)")->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();

	    $this->assign('type',2);
	    $this->assign('page',$show);
	    $this->assign('data',$data);
	    $this->display('lists2');
	}

	//下载残缺书籍
	public function downloadCanque(){

		$picUrl = UPLOAD;
		$books = M('books')->where("canque!=0")->select();
		// foreach($books as $key=>$value){
		// 	if(!$this->url_exists($picUrl.$value['book_picimg'])){
		// 		$data[] = $value;
		// 	}
		// }	
	   	$xlsName  = "书单";
	        $xlsCell  = array(
	        array('id','序号'),
	        array('book_name','书名'),
	        array('book_code','书号'),
	        array('book_author','作者'),
	        array('book_translater','译者'),
	        array('book_publiser','出版社'),
	        array('book_publishtime','出版年月'),
	        array('book_price','价格'),
	        array('book_summary','内容简介'),
	        array('book_level','分级'),
	        array('book_link','网络链接'),
	        array('book_class','分类'),
	        array('book_topic','主题'),
	        array('canque','图片'),
	        array('tag1','标签1'),
	        array('tag2','标签2'),
	        array('tag3','标签3'),
	        array('tag4','标签4'),
	        array('tag5','标签5'),
	        array('tag6','标签6'),
	        array('tag7','标签7'),
	        array('tag8','标签8'),
	        array('tag9','标签9'),
	        array('tag10','标签10'),
	        );
	   	foreach($books as $key1=>$val1){
	   		if($val1['canque']==2){
	   			$books[$key1]['canque'] = '缺图片';
	   		}
	   		$tdata=M("tags")->where("bid=$val1[id]")->select();
	   		if(!empty($tdata)){
	   			foreach ($tdata as $key2=>$val2){
	   				$books[$key1]['tag'.($key2+1)]=$val2['tag_name'];	
	   			}
	   		}
	   	}
	    $this->exportExcel($xlsName,$xlsCell,$books);
	}

	public function GrabImage2($url,$filename="") {
		if($url=="") 
			return false;
		$ext=strrchr($url,".");
		if($ext!=".gif" && $ext!=".jpg" && $ext!=".png") 
			return false;
		if($filename=="") {
			$filename=date("YmdHis").$ext;
		}

		ob_start();
		readfile($url);
		$img = ob_get_contents();
		ob_end_clean();
		$size = strlen($img);

		$fp2=@fopen('./Upload/picimg/'.$filename, "a");
		//var_dump($fp2);die;
		fwrite($fp2,$img);
		fclose($fp2);
		return $filename;
	}


	//抓取当当
	public function grabdangdang(){
		if($_POST){
			header("Content-type:text/html;charset=utf-8");
$url = I("url");
vendor("Dom.simple_html_dom");
 	//include('.php');
	$html = file_get_html($url);    

//判断有没有丛书
$cong=$html->find('.book_messbox .clearfix .show_info_left', 0)->innertext;

$data=array();


    // 当当价
	$data['book_price']=$html->find('#dd-price', 0)->innertext;
	
	///图书名称
   $data['book_name']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.name_info h1', 0)->innertext));
  //作     者
  if( iconv('GB2312', 'UTF-8', str_replace('&nbsp;','',$cong))=="丛书名"){
  //	echo 123;
	//有丛书
	$data['book_author']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.show_info_right ', 7)->find('.c_green', 0)->innertext));
	  //出版社
    $data['book_publiser']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.show_info_right ', 8)->find('.c_green', 0)->innertext));
    //出版时间
    $data['book_publishtime']=$html->find('.max_width', 3)->innertext;
    //ＩＳＢＮ
    $data['book_code']=$html->find('.max_width', 4)->innertext;
}else{
	//没丛书
	 $data['book_author']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1 a', 0)->innertext));
	   //出版社
     $data['book_publiser']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1 ', 1)->find('a', 0)->innertext));
    //出版时间
   $book_publishtime=iconv('GB2312', 'UTF-8', strip_tags($html->find('.t1', 2)->innertext));
	 $data['book_publishtime']=substr($book_publishtime,strrpos($book_publishtime,':')+1);
    //ＩＳＢＮ
   	$book_code=iconv('GB2312', 'UTF-8', strip_tags($html->find('.key', 0)->find('li', 9)->innertext));
   $data['book_code']=substr($book_code,strrpos($book_code,'：')+3);
}
$img=$html->find('#largePicDiv #largePic',0)->attr;
//下载图片到本地
$data['book_picimg']=iconv('GB2312', 'UTF-8', $this->GrabImage($img['src']));
//内容简介
$data['book_summary']=iconv('GB2312', 'UTF-8', strip_tags($html->find('.descrip #content-show',1)->innertext));
$data['book_name']=str_replace(' ','',$data['book_name']);
$data['book_summary']=str_replace(' ','',$data['book_summary']);
//var_dump($img);//die;
preg_match_all('/\d+/',$data['book_price'],$data['book_price']);

$html->clear();

$this->assign('data',$data);
$this->assign('url',$url);
//全部分类
//$tdata=M("booktype")->select();
//$this->assign('tdata',$tdata);


$class=M("bookclass")->select();
			$this->assign('class',$class);
		$topics=M("booktopic")->select();
			$this->assign('topics',$topics);

        $this->display('dddisplay');
		}else{
		$this->display();
	}
	}
//http://img3x2.ddimg.cn/70/2/23811352-2_w_1.jpg
public function GrabImage($url,$filename="") {
if($url=="") return false;
$ext=strrchr($url,".");
if($ext!=".gif" && $ext!=".jpg" && $ext!=".png") return false;
if($filename=="") {
	$filename=date("YmdHis").$ext;
}

ob_start();
readfile($url);
$img = ob_get_contents();
ob_end_clean();
$size = strlen($img);

$fp2=@fopen('./Upload/picimg/'.$filename, "a");
//var_dump($fp2);die;
fwrite($fp2,$img);
fclose($fp2);
$filename2 = 'm_'.$filename;
$this->imagepress('./Upload/picimg/'.$filename2,$ext);
return $filename;
} 


//将图片生成缩略图（经测验，word中图片尺寸为190*230显示差不多）
function imagepress($filepath,$ext,$new_width=190,$new_height=230){
	//var_dump($filepath);die;
    // 图片类型
    if($ext==".jpg"){
    header('Content-Type: image/jpeg');
    }
    if($ext==".png"){
        header('Content-Type: image/png');
    }
    // 获得新的图片大小
    list($width, $height) = getimagesize($filepath);
    //     echo $width;
    //     echo $height;
    //     $new_width=$width*$percent;
    //     $new_height=$height*$percent;
    //     echo $new_width;
    //     echo $new_height;
    // 重新取样
    $image_p = imagecreatetruecolor($new_width, $new_height);
    if($width!=$new_width || $height!=$new_height){
        if($ext==".jpg"){
    $image = imagecreatefromjpeg($filepath);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    // 输出
    imagejpeg($image_p,$filepath);
        }
        if($ext==".png"){
            $image = imagecreatefrompng($filepath);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            // 输出
            imagepng($image_p,$filepath);
        }
         
    }
  //  return imagejpeg($image_p, null, 100);
}

//高级搜索
public  function gsearch(){
	if($_POST || $_GET['p']){
		
		 import('ORG.Util.Page');// 导入分页类
    $model=new Model();
	
		$book_level=I("book_level");
		$sql="";
		if(!empty($book_level)){
	    $sql.=" and book_level=$book_level";		
		}
		$book_class=I("book_class");
		if($book_class!='0'){
		 $sql.=" and book_class='$book_class'";		
		
		}
	    $book_topic=I("book_topic");
		if($book_topic!='0'){
		 $sql.=" and book_topic='$book_topic'";			
		}
		$tags=I("tags");
		if($tags!=''){

$sqls1="SELECT count(*) as num FROM books WHERE id in (SELECT DISTINCT bid FROM tags WHERE tag_name='$tags') $sql";
       $counts = $model->query($sqls1);// 查询满足要求的总记录数 $map表示查询条件
	 $count=$counts[0]['num'];
   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
   	$show = $Page->show();// 分页显示输出
	$sqls="SELECT * FROM books WHERE id in (SELECT DISTINCT bid FROM tags WHERE tag_name='$tags') $sql order by createtime desc limit $Page->firstRow,$Page->listRows";
        $data=$model->query($sqls);
       // echo $sqls;
		}else{
			 $count = M("books")->where("1=1 {$sql}")->count();// 查询满足要求的总记录数 $map表示查询条件
			 
   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
   	$show = $Page->show();// 分页显示输出
		$data=M("books")->where("1=1 $sql")->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();	
		//echo M("books")->getlastsql();
		}
		$class=M("bookclass")->select();
			$this->assign('class',$class);
		$topics=M("booktopic")->select();
			$this->assign('topics',$topics);
		  $this->assign('data',$data);
    $this->assign('page',$show);// 赋值分页输出
		$this->assign('type',2);
		$this->assign('tags',$tags);
		$this->assign('book_class',$book_class);
		$this->assign('book_level',$book_level);
		$this->assign('book_topic',$book_topic);
		$this->display();
	}else{
		$class=M("bookclass")->select();
			$this->assign('class',$class);
		$topics=M("booktopic")->select();
			$this->assign('topics',$topics);
		$this->assign('type',1);
		$this->display();
	}
	
}

   public function download(){
   	if($_POST){
   		$book_level=I("book_level");
		$sql="";
		if(!empty($book_level)){
	    $sql.=" and book_level=$book_level";		
		}
		$book_class=I("book_class");
		if($book_class!='0'){
		 $sql.=" and book_class='$book_class'";		
		
		}
	    $book_topic=I("book_topic");
		if($book_topic!='0'){
		 $sql.=" and book_topic='$book_topic'";			
		}
		$tags=I("tags");
		if($tags!=''){
	$sqls="SELECT * FROM books WHERE id in (SELECT DISTINCT bid FROM tags WHERE tag_name='$tags') $sql order by createtime desc";
        $data=$model->query($sqls);
       // echo $sqls;
		}else{
		$data=M("books")->where("1=1 $sql")->order('createtime desc')->select();	
		//echo M("books")->getlastsql();
		}
   	$xlsName  = "书单";
        $xlsCell  = array(
        array('id','序号'),
        array('book_name','书名'),
        array('book_code','书号'),
        array('book_author','作者'),
        array('book_translater','译者'),
        array('book_publiser','出版社'),
        array('book_publishtime','出版年月'),
        array('book_price','价格'),
        array('book_summary','内容简介'),
        array('book_level','分级'),
        array('book_link','网络链接'),
        array('book_class','分类'),
        array('book_topic','主题'),
        array('tag1','标签1'),
        array('tag2','标签2'),
        array('tag3','标签3'),
        array('tag4','标签4'),
        array('tag5','标签5'),
        array('tag6','标签6'),
        array('tag7','标签7'),
        array('tag8','标签8'),
        array('tag9','标签9'),
        array('tag10','标签10'),
        );
   	foreach($data as $keys=>$val){
   		$tdata=M("tags")->where("bid=$val[id]")->select();
   		if(!empty($tdata)){
   		foreach ($tdata as $key=>$val){
   		$data[$keys]['tag'.($key+1)]=$val['tag_name'];	
   		}
   		}
   		}
   		
   		  $this->exportExcel($xlsName,$xlsCell,$data);
   	}
   	
	 //  print_r($_POST);
	   
	   }

	   
	   //导出
	public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName =$xlsTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
       
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
      //  $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-type:application/vnd.ms-excel"); 
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }


//批量删除
public function dellists(){
	$data = array();
		$nidArr = I('id');
		if(is_array($nidArr)) {
			$nidStr = implode(',', $nidArr);
			
			$picdata=M('books') -> where('find_in_set(`id`,"'.$nidStr.'")')->Field('book_picimg')->select();
			foreach ($picdata as $key=>$val){
			if($val['book_picimg']!=""){
			    unlink('./Upload/picimg/'.$val['book_picimg']);
			    unlink('./Upload/picimg/m_'.$val['book_picimg']);
			}
			}
			$delReturn = M('books') -> where('find_in_set(`id`,"'.$nidStr.'")') -> delete();
			// dump(M('News'));
			if($delReturn) {
				$data['status'] = '1';
			} else {
				$data['status'] = '0';
			}
		} else {
			$data['status'] = '0';
		}
		$this -> ajaxReturn($data);
	}

	public function partdel(){
		$start = $_POST['startpage'];
		$end = $_POST['endpage'];
		$startnum = ($start - 1)*15;
		$countnum = ($end-$start+1)*15;

		import('ORG.Util.Page');// 导入分页类
		$count = M("books")->count();// 查询满足要求的总记录数 $map表示查询条件
		$Page = new Page($count,15);// 实例化分页类 传入总记录数
		$bookids=M("books")->order('createtime desc')->limit($startnum.','.$countnum)->getField('id',true);
	    $bookids = implode(',',$bookids);
	    if($bookids == null){
	    	$bookids = 0;
	    }
	    $picdata=M('books') -> where("id in ($bookids)")->Field('book_picimg')->select();
	    //var_dump($picdata);die;
		foreach ($picdata as $key=>$val){
			if($val['book_picimg']!=""){
			    unlink('./Upload/picimg/'.$val['book_picimg']);
			    unlink('./Upload/picimg/m_'.$val['book_picimg']);
			}
		}
	    $re = M('books')->where("id in ($bookids)")->delete();
	    if($re == false){
	    	$this->error('部分删除失败',U('lists'));
	    }else{
	    	$this->success('部分删除成功');
	    }
	}


   //将目前图书的所有缩略图由尺寸350*350变为190*230
   public function updatethunmsize(){
       $picdata=M("books")->where(array('book_thumnpic'=>array('neq','')))->field("book_thumnpic")->select();
       foreach($picdata as $key=>$val){
           $this->imagepress('./Upload/picimg/'.$val['book_thumnpic'],substr($val['book_thumnpic'],-4));
           
       }
        
       
   }
	//生成缩略图
	public function addthumnpic(){
		$id=I("id");
		$re=M("books")->where("id=$id")->find();
		$picimg=$re['book_picimg'];
		import('ORG.Util.Image.ThinkImage');
		define('THINKIMAGE_THUMB_SCALING',   1); //常量，标识缩略图等比例缩放类型 
		//使用GD库来处理1.gif图片
//		$img = new ThinkImage(THINKIMAGE_GD, "./Upload/picimg/$picimg"); 
//		//将图片裁剪为440x440并保存为corp.gif
//		$img->crop(190, 230)->save("./Upload/picimg/m_$picimg");
		$image = new ThinkImage();
		$image->open("./Upload/picimg/$picimg");
		// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
		$image->thumb(190, 230,1)->save("./Upload/picimg/m_$picimg");
		
		// 按照原图的比例生成一个最大为190*230的缩略图并保存为thumb.jpg
		$savethumnpic['book_thumnpic']='m_'.$picimg;
		$addthumnpics=M("books")->where("id=$id")->save($savethumnpic);
		if($addthumnpics==true){
			echo 1;
		}else{
			echo 2;
		}
	}
	
}
?>