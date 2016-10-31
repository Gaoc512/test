<?php

vendor('tcpdf.tcpdf');
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$image_file = APP_PATH.'Tpl/Admin/Public/img/'.'bg-11.jpg';
		$this->Image($image_file, 27, 8, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('simfang','', 13);
		// Title
		//$this->Cell(0, 15, '小学生阅读能力评测报告', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->MultiCell($w, $h, '小', $border=0, $align='J', $fill=0, $ln=1, $x=80, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		$this->MultiCell($w, $h, '学', $border=0, $align='J', $fill=0, $ln=1, $x=87, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		$this->MultiCell($w, $h, '生', $border=0, $align='J', $fill=0, $ln=1, $x=94, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		$this->MultiCell($w, $h, '个', $border=0, $align='J', $fill=0, $ln=1, $x=101, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		$this->MultiCell($w, $h, '性', $border=0, $align='J', $fill=0, $ln=1, $x=108, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		$this->MultiCell($w, $h, '化', $border=0, $align='J', $fill=0, $ln=1, $x=115, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		$this->MultiCell($w, $h, '书', $border=0, $align='J', $fill=0, $ln=1, $x=122, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		$this->MultiCell($w, $h, '单', $border=0, $align='J', $fill=0, $ln=1, $x=129, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
		$this->Line(27,15,182,15);
	}

	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 10);

		$pagenumtxt = $this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();

		$this->Cell(172, 0, $pagenumtxt, 'C', 0, 'C');
	}

	//个性化书单的输出内容设置
	public function pdf_set($sdata,$wenzi1,$wenzi2,$wenzi3,$project,$rbooks,$tbooks){

		// add a page
		$this->SetPrintHeader(false);
		$this->SetPrintFooter(false);
		$this->startPageGroup();
		$this->AddPage();

		$this ->SetFont( 'droidsansfallback' , '' ,21);

		$horizontal_alignments = array('L', 'C', 'R');
		$fitbox = $horizontal_alignments[0].' ';
		$fitbox[1] = $vertical_alignments[0];

		$this->Rect(15, 25, 27, 27, 'F', array(), array(255,255,255));
		$this->Image('http://106.38.65.206:8010/App/Tpl/Admin/Public/img/bg-9.jpg', 15, 25, 27, 27, 'JPG', '', '', false, 450, '', false, false, 0, $fitbox, false, false);

		$this->Rect(15, 250, 35, 20, 'F', array(), array(255,255,255));
		$this->Image('http://106.38.65.206:8010/App/Tpl/Admin/Public/img/bg-10.jpg', 15, 250, 30 ,15, 'JPG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);

		$this->Rect(65, 115, 155, 155, 'F', array(), array(255,255,255));
		$this->Image('http://106.38.65.206:8010/App/Tpl/Admin/Public/img/bg-1.jpg', 65, 115, 150, 150, 'JPG', '', '', false, 450, '', false, false, 0, $fitbox, false, false);

		$x1 = 17;	
		$this->SetTextColor(0, 0, 0, 100);
		$this->Text($x1,115,'生');	$this->Text($x1,125,'命');	$this->Text($x1,135,'教');	$this->Text($x1,145,'育');
		$this->Text($x1,160,'人');	$this->Text($x1,170,'与');	$this->Text($x1,180,'自');	$this->Text($x1,190,'然');
		$this->Text($x1,205,'梦');	$this->Text($x1,215,'想');

		$x2 = 33;
		$this->Text($x2,115,'爱');
		$this->Text($x2,130,'美');	$this->Text($x2,140,'德');	$this->Text($x2,150,'成');	$this->Text($x2,160,'长');
		$this->Text($x2,175,'传');	$this->Text($x2,185,'统');	$this->Text($x2,195,'文');	$this->Text($x2,205,'化');

		$this ->SetFont( 'droidsansfallback' , '' ,45);
		$this->SetTextColor(240, 208, 0);
		$this->Text(62,72,'小学生');
		$this->Text(62,90,'个性化书单');

		$this ->SetFont( 'droidsansfallback' , '' ,20);
		$this->SetTextColor(0, 0, 0, 100);
		$this->Text(70,130,'姓名：'.$sdata['name']);
		$this->Text(70,146,'学校：'.$sdata['schoolname']);
		$this->Text(70,162,'班级：'.$sdata['grade'].$sdata['class'].'班');
		$this->Text(70,178,'日期：'.date('Y-m-d',time($reportbooks['createtime'])));

		$this ->SetFont( 'simfang' , '' ,21);
		$this->MultiCell($w, $h, $project, $border=0, $align='J', $fill=0, $ln=1, $x=62, $y=30, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);

		
		$this->startPageGroup();
		$this->SetPrintHeader(true);
		$this->AddPage();
		$this->SetPrintFooter(true);

		$this ->SetFont( 'simhei' , '' ,17);
		$dear = '亲爱的'.$sdata['name'].'同学：';
		$this->MultiCell($w, $h, $dear, $border=0, $align='J', $fill=0, $ln=1, $x=25, $y=30, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);


		$this ->SetFont( 'simkai' , '' ,10);
		$html = '<div style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:20px;">
			<br />&nbsp;&nbsp;&nbsp;您好！通过这个小测试，我们更加了解你的阅读兴趣！<br /><br />
			&nbsp;&nbsp;&nbsp;我们发现你最喜欢'.$wenzi1['name'].'，'.$wenzi1['content'].'<br /><br />
			&nbsp;&nbsp;&nbsp;我们还发现你比较喜欢'.$wenzi2['name'].'，'.$wenzi2['content'].'<br /><br />
			&nbsp;&nbsp;&nbsp;最后我们发现你对'.$wenzi3['name'].'也感兴趣，'.$wenzi3['content'].'<br /><br />';
		if($sdata['grade']=="一年级"||$sdata['grade']=="二年级"||$sdata['grade']=="三年级"){
			$html.='&nbsp;&nbsp;&nbsp;现在来自这三个世界的朋友们已经来到你身边了，赶快来认识他们吧~';
		}else{
			$html.='&nbsp;&nbsp;&nbsp;现在，快看看有哪些你感兴趣的书正在等着你呢，你是不是已经迫不及待了呢？';	
		}
		$html.='</div>';

		$this->writeHTML($html, true, false, false, false, '');

		$this->Rect(70, 210, 70, 70, 'F', array(), array(255,255,255));
		$this->Image('http://106.38.65.206:8010/App/Tpl/Admin/Public/img/fm2.png', 70, 205, 80 ,80, 'PNG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
		$this->AddPage();


		//推荐图书书单
		$this ->SetFont( 'simhei' , '' ,20);
		$this->SetTextColor(0, 0, 0, 100);
		$this->Text(72,23,'我最感兴趣的图书推荐');
		$x=15;$y=0;
		for($i=0;$i<3;$i++){
			foreach ($rbooks[$i] as $key=>$val){
				if(mb_strlen($val['book_author'])>=40){
					$val['book_author']=msubstr($val['book_author'],0,17);
				}else{
					$val['book_author']=$val['book_author'];  
				}

				if(mb_strlen($val['book_summary'])>=150){
					$val['book_summary']=msubstr($val['book_summary'],0,150);
				}else{
					$val['book_summary']=$val['book_summary'];  
				}
				$val['book_summary'] = str_replace($order, $replace, $val['book_summary']);

				if(empty($val['book_thumnpic'])){
					$val['img']=UPLOAD."fm.png";
				}
				if($this->url_exists(UPLOAD.$val['book_thumnpic'])){
					$val['img']=UPLOAD.$val['book_thumnpic'];
				}else{
					$val['img']=UPLOAD."fm.png";
				}

				$this ->SetFont( 'simhei' , '' ,14);
				$this->Text(25,38+$i*80,'《'.$val['book_name'].'》');
				$this ->SetFont( 'simhei' , '' ,12);
				$this->Text(87,44+$i*80,'作者：');
				$this->Text(87,50+$i*80,'出版社：');
				$this->Text(87,56+$i*80,'主题：');
				$this->Text(87,62+$i*80,'简介：');
				$this->SetFont( 'simfang' , '' ,12);

				$this->Text(103,44+$i*80,$val['book_author']);
				$this->Text(103,50+$i*80,$val['book_publiser']);
				$this->Text(103,56+$i*80,$val['tag_name']);
				
				$this->SetFont( 'simkai' , '' ,12);
				$this->MultiCell(82, 0, $val['book_summary'], $border=0, $align='J', $fill=0, $ln=1, $x=103, $y=62+$i*80, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
				
				$horizontal_alignments = array('L', 'C', 'R');
				$fitbox = $horizontal_alignments[0].' ';
				$fitbox[1] = $vertical_alignments[0];
				$this->Rect(15, 250, 35, 20, 'F', array(), array(255,255,255));
				$type=array('JPG','PNG');
				$this->Image($val['img'], 28, 47+$i*80, 55 ,55, $type, '', '', false, 300, '', false, false, 0, $fitbox, false, false);			
			}

		}
		$this->AddPage();

		for($i=3;$i<12;$i++){
			foreach ($rbooks[$i] as $key=>$val){
				if(mb_strlen($val['book_author'])>=40){
					$val['book_author']=msubstr($val['book_author'],0,17);
				}else{
					$val['book_author']=$val['book_author'];  
				}

				if(mb_strlen($val['book_summary'])>=150){
					$val['book_summary']=msubstr($val['book_summary'],0,145);
				}else{
					$val['book_summary']=$val['book_summary'];  
				}
				$val['book_summary'] = str_replace($order, $replace, $val['book_summary']);

				if(empty($val['book_thumnpic'])){
					$val['img']=UPLOAD."fm.png";
				}
				if($this->url_exists(UPLOAD.$val['book_thumnpic'])){
					$val['img']=UPLOAD.$val['book_thumnpic'];
				}else{
					$val['img']=UPLOAD."fm.png";
				}

				$this ->SetFont( 'simhei' , '' ,14);
				$this->Text(25,30+($i%3)*80,'《'.$val['book_name'].'》');
				$this ->SetFont( 'simhei' , '' ,12);
				$this->Text(87,36+($i%3)*80,'作者：');
				$this->Text(87,42+($i%3)*80,'出版社：');
				$this->Text(87,48+($i%3)*80,'主题：');
				$this->Text(87,54+($i%3)*80,'简介：');
				$this->SetFont( 'simfang' , '' ,12);

				$this->Text(103,36+($i%3)*80,$val['book_author']);
				$this->Text(103,42+($i%3)*80,$val['book_publiser']);
				$this->Text(103,48+($i%3)*80,$val['tag_name']);
				
				$this->SetFont( 'simkai' , '' ,12);
				$this->MultiCell(82, 50, $val['book_summary'], $border=0, $align='J', $fill=0, $ln=1, $x=103, $y=54+($i%3)*80, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
				
				$horizontal_alignments = array('L', 'C', 'R');
				$fitbox = $horizontal_alignments[0].' ';
				$fitbox[1] = $vertical_alignments[0];
				$this->Rect(15, 250, 35, 20, 'F', array(), array(255,255,255));
				$type=array('JPG','PNG');
				$this->Image($val['img'], 28, 39+($i%3)*80, 55 ,55, $type, '', '', false, 300, '', false, false, 0, $fitbox, false, false);

				if(($i+1)%3==0){//每页三本书，满三本后另起一页
					$this->AddPage();
				}			
			}

		}

		//拓展图书书单
		$this->SetFont( 'simhei' , '' ,20);
		$this->Text(85,20,'拓展图书推荐');
		$text="&nbsp;&nbsp;&nbsp;除了你所感兴趣的主题之外，我们还想为你打开一扇窗，让你看到更加丰富多彩的世界，也许在以下这些书籍中你会发现意想不到的惊喜哦！";
		$this->SetFont( 'simkai' , '' ,15);
		$this->MultiCell(162, 20, $text, $border=0, $align='J', $fill=0, $ln=1, $x=25, $y=30, $reseth=true, $stretch=0, $ishtml=true, $autopadding=true, $maxh=0);
				
		for($i=0;$i<3;$i++){
			foreach ($tbooks[$i] as $key=>$val){
				if(mb_strlen($val['book_author'])>=40){
					$val['book_author']=msubstr($val['book_author'],0,17);
				}else{
					$val['book_author']=$val['book_author'];  
				}

				if(mb_strlen($val['book_summary'])>=110){
					$val['book_summary']=msubstr($val['book_summary'],0,110);
				}else{
					$val['book_summary']=$val['book_summary'];  
				}
				$val['book_summary'] = str_replace($order, $replace, $val['book_summary']);

				if(empty($val['book_thumnpic'])){
					$val['img']=UPLOAD."fm.png";
				}
				if($this->url_exists(UPLOAD.$val['book_thumnpic'])){
					$val['img']=UPLOAD.$val['book_thumnpic'];
				}else{
					$val['img']=UPLOAD."fm.png";
				}

				$this ->SetFont( 'simhei' , '' ,14);
				$this->Text(25,35+$i*73+20,'《'.$val['book_name'].'》');
				$this ->SetFont( 'simhei' , '' ,12);
				$this->Text(87,41+$i*73+20,'作者：');
				$this->Text(87,47+$i*73+20,'出版社：');
				$this->Text(87,53+$i*73+20,'主题：');
				$this->Text(87,59+$i*73+20,'简介：');
				$this->SetFont( 'simfang' , '' ,12);

				$this->Text(103,41+$i*73+20,$val['book_author']);
				$this->Text(103,47+$i*73+20,$val['book_publiser']);
				$this->Text(103,53+$i*73+20,$val['tag_name']);
				
				$this->SetFont( 'simkai' , '' ,12);
				$this->MultiCell(82, 40, $val['book_summary'], $border=0, $align='J', $fill=0, $ln=1, $x=103, $y=59+$i*73+20, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
				
				$horizontal_alignments = array('L', 'C', 'R');
				$fitbox = $horizontal_alignments[0].' ';
				$fitbox[1] = $vertical_alignments[0];
				$this->Rect(15, 250, 35, 20, 'F', array(), array(255,255,255));
				$type=array('JPG','PNG');
				$this->Image($val['img'], 28, 44+$i*73+20, 55 ,55, $type, '', '', false, 300, '', false, false, 0, $fitbox, false, false);			
			}

		}	
		$this->AddPage();

		for($i=3;$i<18;$i++){
			foreach ($tbooks[$i] as $key=>$val){
				if(mb_strlen($val['book_author'])>=40){
					$val['book_author']=msubstr($val['book_author'],0,17);
				}else{
					$val['book_author']=$val['book_author'];  
				}

				if(mb_strlen($val['book_summary'])>=150){
					$val['book_summary']=msubstr($val['book_summary'],0,145);
				}else{
					$val['book_summary']=$val['book_summary'];  
				}
				$val['book_summary'] = str_replace($order, $replace, $val['book_summary']);

				if(empty($val['book_thumnpic'])){
					$val['img']=UPLOAD."fm.png";
				}
				if($this->url_exists(UPLOAD.$val['book_thumnpic'])){
					$val['img']=UPLOAD.$val['book_thumnpic'];
				}else{
					$val['img']=UPLOAD."fm.png";
				}

				$this ->SetFont( 'simhei' , '' ,14);
				$this->Text(25,30+($i%3)*80,'《'.$val['book_name'].'》');
				$this ->SetFont( 'simhei' , '' ,12);
				$this->Text(87,36+($i%3)*80,'作者：');
				$this->Text(87,42+($i%3)*80,'出版社：');
				$this->Text(87,48+($i%3)*80,'主题：');
				$this->Text(87,54+($i%3)*80,'简介：');
				$this->SetFont( 'simfang' , '' ,12);

				$this->Text(103,36+($i%3)*80,$val['book_author']);
				$this->Text(103,42+($i%3)*80,$val['book_publiser']);
				$this->Text(103,48+($i%3)*80,$val['tag_name']);
				
				$this->SetFont( 'simkai' , '' ,12);
				$this->MultiCell(82, 50, $val['book_summary'], $border=0, $align='J', $fill=0, $ln=1, $x=103, $y=54+($i%3)*80, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
				
				$horizontal_alignments = array('L', 'C', 'R');
				$fitbox = $horizontal_alignments[0].' ';
				$fitbox[1] = $vertical_alignments[0];
				$this->Rect(35, 250, 35, 20, 'F', array(), array(255,255,255));
				$type=array('JPG','PNG');
				$this->Image($val['img'], 28, 39+($i%3)*80, 55 ,55, $type, '', '', false, 300, '', false, false, 0, $fitbox, false, false);			
			}
			if(($i+1)%3==0 && $i!=17){//每页三本书，满三本后另起一页
				$this->AddPage();
			}	

		}
	}

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
}

class ReportAction extends Action {

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

	public function index(){
		import('ORG.Util.Page');// 导入分页类
		$count = M("test")->where($sql)->count();// 查询满足要求的总记录数 $map表示查询条件
	   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出
	    $data=M("test")->where($sql)->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
	    //echo M("books")->getlastsql();
	    $this->assign('data',$data);
	    $this->assign('page',$show);// 赋值分页输出
	    $this->display();
	}

	public function school(){
		import('ORG.Util.Page');// 导入分页类

		$tid = $_GET['tid'];
		$testname = M('test')->where("id=".$tid)->getField('name');
		if($_POST['search']){
			$item = $_POST['search'];

			$count = M('test_school')
				->field("test_school.*")
				->join("school on test_school.schid=school.id")
				->where("(school.schoolpy like '%$item%' or school.schoolfirstpy like '%$item%' or school.schoolname like '%$item%') and test_school.tid = $tid")
				->count();
			$Page = new Page($count,15);// 实例化分页类 传入总记录
			$data = M('test_school')
				->field("test_school.*")
				->join("school on test_school.schid=school.id")
				->where("(school.schoolpy like '%$item%' or school.schoolfirstpy like '%$item%' or school.schoolname like '%$item%') and test_school.tid = $tid")
				->limit($Page->firstRow.','.$Page->listRows)
				->select();
			$show = $Page->show();// 分页显示输出
		}else{
			$count = M("test_school")->where("tid=".$tid)->count();// 查询满足要求的总记录数 $map表示查询条件
			$Page = new Page($count,15);// 实例化分页类 传入总记录
			$data=M("test_school")->where("tid=".$tid)->limit($Page->firstRow.','.$Page->listRows)->select();
			$show = $Page->show();// 分页显示输出
		}
	    foreach($data as $key=>$value){
	    	$data[$key]['testname'] = $testname;
	    	$data[$key]['schoolname'] = M('school')->where("id=".$data[$key]['schid'])->getField('schoolname');
	    	if($value['status']==0){
				$data[$key]['download'] = '否';
			}else{
				$data[$key]['download'] = '是';
			}
	    }
	    //var_dump($data);die;
	    //echo M("books")->getlastsql();
	    $this->assign('data',$data);
	    $this->assign('page',$show);// 赋值分页输出
	    $this->assign('tid',$tid);
	    $this->display();
	}

	public function downloadControl(){
		$id=$_POST['id'];
		$data = M('test_school')->where("id=$id")->find();
		if($data['status']==1){
			$data['status'] = 0;
			$re = M('test_school')->where("id=$id")->save($data);
		}else if ($data['status']==0){
			$data['status'] = 1;
			$re = M('test_school')->where("id=$id")->save($data);
		}
		if($re){ 
			$msg = "操作成功";
		}else{
			$msg = "操作失败";
		}
		echo $msg;
	}

	//已测试学生
	public function relist(){
		import('ORG.Util.Page');// 导入分页类

		$tid = $_GET['tid'];
		$schid = $_GET['schid'];
		$search = $_POST['search'];

		if(empty($search)){
			$count = M("bookreports")->where("tid=".$tid." and schid=".$schid)->count();
		   	$sql = "bookreports.tid=".$tid." and bookreports.schid=".$schid;   	
		}else{
			$count = M("bookreports")
				->join('student on student.id=bookreports.stuid')
				->where("bookreports.tid=$tid and bookreports.schid=$schid and (student.stu_code='$search' or student.name='$search')")
				->count();// 查询满足要求的总记录数 $map表示查询条件
		   	$sql = "bookreports.tid=$tid and bookreports.schid=$schid and (student.stu_code='$search' or student.name='$search')";
		}
		// 查询满足要求的总记录数 $map表示查询条件
	   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出

	   	$data = M('bookreports')
	   		//->field("bookreports.*,test.*,school.*");
	   		->field('bookreports.createtime,test.name as testname,school.schoolname,student.name as stuname,student.grade,student.class,student.stu_code,student.id')
	   		->join('test on test.id=bookreports.tid')
	   		->join('school on school.id=bookreports.schid')
	   		->join('student on student.id=bookreports.stuid')
	   		->where($sql)
	   		->limit($Page->firstRow.','.$Page->listRows)
	   		->select();

	    //echo M("books")->getlastsql();
	    $this->assign('data',$data);
	    $this->assign('page',$show);// 赋值分页输出
	    $this->assign('tid',$tid);
	    $this->assign('schid',$schid);
	    $this->display();
	}

	//学校内未测试学生
	public function relist2(){
		import('ORG.Util.Page');// 导入分页类

		$tid = I('tid');
		$schid = I('schid');
		$schoolname = M('school')->where("id=".$schid)->getField('schoolname');
		$testname = M('test')->where("id=".$tid)->getField('name');
		$stuids_tested = M('bookreports')->where("tid=".$tid." and schid=".$schid)->getField('stuid',true);
		$stuids = implode(',',$stuids_tested);
		if($stuids == null){
			$stuids = '0';
		}
		$count = M("student")->where("id not in (".$stuids.") and sch_id=".$schid)->count();// 查询满足要求的总记录数 $map表示查询条件
	   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出
	   	$data = M('student')->where("id not in (".$stuids.") and sch_id=".$schid)->limit($Page->firstRow.','.$Page->listRows)->select();
	   	//var_dump($data);
	    //echo M("books")->getlastsql();
	    $this->assign('data',$data);
	    $this->assign('page',$show);// 赋值分页输出
	    $this->assign('schoolname',$schoolname);
	    $this->assign('testname',$testname);
	    $this->assign('tid',$tid);
	    $this->assign('schid',$schid);
	    $this->display();
	}

	//测试内未完成学生
	public function relist3(){
		import('ORG.Util.Page');// 导入分页类

		$tid = I('tid');
		$testname = M('test')->where("id=".$tid)->getField('name');
		$stuids_tested = M('bookreports')->where("id=".$tid)->getField('stuid',true);
		$stuids = implode(',',$stuids_tested);
		if($stuids == null){
			$stuids = '0';
		}
		$test_school = M('test_school')->where("tid=$tid")->getField('schid',true);
		$schids = implode(',',$test_school);
		if($schids == null){
			$schids = '0';
		}

		$count = M("student")->where("id not in (".$stuids.") and sch_id in (".$schids.")")->count();// 查询满足要求的总记录数 $map表示查询条件
	   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出
	   	$data = M('student')
	   		->field("student.*,school.schoolname")
	   		->join("school on student.sch_id=school.id")
	   		->where("student.id not in (".$stuids.") and student.sch_id in (".$schids.")")->limit($Page->firstRow.','.$Page->listRows)->select();

	    $this->assign('data',$data);
	    $this->assign('page',$show);// 赋值分页输出
	    $this->assign('tid',$tid);
	    $this->assign('testname',$testname);
	    $this->display();	
	}
	
	public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName =$xlsTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
       
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        //$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
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
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }
	
	
	
//导出学生信息
public function expUser(){//导出Excel
	 	$tid=$_GET['tid'];
	 	$stuids_tested = M('bookreports')->where("tid=".$tid)->getField('stuid',true);
		$stuids = implode(',',$stuids_tested);
		if($stuids == null){
			$stuids = '0';
		}
	 	if(!$_GET['schid']){
			$test_school = M('test_school')->where("tid=$tid")->getField('schid',true);
			$schids = implode(',',$test_school);
			if($schids == null){
				$schids = '0';
			}
		   	$xlsData = M('student')
		   		->field("student.name as username,school.schoolname as school, student.grade,student.class,student.birthday,student.sex,student.stu_code,student.stu_pwd")
		   		->join("school on student.sch_id=school.id")
		   		->where("student.id not in (".$stuids.") and student.sch_id in (".$schids.")")
		   		->select();
	 	}else{
			$schid = $_GET['schid'];
		   	$xlsData = M('student')
		   		->field("student.name as username,school.schoolname as school, student.grade,student.class,student.birthday,student.sex,student.stu_code,student.stu_pwd")
		   		->join("school on student.sch_id=school.id")
		   		->where("student.id not in (".$stuids.") and student.sch_id=".$schid)
		   		->select();
	 	}

        $xlsName  = "学生信息";
        $xlsCell  = array(
        array('username','姓名'),
        array('school','学校'),
        array('grade','年级'),
        array('class','班级'),
        array('birthday','出生日期'),
        array('sex','性别'),
        array('stu_code','登录账号'),
        array('stu_pwd','密码'),
          
        );

        $this->exportExcel($xlsName,$xlsCell,$xlsData);
         
    }

    //导出学生信息
	public function expShudantongji(){//导出Excel
	 	$tid=$_GET['tid'];
	 	$schid=$_GET['schid'];
	 	$stuids_tested = M('bookreports')->where("tid=$tid and schid=$schid")->getField('stuid',true);
		$stuids = implode(',',$stuids_tested);
		if($stuids == null){
			$stuids = '0';
		}

	   	$xlsData = M('student')
	   		->field("count(*) as count,grade,class")
	   		->group("grade,class")
	   		->where("student.id in (".$stuids.")")
	   		->select();
	   	$class=array();
	   	$grade=array();
	   	foreach($xlsData as $key=>$value){
	   		if(!in_array($value['class'], $class)){
	   			$class[] = $value['class'];
	   		}
	   		if(!in_array($value['grade'], $grade)){
	   			$grade[] = $value['grade'];
	   		}
	   	}
        $xlsName  = "书单数目统计";
        $xlsCell  = array(
	        array('grade','年级'),
	        array('class','班级'),
	        array('count','书单个数'),      
	        );
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
    }

    //导出作答数据信息
	public function expAnswer(){//导出Excel

		$tid = $_GET['tid'];
		$schid = $_GET['schid'];
		$type = $_GET['type'];

		if(empty($schid)){
			$schids = M("test_school")->where("tid=$tid")->getField('schid',true);
			$schids = implode(',',$schids);
			if($schids == null){
				$schids = '0';
			}
			$stuids = M("student")->where("sch_id in ($schids)")->getField('id',true);
		}else{
			$schid = M("test_school")->where("tid=$tid and schid=$schid")->getField('schid');
			$stuids = M("student")->where("sch_id=$schid")->getField('id',true);
			//var_dump($stuids);die;
		}
		$stuids = implode(',',$stuids);
		if($stuids == null){
			$stuids = '0';
		}

		if($type == 1){//low grade			
			$xlsData = M('answer')
					->field("student.name,school.schoolname,student.grade,student.class,student.stu_code,answer.land1,answer.land2,answer.land3,answer.land4,answer.land5,answer.land6")
					->join("student on answer.sid=student.id")
					->join("school on student.sch_id=school.id")
					->where("answer.sid in ($stuids) and tid=$tid")
					->select();
			$xlsCell  = array(
		        array('name','姓名'),
		        array('schoolname','学校'),
		        array('grade','年级'),
		        array('class','班级'),
		        array('stu_code','登录账号'),   
		        array('land1','成长世界'),
		        array('land2','艺术世界'),
		        array('land3','数学世界'),
		        array('land4','诗歌世界'),
		        array('land5','动物世界'),
		        array('land6','自然科学'),
	        );
	        $xlsName  = "低年级学生作答信息";
		}else if($type == 2){// high grade
			$sql="SELECT sum(sore) as total,type,typename,typenames,uid from(SELECT sa.*,s.type,s.typename,s.typenames FROM s_answer sa,`subject` s WHERE uid in ($stuids) and tid=$tid and s.id=sa.sid) a GROUP BY type,uid order by total DESC";
	    	$model=new Model();
	    	$data=$model->query($sql);
	    	//var_dump($data);
	    	$stuid=array();
	    	foreach($data as $key=>$value){
	    		if(!in_array($value['uid'],$stuid)){
	    			$stuid[] = $value['uid'];
	    		}
	    	}
	    	foreach($stuid as $sid){
	    		$item=M('student')
	    			->field("student.name,school.schoolname,student.grade,student.class,student.stu_code")
	    			->join("school on school.id=student.sch_id")
	    			->where("student.id=$sid")->find();
	    		foreach($data as $key=>$value){
	    			if($value['uid']==$sid){
	    				$item[$value['type']]=$value['total'];
	    			}
	    		}
	    		$xlsData[] = $item;
	    	}

			$xlsCell  = array(
		        array('name','姓名'),
		        array('schoolname','学校'),
		        array('grade','年级'),
		        array('class','班级'),
		        array('stu_code','登录账号'),   
		        array('1','我是侦探'),
		        array('2','故事经典'),
		        array('3','我在成长'),
		        array('4','我的榜样'),
		        array('5','我爱自然'),
		        array('6','我爱数学'),
		        array('7','少年创客'),
		        array('8','我爱天文'),
		        array('9','我爱思考'),
		        array('10','我爱中国'),
		        array('11','我爱文艺'),
		        array('12','我爱历史'),
		        array('13','我爱地理'),
		        array('14','我爱诗文'),
		        array('15','奇幻世界'),
	        );
	        $xlsName  = "高年级学生作答信息";
		}

        $this->exportExcel($xlsName,$xlsCell,$xlsData);
    }

    //导出作答数据信息
	public function expAnswerAvg(){//导出Excel

		$tid = $_GET['tid'];
		$schid = $_GET['schid'];
		$type = $_GET['type'];

		if(empty($schid)){
			$schids = M("test_school")->where("tid=$tid")->getField('schid',true);
			$schids = implode(',',$schids);
			if($schids == null){
				$schids = '0';
			}
			$stuids = M("student")->where("sch_id in ($schids)")->getField('id',true);
		}else{
			$schid = M("test_school")->where("tid=$tid and schid=$schid")->getField('schid');
			$stuids = M("student")->where("sch_id=$schid")->getField('id',true);
			//var_dump($stuids);die;
		}
		$stuids = implode(',',$stuids);
		if($stuids == null){
			$stuids = '0';
		}

		if($type == 1){//low grade			
			$data = M('answer')
					->field("student.grade,answer.land1,answer.land2,answer.land3,answer.land4,answer.land5,answer.land6")
					->join("student on answer.sid=student.id")
					->join("school on student.sch_id=school.id")
					->where("answer.sid in ($stuids) and answer.tid=$tid")
					->select();
			$grade=array('一年级','二年级','三年级');
			foreach($grade as $g){
				$count = 0;
				$sum1=0;$sum2=0;$sum3=0;$sum4=0;$sum5=0;$sum6=0;
				foreach($data as $key=>$value){
					if($value['grade']==$g){
						$count++;
						$sum1 += $value['land1'];	$sum2 += $value['land2'];
						$sum3 += $value['land3'];	$sum4 += $value['land4'];
						$sum5 += $value['land5'];	$sum6 += $value['land6'];
					}
				}
				$item['grade'] = $g;
				if($count!=0){
					$item['avg1'] = $sum1/$count;	$item['avg2'] = $sum2/$count;
					$item['avg3'] = $sum3/$count;	$item['avg4'] = $sum4/$count;
					$item['avg5'] = $sum5/$count;	$item['avg6'] = $sum6/$count;
				}else{
					$item['avg1'] = $item['avg2'] = $item['avg3'] = $item['avg4'] = $item['avg5'] = $item['avg6'] = 0;
				}
				$xlsData[] = $item;
			}
			$xlsCell  = array(
		        array('grade','年级'),   
		        array('avg1','成长世界'),
		        array('avg2','艺术世界'),
		        array('avg3','数学世界'),
		        array('avg4','诗歌世界'),
		        array('avg5','动物世界'),
		        array('avg6','自然科学'),
	        );
	        $xlsName  = "低年级作答统计";
		}else if($type == 2){// high grade
			$sql="SELECT sum(sore) as total,type,typename,typenames,uid from(SELECT sa.*,s.type,s.typename,s.typenames FROM s_answer sa,`subject` s WHERE uid in ($stuids) and tid=$tid and s.id=sa.sid) a GROUP BY type,uid order by total DESC";
	    	$model=new Model();
	    	$data=$model->query($sql);
	    	//var_dump($data);
	    	$stuid=array();
	    	foreach($data as $key=>$value){
	    		if(!in_array($value['uid'],$stuid)){
	    			$stuid[] = $value['uid'];
	    		}
	    	}
	    	foreach($stuid as $sid){
	    		$item=M('student')
	    			->field("student.grade")
	    			->join("school on school.id=student.sch_id")
	    			->where("student.id=$sid")->find();
	    		foreach($data as $key=>$value){
	    			if($value['uid']==$sid){
	    				$item[$value['type']]=$value['total'];
	    			}
	    		}
	    		$data[] = $item;
	    	}
	    	$grade=array('四年级','五年级','六年级');
			foreach($grade as $g){
				$count = 0;
				$sum1=0;$sum2=0;$sum3=0;$sum4=0;$sum5=0;
				$sum6=0;$sum7=0;$sum8=0;$sum9=0;$sum10=0;
				$sum11=0;$sum12=0;$sum13=0;$sum14=0;$sum15=0;
				foreach($data as $key=>$value){
					if($value['grade']==$g){
						$count++;
						$sum1 += $value['1'];	$sum2 += $value['2'];	$sum3 += $value['3'];	$sum4 += $value['4'];	$sum5 += $value['5'];
						$sum6 += $value['6'];	$sum7 += $value['7'];	$sum8 += $value['8'];	$sum9 += $value['9'];	$sum10 += $value['10'];
						$sum11 += $value['11'];	$sum12 += $value['12'];	$sum13 += $value['13'];	$sum14 += $value['14'];	$sum15 += $value['15'];
					}
				}
				$item2['grade'] = $g;
				if($count!=0){
					$item2['avg1'] = $sum1/$count;	$item2['avg2'] = $sum2/$count;	$item2['avg3'] = $sum3/$count;	$item2['avg4'] = $sum4/$count;	$item2['avg5'] = $sum5/$count;
					$item2['avg6'] = $sum6/$count;	$item2['avg7'] = $sum7/$count;	$item2['avg8'] = $sum8/$count;	$item2['avg9'] = $sum9/$count;	$item2['avg10'] = $sum10/$count;
					$item2['avg11'] = $sum11/$count;	$item2['avg12'] = $sum12/$count;	$item2['avg13'] = $sum13/$count;	$item2['avg14'] = $sum14/$count;	$item2['avg15'] = $sum15/$count;
				}else{
					$item2['avg1'] = $item2['avg2'] = $item2['avg3'] = $item2['avg4'] = $item2['avg5'] = 0;
					$item2['avg6'] = $item2['avg7'] = $item2['avg8'] = $item2['avg9'] = $item2['avg10'] = 0;
					$item2['avg11'] = $item2['avg12'] = $item2['avg13'] = $item2['avg14'] = $item2['avg15'] = 0;
				}
				$xlsData[] = $item2;
			}

			$xlsCell  = array(
		        array('grade','年级'),
		        array('avg1','我室侦探'),
		        array('avg2','故事经典'),
		        array('avg3','我在成长'),
		        array('avg4','我的榜样'),
		        array('avg5','我爱自然'),
		        array('avg6','我爱数学'),
		        array('avg7','少年创客'),
		        array('avg8','我爱天文'),
		        array('avg9','我爱思考'),
		        array('avg10','我爱中国'),
		        array('avg11','我爱文艺'),
		        array('avg12','我爱历史'),
		        array('avg13','我爱地理'),
		        array('avg14','我爱诗文'),
		        array('avg15','奇幻世界'),
	        );
	        $xlsName  = "高年级学生作答信息";
		}

        $this->exportExcel($xlsName,$xlsCell,$xlsData);
    }

    public function preview(){
    	$stuid=I("stuid");
    	$tid=I("tid");

		//学生数据
		$sdata = M("student")
			->field('student.*,school.schoolname as schoolname')
			->join("school on student.sch_id=school.id")
			->where("student.id=".$stuid)
			->find();
		$this->assign('sdata',$sdata);

		//感兴趣书籍 与 推荐书籍数据
		$report = M("bookreports")->where("stuid=$stuid and tid=$tid")->find();
		$countReport = M("bookreports")->where("stuid=$id")->count();
		if($countReport>1){
			$this->error('bookreports表中该学生数据报告个数大于1');
		}
		for($i=1;$i<=12;$i++){
			$key = "reid".$i;
			$rbooks[] = M("books")->where("id=".$report[$key])->find();
		}
		for($i=1;$i<=18;$i++){
			$key = "toid".$i;
			$tbooks[] = M("books")->where("id=".$report[$key])->find();
		}
		$this->assign('rbooks',$rbooks);
		$this->assign('tbooks',$tbooks);

		//书籍种类数据
		$recommendbook = M("recommendbook_log")->where("sid=".$id)->find();
		$wenzi1=M("booktype")->where("id=".$recommendbook[landid1])->find();
		$wenzi2=M("booktype")->where("id=".$recommendbook[landid2])->find();
		$wenzi3=M("booktype")->where("id=".$recommendbook[landid3])->find();
		if($wenzi1[name] == "地球科学"){
			$wenzi1[name] = "地球与科学";
		}else if($wenzi1[name] == "童话世界"){
			$wenzi1[name] = "故事世界";
		}
		if($wenzi2[name] == "地球科学"){
			$wenzi2[name] = "地球与科学";
		}else if($wenzi2[name] == "童话世界"){
			$wenzi2[name] = "故事世界";
		}
		if($wenzi3[name] == "地球科学"){
			$wenzi3[name] = "地球与科学";
		}else if($wenzi3[name] == "童话世界"){
			$wenzi3[name] = "故事世界";
		}
		$this->assign('wenzi1',$wenzi1);
		$this->assign('wenzi2',$wenzi2);
		$this->assign('wenzi3',$wenzi3);
		$this->assign('tid',$tid);

		$this->display();
    }

    
	//下载报告-低年级
	public function download(){
		$id=$_GET['id'];
		$tid=$_GET['tid'];
		if(empty($id)||empty($tid)){
			$this->error('错误操作');
		}
		$sdata = M("student")
			->field('student.*,school.schoolname as schoolname,bookreports.createtime')
			->join('bookreports on bookreports.stuid=student.id')
			->join("school on student.sch_id=school.id")
			->where("student.id=".$id)
			->find();
		$sdata['createtime'] = date('Y-m-d',strtotime($sdata['createtime']));
		$imgpath1=ADMIN_IMG."1.jpg";
		$imgpath2=ADMIN_IMG."2.jpg";
		$imgbg=ADMIN_IMG."fm_word.jpg";
		$imgpath3=ADMIN_IMG."1_03.png";
		$imgpath4=ADMIN_IMG."1_07.png";
		$imgpath5=ADMIN_IMG."1_10.png";
		$imgpath6=ADMIN_IMG."111.png";
		$imgpath7=ADMIN_IMG."222.png";

		header("Content-Type:   application/msword");       
		header("Content-Disposition:   attachment;   filename=".$sdata['name']."__".$sdata['stu_code'].".doc"); //指定文件名称  
		header("Pragma:   no-cache");
		header("Expires:   0");

		$wenzi=M("recommendbook_log")->where("sid=$id and tid=$tid")->find();
		$wenzi1=M("booktype")->where("id=$wenzi[landid1]")->find();
		$wenzi2=M("booktype")->where("id=$wenzi[landid2]")->find();
		$wenzi3=M("booktype")->where("id=$wenzi[landid3]")->find();
		
		if($wenzi1['name'] == "地球科学"){
			$wenzi1['name'] = "地球与科学";
		}else if($wenzi1['name'] == "童话世界"){
			$wenzi1['name'] = "故事世界";
		}
		if($wenzi2['name'] == "地球科学"){
			$wenzi2['name'] = "地球与科学";
		}else if($wenzi2['name'] == "童话世界"){
			$wenzi2['name'] = "故事世界";
		}
		if($wenzi3['name'] == "地球科学"){
			$wenzi3['name'] = "地球与科学";
		}else if($wenzi3['name'] == "童话世界"){
			$wenzi3['name'] = "故事世界";
		}
		
		//获取当前学生报告中的图书
		$reportbooks = M("bookreports")->where("stuid = $id and tid = $tid")->find();
		for($i=0;$i<12;$i++){
			$num=$i+1;
			$rbooks1id[$i]=$reportbooks["reid$num"];
		}	
		for($i=0;$i<18;$i++){
			$num=$i+1;
			$tobooks1id[$i]=$reportbooks["toid$num"];
		}	
		//感兴趣的图书12本
		$rbooksnum=0;
		for($i=0;$i<12;$i++){
			if($rbooks1id[$i] != ""){
				$rbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->limit(1)->select();
				if($rbooks[$i]){
					$rbooksnum++;
				}
			}
		}
//		$rbooksnum = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->count();
				
		//拓展的图书18本
		$tbooksnum=0;
		for($i=0;$i<18;$i++){
			if($tobooks1id[$i] != ""){
				$tbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$tobooks1id[$i]")->limit(1)->select();
				if($tbooks[$i]){
					$tbooksnum++;
				}
			}
		}		
					
		//下载的记录存储到数据库
		$bookreportsid = $reportbooks[0]["id"];
		$datas["downtime"] = date('Y-m-d H:i:s');
		$datas["status"] = 1;
		$changedate = M("bookreports")->where("id=$bookreportsid")->data($datas)->save();

		$html  = '<div style=" width:100%;  ">
<p>&nbsp;</p>
<div style="width:100%; color:#000;">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%; ">
<tr>
<td align="left"  style="width:30%">
		
	<img src='.$imgpath3.' />

</td>
<td colspan="2" align="left"  style="width:70%;">
	<p style="font-family:华文楷体;font-size:28px;">大兴精品阅读工程</p>
</td>
</tr>
<tr>
	<td style="height:130px;" ></td>
</tr>
<tr>
<td align=""  style="width:30%;">

</td>
<td colspan="2" align=""  style="width:70%;">
	<img valign="middle" src='.$imgpath4.' width="100%"/>
</td>
</tr>

<tr>
	<td align="left" rowspan="2"  style="width:30%;">
		<img align="center" src='.$imgpath5.' width="100%"/>
	</td>

	<td valign="top" rowspan="2" style="width:40%; background-color:#FDD000;">
		
		<table style="font-family:宋体;font-size:20px;margin-left:15px;margin-top:25px;">
			<tr>
				<td width="20%">姓名:</td><td align="left" width="60%">'.$sdata['name'].'</td>
			</tr>
			<tr>
				<td valign="top" width="20%">学校:</td><td align="left" width="60%">'.$sdata['schoolname'].'</td>
			</tr>
			<tr>
				<td width="20%">班级:</td><td align="left" width="60%">'.$sdata['grade'].$sdata['class'].'班</td>
			</tr>
			<tr>
				<td width="20%">时间:</td><td align="left" width="60%">'.$sdata['createtime'].'</td>
			</tr>
		</table>
	</td>
	<td valign="bottom" style="width:30%;height:448px; background-color:#FDD000;padding:0px;">		
		<img align="right"   src='.$imgpath6.' style="margin:0px;"/>
	</td>
</tr>
<tr>
<td valign="top"   style="width:20%; height:40px; background-color:#FDD000;padding:0px; ">
	<img align="right"   src='.$imgpath7.' style="margin:0px;"  />
</td>
</tr>
</table>
</div>';
$html .=".";
$html .=chr(12);

$html.='<div style=" width:100%;  margin-top:15px; font-size:20px; color:#000;">
<h1 style="font-size:21px;font-family:华文楷体;font_weight:bold; ">亲爱的'.$sdata['name'].'同学：</h1>
<p style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:20px;">您好！通过这个小测试，我们更加了解你的阅读兴趣！</p>
<p style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:17px;">我们发现你最喜欢'.$wenzi1['name'].'，'.$wenzi1['content'].'</p>
<p style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:17px;">我们还发现你比较喜欢'.$wenzi2['name'].'，'.$wenzi2['content'].'</p>
<p style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:17px;">  最后我们发现你对'.$wenzi3['name'].'也感兴趣，'.$wenzi3['content'].'</p>';
if($test['type']==1){
	$html.='<p style="text-indent:2em;font-family:华文楷体; line-height:1.5;">现在来自这三个世界的朋友们已经来到你身边了，赶快来认识他们吧~</p>';
}else{
	$html.='<p style="text-indent:2em;font-family:华文楷体; line-height:1.5;">现在，快看看有哪些你感兴趣的书正在等着你呢，你是不是已经迫不及待了呢？</p>';	
}
$html.='</div>';
$html.='<div style="width:100%; height:auto; "><img style="width:30%; height:auto; margin-left:25%; vertical-align:central; text-align:center;" src='.$imgpath2.' /></div>';
$html .=".";
$html .=chr(12);
$html .='<div style=" width:100%;  margin-top:15px; font-size:24px; color:#363636;">
<h1 style="text-align:center; font-size:24px; color:#000;font-family:隶书">我最感兴趣的图书推荐</h1>';
$num1=0;
for($i=0;$i<12;$i++){
	foreach ($rbooks[$i] as $key=>$val){
		$html.='<table cellpadding="0" cellspacing="0" border="0" style="height:243.1px">
		<tr><td colspan="2"><font style="line-height:29.33px"></font>';
		if($i>0 && ($i!=3 || $i!=6 ||$i!=9)){
			$html.='<br />';
		}
		$html.='<font style="color:#000; font-size:16px;font-family:宋体;height:16.27px "><b>《'.$val['book_name'].'》</b></font></td></tr>
		<tr style="height:226.8px; >
		<td  style="width:35.3%;">';
		if($val['book_thumnpic']==''){
			$html.='<img src="http://106.38.65.206:8010/Upload/fm.png" style="width:100px; height:100px;" />';
		}else{
			$html.='<img src="http://106.38.65.206:8010/Upload/picimg/'.$val['book_thumnpic'].'" style="width:50%;height:50% " />';
		}
		$html.='
		</td>
		<td style="vertical-align:top;width:64.7%;">
		<b style="font-family:宋体;font_weight:bold;">作者：</b><span style="font-size:15px">';
		//.$val['book_author'].
		if(mb_strlen($val['book_author'])>=40){
			$html.=msubstr($val['book_author'],0,17);
		}else{
			$html.=$val['book_author'];  
		}
		$html .='</span><br />
		<b style="font-family:宋体;font_weight:bold;">出版社：</b>'.$val['book_publiser'].'<br />
		<b style="font-family:宋体;font_weight:bold;">主题：</b>'.$val['tag_name'].'<br />
		<b style="font-family:宋体;font_weight:bold;">简介：</b><span style="font-family:楷体;font-size:14px;text-align:justify;text-justify:inter-ideograph;">';
		//.$val['book_summary'].
		if($i<3){
			if(mb_strlen($val['book_summary'])>=465){
				$html.=msubstr($val['book_summary'],0,150);
			}else{
				$html.=$val['book_summary'];  
			}
		}else{
			if(mb_strlen($val['book_summary'])>=150){
				$html.=msubstr($val['book_summary'],0,145);
			}else{
				$html.=$val['book_summary'];  
			}
		}
		
		$html .= '</span>
		</td>
		</tr>
		</table>';
	}
	$num1++;
	if($num1==3 ||$num1==6 ||$num1==9 ||$num1==12){
		$html .=".";
		$html .=chr(12);
	}else if($num1==$rbooksnum){
		$html .=".";
		$html .=chr(12);
		break;
	}
}


$html.='<div style=" width:100%;  margin-top:15px; font-size:24px; color:#363636;">
<h3 style="text-align:center; font-size:24px; color:#000;">拓展图书推荐</h3>
<h5>除了你所感兴趣的主题之外，我们还想为你打开一扇窗，让你看到更加丰富多彩的世界，也许在以下这些书籍中你会发现意想不到的惊喜哦！</h5>';

	for($i=0;$i<3;$i++){
		foreach ($tbooks[$i] as $key=>$val){
			$html.='<table cellpadding="0" cellspacing="0" border="0" style="height:243.1px">
			<tr><td colspan="2"><font style="line-height:29.33px"></font><font style="color:#000; font-size:16px;font-family:宋体;line-height:16.27px "><b>《'.$val['book_name'].'》</b></td></font></tr>
			<tr style="height:226.8px; >
			<td  style="width:35.3%;">
			';
			if($val['book_thumnpic']==''){
				$html.='<img src="http://106.38.65.206:8010/Upload/fm.png" style="width:100px; height:100px;" />';
			}else{
				$html.='<img src="http://106.38.65.206:8010/Upload/picimg/'.$val['book_thumnpic'].'" style="width:50%;height:50% " />';
			}
			$html.='
			</td>
			<td style="vertical-align:top;width:70%;">
			<b style="font-family:宋体;font_weight:bold;">作者：</b><span style="font-size:15px">';
			//.$val['book_author'].
			if(mb_strlen($val['book_author'])>=40){
				$html.=msubstr($val['book_author'],0,17);
			}else{
				$html.=$val['book_author'];  
			}
			$html.='</span><br />
			<b style="font-family:宋体;font_weight:bold;">出版社：</b>'.$val['book_publiser'].'<br />
			<b style="font-family:宋体;font_weight:bold;">主题：</b>'.$val['tag_name'].'<br />
			<b style="font-family:宋体;font_weight:bold;">简介：</b><span style="font-family:楷体;font-size:14px;text-align:justify;text-justify:inter-ideograph;">';
			//.$val['book_summary'].
			if(mb_strlen($val['book_summary'])>=465){
				$html.=msubstr($val['book_summary'],0,150);
			}else{
				$html.=$val['book_summary'];  
			}
			$html .= '</span>
			</td>
			</tr>
			</table>
		';
		}
	}
	$html .=".";
	$html .=chr(12);
	
	$num2=2;
	for($i=3;$i<18;$i++){
		foreach ($tbooks[$i] as $key=>$val){
			$html.='<table cellpadding="0" cellspacing="0" border="0" style="height:243.1px">
			<tr><td colspan="2"><font style="line-height:29.33px"></font>';
			if($i>0 && ($i!=3 || $i!=6 ||$i!=9 ||$i!=12 ||$i!=15)){
				$html.='<br />';
			}
			$html.='<font style="color:#000; font-size:16px;font-family:宋体;line-height:16.27px "><b>《'.$val['book_name'].'》</b></td></font></tr>
			<tr style="height:226.8px; >
			<td  style="width:35.3%;">';
			if($val['book_thumnpic']==''){
				$html.='<img src="http://106.38.65.206:8010/Upload/fm.png" style="width:100px; height:100px;" />';
			}else{
				$html.='<img src="http://106.38.65.206:8010/Upload/picimg/'.$val['book_thumnpic'].'" style="width:50%;height:50% " />';
			}
			$html.='</div>
			</td>
			<td style="vertical-align:top;width:70%;">
			<b style="font-family:宋体;font_weight:bold;">作者：</b><span style="font-size:15px">';
			//.$val['book_author'].
			if(mb_strlen($val['book_author'])>=40){
				$html.=msubstr($val['book_author'],0,17);
			}else{
				$html.=$val['book_author'];  
			}
			$html.='</span><br />
			<b style="font-family:宋体;font_weight:bold;">出版社：</b>'.$val['book_publiser'].'<br />
			<b style="font-family:宋体;font_weight:bold;">主题：</b>'.$val['tag_name'].'<br />
			<b style="font-family:宋体;font_weight:bold;">简介：</b><span style="font-family:楷体;font-size:14px;text-align:justify;text-justify:inter-ideograph;">';
			//.$val['book_summary'].
			if(mb_strlen($val['book_summary'])>=150){
				$html.=msubstr($val['book_summary'],0,145);
			}else{
				$html.=$val['book_summary'];  
			}
			$html .="<br />";
			$html .= '</span>
			</td>
			</tr>
			</table>';
		}
		$num2++;
		if($num2==5 ||$num2==8 ||$num2==11 ||$num2==14||$num2==17){
			if($num2 ==$tbooksnum ){
				break;
			}
			$html .=".";
			$html .=chr(12);
		}else if($num1==$tbooksnum){
			break;
		}
	}
	$html.='<p style="background:url(http://106.38.65.206:8010/App/Tpl/Admin/Public/img/1.jpg);"></p>';
	

$html.='</div></div>';
		//$html .= '<table>';
		//$html .= '<tr bgcolor="#cccccc"><td align="center">博客</td></tr>';
		//$html .= '<tr bgcolor="#f6f7fa"><td><span style="color:#FF0000;"><strong>PHP将网页代码导出word文档</strong></span></td></tr>';
		//$html .= '<tr><td align="center"><img src="http://localhost/3.jpg"></td></tr>'; //自定义图片文件

		echo  $html;
	}

	
	public function pdfdownload(){
		$id=$_GET['id'];
		$tid=$_GET['tid'];
		if(empty($id)||empty($tid)){
			$this->error('错误操作');
		}
		//删除简介中的换行的参数设置
		$order = array("\r\n", "\n", "\r");   
		$replace = '';

		$sdata = M("student")
			->field('student.*,school.schoolname as schoolname')
			->join("school on student.sch_id=school.id")
			->where("student.id=".$id)
			->find();
		if($sdata['grade'] == '一年级'){
			$sdata['grade'] = '二年级';
		}else if($sdata['grade'] == '二年级'){
			$sdata['grade'] = '三年级';
		}

		$imgpath1="http://106.38.65.206:8010/App/Tpl/Admin/Public/img/1.jpg";
		$imgpath2="http://106.38.65.206:8010/App/Tpl/Admin/Public/img/2.jpg";

		$wenzi=M("recommendbook_log")->where("sid=$id and tid=$tid")->find();
		$wenzi1=M("booktype")->where("id=$wenzi[landid1]")->find();
		$wenzi2=M("booktype")->where("id=$wenzi[landid2]")->find();
		$wenzi3=M("booktype")->where("id=$wenzi[landid3]")->find();
		
		if($wenzi1['name'] == "地球科学"){
			$wenzi1['name'] = "地球与科学";
		}else if($wenzi1['name'] == "童话世界"){
			$wenzi1['name'] = "故事世界";
		}
		if($wenzi2['name'] == "地球科学"){
			$wenzi2['name'] = "地球与科学";
		}else if($wenzi2['name'] == "童话世界"){
			$wenzi2['name'] = "故事世界";
		}
		if($wenzi3['name'] == "地球科学"){
			$wenzi3['name'] = "地球与科学";
		}else if($wenzi3['name'] == "童话世界"){
			$wenzi3['name'] = "故事世界";
		}
		
		//获取当前学生报告中的图书
		$reportbooks = M("bookreports")->where("stuid = $id and tid = $tid")->find();
		for($i=0;$i<12;$i++){
			$num=$i+1;
			$rbooks1id[$i]=$reportbooks["reid$num"];
		}	
		for($i=0;$i<18;$i++){
			$num=$i+1;
			$tobooks1id[$i]=$reportbooks["toid$num"];
		}	
		//感兴趣的图书12本
		$rbooksnum=0;
		for($i=0;$i<12;$i++){
			if($rbooks1id[$i] != ""){
				$rbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->limit(1)->select();
				if($rbooks[$i]){
					$rbooksnum++;
				}
			}
		}
		//var_dump($rbooks);die;
//		$rbooksnum = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->count();
				
		//拓展的图书18本
		$tbooksnum=0;
		for($i=0;$i<18;$i++){
			if($tobooks1id[$i] != ""){
				$tbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$tobooks1id[$i]")->limit(1)->select();
				if($tbooks[$i]){
					$tbooksnum++;
				}
			}
		}
		
		$project = M('student')
			->join("school on school.id=student.sch_id")
			->where("student.id=$id")
			->getfield('school.project');
//		for($i=0;$i<18;$i++){
//			$tbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid")->order("rand()")->limit(1)->select();
//		}
					
		//下载的记录存储到数据库
		$bookreportsid = $reportbooks[0]["id"];
		$datas["downtime"] = date('Y-m-d H:i:s');
		$datas["status"] = 1;
		$changedate = M("bookreports")->where("id=$bookreportsid")->data($datas)->save();


    	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator('PDF_CREATOR');
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->SetAuthor('gaocheng');
		$pdf->SetTitle($sdata['name']);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set margins
		$pdf->SetMargins(25, PDF_MARGIN_TOP, 25);

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		$pdf->pdf_set($sdata,$wenzi1,$wenzi2,$wenzi3,$project,$rbooks,$tbooks);

		$pdf->Output($sdata['stu_code'].'.pdf', 'I');
				

	}


	//批量下载word
	public function downfile($url,$folder,$new_name){

		$destination_folder = './downfolder/';   // 文件夹保存下载文件。必须以斜杠结尾
		//$url = "http://mybook.51growth.com.cn/mybooks/index.php/Report/download/id/1303.html";
		//$date=date("YmdHim").rand(10000,99999);
		$this->Mk_Folder($destination_folder.$folder);
		$newfname = $destination_folder.$folder.$new_name.".doc";
		$file = fopen ($url, "rb");
		if ($file) {
			$newf = fopen (iconv('utf-8','gbk',$newfname), "wb");
			if ($newf)
				while(!feof($file)) {
					fwrite($newf, fread($file, 1024 * 1024 ), 1024 * 1024 );
				}
		}    
		if ($file) {
			fclose($file);
		}
		if ($newf) {
			fclose($newf);
		}
	}

	public function addFileToZip($path,$zip){
	    $handler=opendir($path); //打开当前文件夹由$path指定。
	    while(($filename=readdir($handler))!==false){
	        if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
	            if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
	                $this->addFileToZip($path."/".$filename, $zip);
	            }else{ //将文件加入zip对象
	                $zip->addFile($path."/".$filename);
	            }
	        }
	    }
	    @closedir($path);
	}

	public function pdfpiliang(){
		set_time_limit(0);

		vendor('tcpdf.tcpdf');
    	

	    $tid=I("tid");
	    $schid=I("schid");
	    //删除简介中的换行的参数
		$order = array("\r\n", "\n", "\r");   
		$replace = '';

	    $sdata = M('bookreports')
	   		->field('bookreports.createtime,test.name as testname,school.schoolname,student.name as name,student.grade,student.class,student.stu_code,student.id')
	   		->join('test on test.id=bookreports.tid')
	   		->join('school on school.id=bookreports.schid')
	   		->join('student on student.id=bookreports.stuid')
	   		->where("bookreports.tid=".$tid." and bookreports.schid=".$schid)
	   		->select();
	   	$test = M('test')->where("id=$tid")->getField('name');
	   	$school = M('school')->where("id=$schid")->getField('schoolname');
	   	if(!empty($sdata)){

	   		foreach($sdata as $key=>$value){

	   			if($value['grade'] == '一年级'){
					$value['grade'] = '二年级';
				}else if($value['grade'] == '二年级'){
					$value['grade'] = '三年级';
				}

				$wenzi=M("recommendbook_log")->where("sid=$value[id] and tid=$tid")->find();
				$wenzi1=M("booktype")->where("id=$wenzi[landid1]")->find();
				$wenzi2=M("booktype")->where("id=$wenzi[landid2]")->find();
				$wenzi3=M("booktype")->where("id=$wenzi[landid3]")->find();
				//var_dump($wenzi);
				//var_dump($wenzi1);
				//var_dump($wenzi2);
				
				if($wenzi1['name'] == "地球科学"){
					$wenzi1['name'] = "地球与科学";
				}else if($wenzi1['name'] == "童话世界"){
					$wenzi1['name'] = "故事世界";
				}
				if($wenzi2['name'] == "地球科学"){
					$wenzi2['name'] = "地球与科学";
				}else if($wenzi2['name'] == "童话世界"){
					$wenzi2['name'] = "故事世界";
				}
				if($wenzi3['name'] == "地球科学"){
					$wenzi3['name'] = "地球与科学";
				}else if($wenzi3['name'] == "童话世界"){
					$wenzi3['name'] = "故事世界";
				}
				
				//获取当前学生报告中的图书
				$reportbooks = M("bookreports")->where("stuid = $value[id] and tid = $tid")->find();
				for($i=0;$i<12;$i++){
					$num=$i+1;
					$rbooks1id[$i]=$reportbooks["reid$num"];
				}	
				for($i=0;$i<18;$i++){
					$num=$i+1;
					$tobooks1id[$i]=$reportbooks["toid$num"];
				}	
				//感兴趣的图书12本
				$rbooksnum=0;
				for($i=0;$i<12;$i++){
					if($rbooks1id[$i] != ""){
						$rbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->limit(1)->select();
						if($rbooks[$i]){
							$rbooksnum++;
						}
					}
				}
				//var_dump($rbooks);die;
		//		$rbooksnum = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->count();
						
				//拓展的图书18本
				$tbooksnum=0;
				for($i=0;$i<18;$i++){
					if($tobooks1id[$i] != ""){
						$tbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$tobooks1id[$i]")->limit(1)->select();
						if($tbooks[$i]){
							$tbooksnum++;
						}
					}
				}
				
				$project = M('student')
					->join("school on school.id=student.sch_id")
					->where("student.id=$value[id]")
					->getfield('school.project');
							
				//下载的记录存储到数据库
				$bookreportsid = $reportbooks[0]["id"];
				$datas["downtime"] = date('Y-m-d H:i:s');
				$datas["status"] = 1;
				$changedate = M("bookreports")->where("id=$bookreportsid")->data($datas)->save();

	   			$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator('PDF_CREATOR');
				$pdf->SetPrintHeader(false);
				$pdf->SetPrintFooter(false);
				$pdf->SetAuthor('gaocheng');
				$pdf->SetTitle($value['name']);
				$pdf->SetSubject('TCPDF Tutorial');
				$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

				// set margins
				$pdf->SetMargins(25, PDF_MARGIN_TOP, 25);

				// set default header data
				$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

				// set header and footer fonts
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				// set some language-dependent strings (optional)
				if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
					require_once(dirname(__FILE__).'/lang/eng.php');
					$pdf->setLanguageArray($l);
				}


				$pdf->pdf_set($value,$wenzi1,$wenzi2,$wenzi3,$project,$rbooks,$tbooks);

				$folderZip = './pdfdownfolder/'.$test."/".$school.'/';
				$this->Mk_Folder($folderZip);
				$filepath = 'D:\mybook\wamp\www\mybooks\pdfdownfolder/'.$test."/".$school."/";
				$filepath = iconv('utf-8','gbk',$filepath);
				$path = $filepath.$value['stu_code'].'.pdf';
				//$path = './'.$value['stu_code'].'.pdf';
         
				$pdf->Output($path, 'F');

	   		}
	   	}
	   	ob_end_clean();
		$zip=new ZipArchive();
		//if($zip->open('./downfolder/'.$test.'/'.$test.'_'.$school.'.zip', ZipArchive::OVERWRITE)=== TRUE){
	    if($zip->open('pdfpiliang.zip', ZipArchive::OVERWRITE)=== TRUE){
		    $this->addFileToZip(iconv('utf-8','gbk',$folderZip), $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
		    $zip->close(); //关闭处理的zip文件
		}
		
		$url = "http://106.38.65.206:8010/pdfpiliang.zip";
		$file_name = 'pdfpiliang.zip'; 
	    $file_dir = "http://106.38.65.206:8010/";  
	    $file = @ fopen(iconv('utf-8','gbk',$file_dir.$file_name),"r"); 
	    //var_dump($file);die;
	    if (!$file) { 
		    echo "文件找不到"; 
		}else{ 
		    header("content-type: application/octet-stream"); 
		    header("content-disposition: attachment; filename=" . $file_name); 
		    while (!feof ($file)) { 
		    	echo fread($file,50000); 
		    } 
		    fclose ($file); 
		}

	}


	public function piliang(){

	    set_time_limit(0);
	    $tid=I("tid");
	    $schid=I("schid");
		$imgpath1 = ADMIN_IMG."img/1.jpg";
	    $imgpath2 = ADMIN_IMG."2.jpg";
	    $sdata = M('bookreports')
	   		->field('bookreports.createtime,test.name as testname,school.schoolname,student.name as stuname,student.grade,student.class,student.stu_code,student.id')
	   		->join('test on test.id=bookreports.tid')
	   		->join('school on school.id=bookreports.schid')
	   		->join('student on student.id=bookreports.stuid')
	   		->where("bookreports.tid=".$tid." and bookreports.schid=".$schid)
	   		->select();
	   	$test = M('test')->where("id=$tid")->getField('name');
	   	$school = M('school')->where("id=$schid")->getField('schoolname');
		if(!empty($sdata)){
		    foreach ($sdata as $key=>$val){
	//			
				$folder = $test."/".$school."/".$val['grade']."/".$val['class']."/";

				//$folder = $val['testname'].$val['schoolname'].$val['grade']."/";
				$url = "http://106.38.65.206:8010/index.php/Admin/Report/piliangdownload?id=".$val['id']."&tid=".$tid."&imgpath1=".$imgpath1."&imgpath2=".$imgpath2."&.html";
		     	//echo $url;die;
		     	$this->downfile($url,$folder,$val['stuname']);
		    }
		    //$folderZip = iconv('utf-8','gbk','./downfolder/'.$test."/".$school."/");
		    $folderZip = './downfolder/'.$test."/".$school."/";
		    //var_dump($folderZip);die;
		    $zip=new ZipArchive();
			//if($zip->open('./downfolder/'.$test.'/'.$test.'_'.$school.'.zip', ZipArchive::OVERWRITE)=== TRUE){
		    if($zip->open('piliang.zip', ZipArchive::OVERWRITE)=== TRUE){
			    $this->addFileToZip(iconv('utf-8','gbk',$folderZip), $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
			    $zip->close(); //关闭处理的zip文件
			}
			
			$url = "http://106.38.65.206:8010/piliang.zip";
			$file_name = 'piliang.zip'; 
		    $file_dir = "http://106.38.65.206:8010/";  
		    $file = @ fopen(iconv('utf-8','gbk',$file_dir.$file_name),"r"); 
		    //var_dump($file);die;
		    if (!$file) { 
			    echo "文件找不到"; 
			}else{ 
			    header("content-type: application/octet-stream"); 
			    header("content-disposition: attachment; filename=" . $file_name); 
			    while (!feof ($file)) { 
			    	echo fread($file,50000); 
			    } 
			    fclose ($file); 
			}
			
		}else{
		 	$this->error("没有未生成的文件");
		}
	}


	public function piliangdownload(){
    	header('Content-type:text/html;charset=utf-8');
    	$stuid=I("id");
    	$tid=I("tid");
    	$imgpath1 = I("imgpath1");
    	$imgpath2 = I("imgpath2");
    	$this->assign('imgpath1',$imgpath1);
    	$this->assign('imgpath2',$imgpath2);

		if(empty($stuid) || empty($tid)){
			$this->error('错误操作');
		}
		//学生数据
		$sdata = M('bookreports')
	   		->field('bookreports.createtime,school.schoolname,student.name as stuname,student.grade,student.class,student.stu_code,student.id')
	   		->join('school on school.id=bookreports.schid')
	   		->join('student on student.id=bookreports.stuid')
	   		->where("bookreports.tid=".$tid." and bookreports.stuid=".$stuid)
	   		->find();
		$this->assign('sdata',$sdata);

		//感兴趣书籍 与 推荐书籍数据
		$report = M("bookreports")->where("stuid=$stuid and tid=$tid")->find();

		/*由于之前的bug  导致一份测试数据库里会存储多分书单  暂不知如何解决
		$countReport = M("bookreports")->where("stuid=$id")->count();
		if($countReport>1){
			$this->error('bookreports表中该学生数据报告个数大于1');
		}*/
		for($i=1;$i<=12;$i++){
			$key = "reid".$i;
			$rbooks[] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")
				->where("m.id=t.id and b.id=t.bid and b.id=$report[$key]")
				->limit(1)
				->find();
		}
//		var_dump($rbooks);die;
		for($i=1;$i<=18;$i++){
			$key = "toid".$i;
			$tbooks[] = M("books")->where("id=".$report[$key])->find();
		}
		$this->assign('rbooks',$rbooks);
		$this->assign('tbooks',$tbooks);

		//书籍种类数据
		$recommendbook = M("recommendbook_log")->where("sid=$stuid and tid=$tid")->find();
		$wenzi1=M("booktype")->where("id=".$recommendbook[landid1])->find();
		$wenzi2=M("booktype")->where("id=".$recommendbook[landid2])->find();
		$wenzi3=M("booktype")->where("id=".$recommendbook[landid3])->find();
		if($wenzi1[name] == "地球科学"){
			$wenzi1[name] = "地球与科学";
		}else if($wenzi1[name] == "童话世界"){
			$wenzi1[name] = "故事世界";
		}
		if($wenzi2[name] == "地球科学"){
			$wenzi2[name] = "地球与科学";
		}else if($wenzi2[name] == "童话世界"){
			$wenzi2[name] = "故事世界";
		}
		if($wenzi3[name] == "地球科学"){
			$wenzi3[name] = "地球与科学";
		}else if($wenzi3[name] == "童话世界"){
			$wenzi3[name] = "故事世界";
		}
		$this->assign('wenzi1',$wenzi1);
		$this->assign('wenzi2',$wenzi2);
		$this->assign('wenzi3',$wenzi3);

		$this->display();
    }

    public function wordchuanlian(){
		$tid = I('tid');
		$schid = I('schid');
		$this->assign('schid',$schid);
		$this->assign('tid',$tid);
		$this->display();
	}

	public function pdfchuanlian(){
		$tid = I('tid');
		$schid = I('schid');
		$this->assign('schid',$schid);
		$this->assign('tid',$tid);
		$this->display();
	}

    //按年级下载报告
	public function gradedownload(){

		header('Content-type:text/html;charset=utf-8');
		$imgpath1 = ADMIN_IMG."1.jpg";
	    $imgpath2 = ADMIN_IMG."2.jpg";
	    $imgpath3 = ADMIN_IMG."1_03.png";
		$imgpath4 = ADMIN_IMG."1_07.png";
		$imgpath5 = ADMIN_IMG."1_10.png";
		$imgpath6 = ADMIN_IMG."111.png";
		$imgpath7 = ADMIN_IMG."222.png";
		$tid=I("tid");
		$schid = I("schid");
		$grade=I("grade");

		if(empty($tid) || empty($schid)){
			$this->error('错误操作');
		}

		if($grade == "一年级"){
			$gradenum = 1;
		}else if($grade == "二年级"){
			$gradenum = 2;
		}else if($grade == "三年级"){
			$gradenum = 3;
		}else if($grade == "四年级"){
			$gradenum = 4;
		}else if($grade == "五年级"){
			$gradenum = 5;
		}else if($grade == "六年级"){
			$gradenum = 6;
		}
		$test = M('test')->where("id=$tid")->getField('name');
		$school = M('school')->where("id=$schid")->getField('schoolname');
		$schoolfirstpy = M('school')->where("id=$schid")->getField('schoolfirstpy');
		// $filename = $schoolfirstpy.'_'.$gradenum.'.pdf';
		// var_dump($filename);die;
		//$filename = 'gradedownload.pdf';

		$sdata = M('bookreports')
	   		->field('bookreports.createtime,school.schoolname,student.name as stuname,student.grade,student.class,student.stu_code,student.id')
	   		->join('school on school.id=bookreports.schid')
	   		->join('student on student.id=bookreports.stuid')
	   		->where("bookreports.tid=$tid and bookreports.schid=$schid and student.grade='$grade'")
	   		->select();
	   		//echo M('bookreports')->getlastsql();
	   		//var_dump($grade);
	   		//var_dump($sdata);die;
			//var_dump($students);
		header("Content-Type:   application/msword");       
		header("Content-Disposition:   attachment;   filename=".$test."__".$school."__".$grade.".doc"); //指定文件名称  
		header("Pragma:   no-cache");
		header("Expires:   0");

		//$html ='';
		foreach($sdata as $key1=>$stu){
			$stu['createtime'] = date('Y-m-d',strtotime($stu['createtime']));
			$wenzi=M("recommendbook_log")->where("sid=$stu[id] and tid=$tid")->find();
			$wenzi1=M("booktype")->where("id=$wenzi[landid1]")->find();
			$wenzi2=M("booktype")->where("id=$wenzi[landid2]")->find();
			$wenzi3=M("booktype")->where("id=$wenzi[landid3]")->find();
		
			if($wenzi1['name'] == "地球科学"){
				$wenzi1['name'] = "地球与科学";
			}else if($wenzi1['name'] == "童话世界"){
				$wenzi1['name'] = "故事世界";
			}
			if($wenzi2['name'] == "地球科学"){
				$wenzi2['name'] = "地球与科学";
			}else if($wenzi2['name'] == "童话世界"){
				$wenzi2['name'] = "故事世界";
			}
			if($wenzi3['name'] == "地球科学"){
				$wenzi3['name'] = "地球与科学";
			}else if($wenzi3['name'] == "童话世界"){
				$wenzi3['name'] = "故事世界";
			}
		
			//获取当前学生报告中的图书
			$reportbooks = M("bookreports")->where("stuid = $stu[id] and tid=$tid")->find();
			for($i=0;$i<12;$i++){
				$num=$i+1;
				$rbooks1id[$i]=$reportbooks["reid$num"];
			}	
			for($i=0;$i<18;$i++){
				$num=$i+1;
				$tobooks1id[$i]=$reportbooks["toid$num"];
			}	
			//感兴趣的图书12本
			$rbooksnum=0;
			for($i=0;$i<12;$i++){
				if($rbooks1id[$i] != ""){
					$rbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->limit(1)->select();
					if($rbooks[$i]){
						$rbooksnum++;
					}
				}
			}
	//		$rbooksnum = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->count();
				
			//拓展的图书18本
			$tbooksnum=0;
			for($i=0;$i<18;$i++){
				if($tobooks1id[$i] != ""){
					$tbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$tobooks1id[$i]")->limit(1)->select();
					if($tbooks[$i]){
						$tbooksnum++;
					}
				}
			}
		
	//		for($i=0;$i<18;$i++){
	//			$tbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid")->order("rand()")->limit(1)->select();
	//		}
					
		//下载的记录存储到数据库
			$html  = '<div style=" width:100%;  ">
	<p>&nbsp;</p>
	<div style="width:100%; color:#000;">
	<table cellpadding="0" cellspacing="0" border="0" style="width:100%; ">
	<tr>
	<td align="left"  style="width:30%">
			
		<img src='.$imgpath3.' />

	</td>
	<td colspan="2" align="left"  style="width:70%;">
		<p style="font-family:华文楷体;font-size:28px;">大兴精品阅读工程</p>
	</td>
	</tr>
	<tr>
		<td style="height:130px;" ></td>
	</tr>
	<tr>
	<td align=""  style="width:30%;">

	</td>
	<td colspan="2" align=""  style="width:70%;">
		<img valign="middle" src='.$imgpath4.' width="100%"/>
	</td>
	</tr>

	<tr>
		<td align="left" rowspan="2"  style="width:30%;">
			<img align="center" src='.$imgpath5.' width="100%"/>
		</td>

		<td valign="top" rowspan="2" style="width:40%; background-color:#FDD000;">
			
			<table style="font-family:宋体;font-size:20px;margin-left:15px;margin-top:25px;">
				<tr>
					<td width="20%">姓名:</td><td align="left" width="60%">'.$stu['stuname'].'</td>
				</tr>
				<tr>
					<td valign="top" width="20%">学校:</td><td align="left" width="60%">'.$stu['schoolname'].'</td>
				</tr>
				<tr>
					<td width="20%">班级:</td><td align="left" width="60%">'.$stu['grade'].$stu['class'].'</td>
				</tr>
				<tr>
					<td width="20%">日期:</td><td align="left" width="60%">'.$stu['createtime'].'</td>
				</tr>
			</table>
		</td>
		<td valign="bottom" style="width:30%;height:448px; background-color:#FDD000;padding:0px;">		
			<img align="right"   src='.$imgpath6.' style="margin:0px;"/>
		</td>
	</tr>
	<tr>
	<td valign="top"   style="width:20%; height:40px; background-color:#FDD000;padding:0px; ">
		<img align="right"   src='.$imgpath7.' style="margin:0px;"  />
	</td>
	</tr>
	</table>
	</div>';
	$html .=".";
	$html .=chr(12);

	$html.='
			<div style=" width:100%;  margin-top:15px; font-size:20px; color:#000;">
			<h1 style="font-size:21px;font-family:华文楷体;font_weight:bold; ">亲爱的'.$stu['stuname'].'同学：</h1>
			<p style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:20px;">您好！通过这个小测试，我们更加了解你的阅读兴趣！</p>
			<p style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:20px;">我们发现你最喜欢'.$wenzi1['name'].'，'.$wenzi1['content'].'</p>
			<p style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:20px;">我们还发现你比较喜欢'.$wenzi2['name'].'，'.$wenzi2['content'].'</p>
			<p style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:20px;">  最后我们发现你对'.$wenzi3['name'].'也感兴趣，'.$wenzi3['content'].'</p>';
			if($stu['grade']=="一年级"||$stu['grade']=="二年级"||$stu['grade']=="三年级"){
				$html.='<p style="text-indent:2em;font-family:华文楷体;font-size:20px; line-height:1.5;">现在来自这三个世界的朋友们已经来到你身边了，赶快来认识他们吧~</p>';
			}else{
				$html.='<p style="text-indent:2em;font-family:华文楷体;font-size:20px; line-height:1.5;">现在，快看看有哪些你感兴趣的书正在等着你呢，你是不是已经迫不及待了呢？</p>';	
			}
			$html.='</div>';
			$html.='<div style="width:100%; height:auto; "><img style="width:30%; height:auto; margin-left:25%; vertical-align:central; text-align:center;" src='.$imgpath2.' /></div>';
			$html .=".";
			$html .=chr(12);
			$html .='<div style=" width:100%;  margin-top:15px; font-size:24px; color:#363636;">
			<h1 style="text-align:center; font-size:24px; color:#000;font-family:隶书">我最感兴趣的图书推荐</h1>';
			$num1=0;
			for($i=0;$i<12;$i++){
				foreach ($rbooks[$i] as $key=>$val){
					$html.='<table cellpadding="0" cellspacing="0" border="0" style="height:243.1px">
					<tr><td colspan="2"><font style="line-height:29.33px"></font>';
					if($i>0 && ($i!=3 || $i!=6 ||$i!=9)){
						$html.='<br />';
					}
					$html.='<font style="color:#000; font-size:16px;font-family:宋体;height:16.27px "><b>《'.$val['book_name'].'》</b></font></td></tr>
					<tr style="height:226.8px; >
					<td  style="width:35.3%;">';
					if($val['book_thumnpic']==''){
						$html.='<img src="http://106.38.65.206:8010/Upload/fm.png" style="width:100px; height:100px;" />';
					}else{
						$html.='<img src="http://106.38.65.206:8010/Upload/picimg/'.$val['book_thumnpic'].'" style="width:50%;height:50% " />';
					}
					$html.='
					</td>
					<td style="vertical-align:top;width:64.7%;">
					<b style="font-size:14px; font-family:宋体;font_weight:bold;">作者：</b><span style="font-family:宋体;font-size:14px">';
					//.$val['book_author'].
					if(mb_strlen($val['book_author'])>=40){
						$html.=msubstr($val['book_author'],0,17);
					}else{
						$html.=$val['book_author'];  
					}
					$html .='</span><br />
					<b style="font-size:14px; font-family:宋体;font_weight:bold;">出版社：</b><span style="font-size:14px; font-family:宋体;font_weight:bold;">'.$val['book_publiser'].'</span><br />
					<b style="font-size:14px; font-family:宋体;font_weight:bold;">主题：</b><span style="font-size:14px; font-family:宋体;font_weight:bold;">'.$val['tag_name'].'</span><br />
					<b style="font-size:14px; font-family:宋体;font_weight:bold;">简介：</b><span style="font-family:楷体;font-size:14px;text-align:justify;text-justify:inter-ideograph;">';
					//.$val['book_summary'].
					if($i<3){
						if(mb_strlen($val['book_summary'])>=465){
							$html.=msubstr($val['book_summary'],0,150);
						}else{
							$html.=$val['book_summary'];  
						}
					}else{
						if(mb_strlen($val['book_summary'])>=150){
							$html.=msubstr($val['book_summary'],0,145);
						}else{
							$html.=$val['book_summary'];  
						}
					}
					
					$html .= '</span>
					</td>
					</tr>
					</table>';
				}
				$num1++;
				if($num1==3 ||$num1==6 ||$num1==9 ||$num1==12){
					$html .=".";
					$html .=chr(12);
				}else if($num1==$rbooksnum){
					$html .=".";
					$html .=chr(12);
					break;
				}
			}


			$html.='<div style=" width:100%;  margin-top:15px; font-size:24px; color:#363636;">
			<h3 style="text-align:center; font-size:24px; color:#000;">拓展图书推荐</h3>
			<h5 style="text-indent:2em; line-height:1.5;font-family:华文楷体;font-size:20px;">除了你所感兴趣的主题之外，我们还想为你打开一扇窗，让你看到更加丰富多彩的世界，也许在以下这些书籍中你会发现意想不到的惊喜哦！</h5>';

			for($i=0;$i<3;$i++){
				foreach ($tbooks[$i] as $key=>$val){
					$html.='<table cellpadding="0" cellspacing="0" border="0" style="height:243.1px">
					<tr><td colspan="2"><font style="line-height:29.33px"></font><font style="color:#000; font-size:16px;font-family:宋体;line-height:16.27px "><b>《'.$val['book_name'].'》</b></td></font></tr>
					<tr style="height:226.8px; >
					<td  style="width:35.3%;">
					';
					if($val['book_thumnpic']==''){
						$html.='<img src="http://106.38.65.206:8010/mybooks/Upload/fm.png" style="width:100px; height:100px;" />';
					}else{
						$html.='<img src="http://106.38.65.206:8010/Upload/picimg/'.$val['book_thumnpic'].'" style="width:50%;height:50% " />';
					}
					$html.='
					</td>
					<td style="vertical-align:top;width:70%;">
					<b style="font-size:14px; font-family:宋体;ont_weight:bold;">作者：</b><span style="font-size:14px;font-family:宋体;">';
					//.$val['book_author'].
					if(mb_strlen($val['book_author'])>=40){
						$html.=msubstr($val['book_author'],0,17);
					}else{
						$html.=$val['book_author'];  
					}
					$html.='</span><br />
					<b style="font-family:宋体;font-size:14px;font_weight:bold;">出版社：</b><span style="font-family:宋体;font-size:14px;font_weight:bold;">'.$val['book_publiser'].'</span><br />
					<b style="font-family:宋体;font-size:14px;font_weight:bold;">主题：</b><span style="font-family:宋体;font-size:14px;font_weight:bold;">'.$val['tag_name'].'</span><br />
					<b style="font-family:宋体;font-size:14px;font_weight:bold;">简介：</b><span style="font-family:楷体;font-size:14px;text-align:justify;text-justify:inter-ideograph;">';
					//.$val['book_summary'].
					if(mb_strlen($val['book_summary'])>=465){
						$html.=msubstr($val['book_summary'],0,150);
					}else{
						$html.=$val['book_summary'];  
					}
					$html .= '</span>
					</td>
					</tr>
					</table>
				';
				}
			}
			$html .=".";
			$html .=chr(12);
			
			$num2=2;
			for($i=3;$i<18;$i++){
				foreach ($tbooks[$i] as $key=>$val){
					$html.='<table cellpadding="0" cellspacing="0" border="0" style="height:243.1px">
					<tr><td colspan="2"><font style="line-height:29.33px"></font>';
					if($i>0 && ($i!=3 || $i!=6 ||$i!=9 ||$i!=12 ||$i!=15)){
						$html.='<br />';
					}
					$html.='<font style="color:#000; font-size:16px;font-family:宋体;line-height:16.27px "><b>《'.$val['book_name'].'》</b></td></font></tr>
					<tr style="height:226.8px; >
					<td  style="width:35.3%;">';
					if($val['book_thumnpic']==''){
						$html.='<img src="http://106.38.65.206:8010/mybooks/Upload/fm.png" style="width:100px; height:100px;" />';
					}else{
						$html.='<img src="http://106.38.65.206:8010/Upload/picimg/'.$val['book_thumnpic'].'" style="width:50%;height:50% " />';
					}
					$html.='</div>
					</td>
					<td style="vertical-align:top;width:70%;">
					<b style="font-size:14px;font-family:宋体;font_weight:bold;">作者：</b><span style="font-size:14px;font-family:宋体;">';
					//.$val['book_author'].
					if(mb_strlen($val['book_author'])>=40){
						$html.=msubstr($val['book_author'],0,17);
					}else{
						$html.=$val['book_author'];  
					}
					$html.='</span><br />
					<b style="font-size:14px;font-family:宋体;font_weight:bold;">出版社：</b><span style="font-size:14px;font-family:宋体;font_weight:bold;">'.$val['book_publiser'].'</span><br />
					<b style="font-size:14px;font-family:宋体;font_weight:bold;">主题：</b><span style="font-size:14px;font-family:宋体;font_weight:bold;">'.$val['tag_name'].'</span><br />
					<b style="font-size:14px;font-family:宋体;font_weight:bold;">简介：</b><span style="font-family:楷体;font-size:14px;text-align:justify;text-justify:inter-ideograph;">';
					//.$val['book_summary'].
					if(mb_strlen($val['book_summary'])>=150){
						$html.=msubstr($val['book_summary'],0,145);
					}else{
						$html.=$val['book_summary'];  
					}
					$html .="<br />";
					$html .= '</span>
					</td>
					</tr>
					</table>';
				}
				$num2++;
				if($num2==5 ||$num2==8 ||$num2==11 ||$num2==14||$num2==17){
					if($num2 ==$tbooksnum ){
						break;
					}
					$html .=".";
					$html .=chr(12);
				}else if($num1==$tbooksnum){
					break;
				}
			}
			$html.='<p style="background:url(http://106.38.65.206:8010/App/Tpl/Admin/Public/img/1.jpg);"></p>';

		

			$html.='</div></div>';
		}
		
		//$html .= '<table>';
		//$html .= '<tr bgcolor="#cccccc"><td align="center">博客</td></tr>';
		//$html .= '<tr bgcolor="#f6f7fa"><td><span style="color:#FF0000;"><strong>PHP将网页代码导出word文档</strong></span></td></tr>';
		//$html .= '<tr><td align="center"><img src="http://localhost/3.jpg"></td></tr>'; //自定义图片文件

		echo  $html;

}
	
	public function pdfgradedownload(){

		header('Content-type:text/html;charset=utf-8');
		$tid=I("tid");
		$schid = I("schid");
		$grade = I("grade");
		//删除简介中的换行的参数
		$order = array("\r\n", "\n", "\r");   
		$replace = '';

		if(empty($tid) || empty($schid)){
			$this->error('错误操作');
		}

		$sdata = M('bookreports')
	   		->field('bookreports.createtime,school.schoolname,student.name as name,student.grade,student.class,student.stu_code,student.id')
	   		->join('school on school.id=bookreports.schid')
	   		->join('student on student.id=bookreports.stuid')
	   		->where("bookreports.tid=$tid and bookreports.schid=$schid and student.grade='$grade'")
	   		->select();


		set_time_limit(0);

		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator('PDF_CREATOR');
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(false);
		$pdf->SetAuthor('gaocheng');
		$pdf->SetTitle($sdata['name']);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set margins
		$pdf->SetMargins(25, PDF_MARGIN_TOP, 25);

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		$project = M("school")->where("id=$schid")->getField("project");

		foreach($sdata as $key1=>$stu){

			if($stu['grade'] == '一年级'){
				$stu['grade'] = '二年级';
			}else if($stu['grade'] == '二年级'){
				$stu['grade'] = '三年级';
			}

			$wenzi=M("recommendbook_log")->where("sid=$stu[id] and tid=$tid")->find();
			$wenzi1=M("booktype")->where("id=$wenzi[landid1]")->find();
			$wenzi2=M("booktype")->where("id=$wenzi[landid2]")->find();
			$wenzi3=M("booktype")->where("id=$wenzi[landid3]")->find();
		
			if($wenzi1['name'] == "地球科学"){
				$wenzi1['name'] = "地球与科学";
			}else if($wenzi1['name'] == "童话世界"){
				$wenzi1['name'] = "故事世界";
			}
			if($wenzi2['name'] == "地球科学"){
				$wenzi2['name'] = "地球与科学";
			}else if($wenzi2['name'] == "童话世界"){
				$wenzi2['name'] = "故事世界";
			}
			if($wenzi3['name'] == "地球科学"){
				$wenzi3['name'] = "地球与科学";
			}else if($wenzi3['name'] == "童话世界"){
				$wenzi3['name'] = "故事世界";
			}
		
			//获取当前学生报告中的图书
			$reportbooks = M("bookreports")->where("stuid = $stu[id] and tid=$tid")->find();
			//var_dump($reportbooks);

			for($i=0;$i<12;$i++){
				$num=$i+1;
				$rbooks1id[$i]=$reportbooks["reid$num"];
			}	
			for($i=0;$i<18;$i++){
				$num=$i+1;
				$tobooks1id[$i]=$reportbooks["toid$num"];
			}	
			//感兴趣的图书12本
			$rbooksnum=0;
			for($i=0;$i<12;$i++){
				if($rbooks1id[$i] != ""){
					$rbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$rbooks1id[$i]")->limit(1)->select();
					if($rbooks[$i]){
						$rbooksnum++;
					}
				}
			}
				
			//拓展的图书18本
			$tbooksnum=0;
			for($i=0;$i<18;$i++){
				if($tobooks1id[$i] != ""){
					$tbooks[$i] = M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")->where("m.id=t.id and b.id=t.bid and b.id=$tobooks1id[$i]")->limit(1)->select();
					if($tbooks[$i]){
						$tbooksnum++;
					}
				}
			}

			// ---------------------------------------------------------

			$pdf->pdf_set($stu,$wenzi1,$wenzi2,$wenzi3,$project,$rbooks,$tbooks);
		}


		$pdf->Output('gradedownload.pdf', 'D');

}
	



	//创建问价夹
	public function Mk_Folder($Folder){
	
		if(!is_readable($Folder)){
	
			$this->Mk_Folder( dirname($Folder) );
	
			if(!is_file($Folder)) mkdir(iconv('utf-8','gbk',$Folder),0777);
	
		}
	}
}
?>