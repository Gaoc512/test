<?php

// vendor('tcpdf.tcpdf');
// class MYPDF extends TCPDF {

// 	//Page header
// 	public function Header() {
// 		// Logo
// 		$image_file = APP_PATH.'Tpl/Admin/Public/img/'.'bg-11.jpg';
// 		$this->Image($image_file, 27, 8, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
// 		// Set font
// 		$this->SetFont('simfang','', 13);
// 		// Title
// 		//$this->Cell(0, 15, '小学生阅读能力评测报告', 0, false, 'C', 0, '', 0, false, 'M', 'M');
// 		$this->MultiCell($w, $h, '小', $border=0, $align='J', $fill=0, $ln=1, $x=80, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
// 		$this->MultiCell($w, $h, '学', $border=0, $align='J', $fill=0, $ln=1, $x=87, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
// 		$this->MultiCell($w, $h, '生', $border=0, $align='J', $fill=0, $ln=1, $x=94, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
// 		$this->MultiCell($w, $h, '个', $border=0, $align='J', $fill=0, $ln=1, $x=101, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
// 		$this->MultiCell($w, $h, '性', $border=0, $align='J', $fill=0, $ln=1, $x=108, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
// 		$this->MultiCell($w, $h, '化', $border=0, $align='J', $fill=0, $ln=1, $x=115, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
// 		$this->MultiCell($w, $h, '书', $border=0, $align='J', $fill=0, $ln=1, $x=122, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
// 		$this->MultiCell($w, $h, '单', $border=0, $align='J', $fill=0, $ln=1, $x=129, $y=9, $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
// 		$this->Line(27,15,182,15);
// 	}

// 	public function Footer() {
// 		// Position at 15 mm from bottom
// 		$this->SetY(-15);
// 		// Set font
// 		$this->SetFont('helvetica', 'I', 10);

// 		$pagenumtxt = $this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();

// 		$this->Cell(172, 0, $pagenumtxt, 'C', 0, 'C');
// 	}
// }

class SeniorAction extends CommonAction {

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
	
	//高年级模板
	public function high(){
		$datas=M("subject")->order('rand()')->select();
			
		$this->assign('datas',$datas);
		$this->display();
	}



	public function bookslist(){
		$uid = $_SESSION['uid'];
		$tid = $_SESSION['tid'];
		$schid = $_SESSION['schid'];

		$word1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;现在你看到的是我们为你推荐的书单。请你看一看这些书中有没有你已读过的，如果有请你勾选出来，并点击页面最下方的“重新生成”，最后请点击“下载”下载您的书单，希望它能带你畅游阅读天地。";
		$word2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;现在你看到的是我们为你推荐的书单。请你看一看这些书中有没有你已读过的，如果有请你勾选出来，并点击页面最下方的“重新生成”，最后请点击“完成”，之后我们会通过其它方式将这份书单送到你身边，希望它能带你畅游阅读天地。";
		$status = M('test_school')->where("tid=$tid and schid=$schid")->getfield('status');
		$src = $status ? "/App/Tpl/Index/Public/img/xia.png" : "/App/Tpl/Index/Public/img/wancheng.png";
		$href = $status ? U('Senior/pdfdownload') : U('Senior/over');
		$word = $status ? $word1 : $word2;
		// var_dump($src);
		// var_dump($href);die;

		if($_POST){
			
			$re = M('s_answer')->where("uid=$uid and tid=$tid")->find();
			if($re == false){
				$answer = I("answer");
				foreach($answer as $key=>$val){
					$adddata=array(
						'uid' => $uid,
						'tid' => $tid,
						'sid' => $key,
						'sore' => $val
						);
					M("s_answer")->add($adddata);
				}
			}
			$list = $this->report_generate();
			foreach($list as $key=>$value){
	    		if(!$this->url_exists(UPLOAD.$value['book_picimg'])){
	    			$list[$key]['book_picimg'] = "fm.png";
	    		}
	    	}		
		}else{
			$list = $this->report_generate();
			foreach($list as $key=>$value){
	    		if(!$this->url_exists(UPLOAD.$value['book_picimg'])){
	    			$list[$key]['book_picimg'] = "fm.png";
	    		}
	    	}
		}
		$this->assign('data',$list);
		$this->assign('src',$src);
		$this->assign('href',$href);
		$this->assign('word',$word);
		$this->display();
	}
	

	public function report_generate(){
		$id=$_SESSION['uid'];
		$schid = $_SESSION['schid'];
		$tid = $_SESSION['tid'];
		if($id==''){
			$this->redirect('Index/login');
		} 
		$dataFinished = M("finishedbooks")->where("stuid=$id")->getfield("bookid",true);
		$finishedBooks = implode(',',$dataFinished);
		if($finishedBooks == null){
			$finishedBooks = '0';
		}
		$sdata = M('student')->where("id=$id")->find();

		$sql="SELECT sum(sore) as total,type,typename,typenames from(SELECT sa.*,s.type,s.typename,s.typenames FROM s_answer sa,`subject` s WHERE uid=$id and tid=$tid and s.id=sa.sid) a GROUP BY type order by total DESC";
	    $model=new Model();
	    $data=$model->query($sql);

		$type1=$data[0]['typename'];
		$type2=$data[1]['typename'];
		$type3=$data[2]['typename'];
		$type4=$data[3]['typename'];
		$type5=$data[4]['typename'];
		$type6=$data[5]['typename'];
		$type7=$data[6]['typename'];
		$type8=$data[7]['typename'];
		$type9=$data[8]['typename'];
		$type10=$data[9]['typename'];
		$type11=$data[10]['typename'];
		$type12=$data[11]['typename'];
		$type13=$data[12]['typename'];
		$type14=$data[13]['typename'];
		$type15=$data[14]['typename'];
		if($type1=="我爱诗文"){
			$type1="我爱诗歌";
		}else if($type2=="我爱诗文"){
			$type2="我爱诗歌";
		}else if($type3=="我爱诗文"){
			$type3="我爱诗歌";
		}
		$wenzi1=M("booktype")->where("keyword='$type1'")->find();
		$wenzi2=M("booktype")->where("keyword='$type2'")->find();
		$wenzi3=M("booktype")->where("keyword='$type3'")->find();

		$wdata=array(
			'sid'=>$id,
			'tid'=>$tid,
			'landid1'=>$wenzi1['id'],
			'landid2'=>$wenzi2['id'],
			'landid3'=>$wenzi3['id'],
			);
		$re = M("recommendbook_log")->where("sid=$id and tid=$tid")->find();
		if($re == false){
			M("recommendbook_log")->add($wdata);
		}
		 
		$stugrade=$sdata['grade'];    //获取该学生的年级
		if($stugrade == "一年级" ||$stugrade == "1年级"){
			$book_level = 1;
		}else if($stugrade == "二年级" ||$stugrade == "2年级"){
			$book_level = 2;
		}else if($stugrade == "三年级" ||$stugrade == "3年级"){
			$book_level = 3;
		}else if($stugrade == "四年级" ||$stugrade == "4年级"){
			$book_level = 4;
		}else if($stugrade == "五年级" ||$stugrade == "5年级"){
			$book_level = 5;
		}else if($stugrade == "六年级" ||$stugrade == "6年级"){
			$book_level = 6;
		}
		   
		  //感兴趣的图书12本
		if($wenzi1[keyword] == "我爱诗歌"){
			$wenzi1[keyword]="我爱诗文";
		}else if($wenzi2[keyword] == "我爱诗歌"){
			$wenzi2[keyword]="我爱诗文";
		}else if($wenzi3[keyword] == "我爱诗歌"){
			$wenzi3[keyword]="我爱诗文";
		}
//			$rbooks1=M("recommendbook rb,books b")->where("rb.bid=b.id and 3<b.book_level and b.book_level<7 and b.book_topic='$wenzi1[keyword]' ")->order(" rand()")->limit(4)->select();
		$rbooks1=M("books")->where("book_level=$book_level and book_topic='$wenzi1[keyword]' and id not in ($finishedBooks)")->order(" rand()")->limit(4)->select();
		$rbooks2=M("books")->where("book_level=$book_level and book_topic='$wenzi2[keyword]' and id not in ($finishedBooks)")->order(" rand()")->limit(4)->select();
		$rbooks3=M("books")->where("book_level=$book_level and book_topic='$wenzi3[keyword]' and id not in ($finishedBooks)")->order(" rand()")->limit(4)->select();

		for($i=0;$i<4;$i++){
			$rbooks1id[$i]=$rbooks1[$i]['id'];
		}
		for($i=0;$i<4;$i++){
			$rbooks2id[$i]=$rbooks2[$i]['id'];
		}
		for($i=0;$i<4;$i++){
			$rbooks3id[$i]=$rbooks3[$i]['id'];
		}
		   //拓展图书12本
		if($wenzi1[keyword] == "我爱诗文"){
			$wenzi1[keyword]="我爱诗歌";
		}else if($wenzi2[keyword] == "我爱诗文"){
			$wenzi2[keyword]="我爱诗歌";
		}else if($wenzi3[keyword] == "我爱诗文"){
			$wenzi3[keyword]="我爱诗歌";
		}
		$booktopic=M("booktype")->where("id>8 and keyword not in ('$wenzi1[keyword]','$wenzi2[keyword]','$wenzi3[keyword]' )")->select();
		for($j=0;$j<12;$j++){
			$topicname=$booktopic[$j]['keyword'];
			if($topicname == "我爱诗歌"){
				$topicname = "我爱诗文";
			}
			$tbook[$j]=M("books b")->where("b.book_level=$book_level and b.book_topic='$topicname' and b.id not in ($finishedBooks)")->order(" rand() limit 1")->select();
			$tbooksid[$j]=$tbook[$j][0]['id'];
			$tbooks[] = $tbook[$j][0];
			$this->assign('tbooks'.$j,$tbooks[$j]);
		}
		//不在列图书6本
//			$otherbooks1=M("books b")->where("b.book_level=$book_level and b.id not in ( ";
			for($i=0;$i<4;$i++){
				if($rbooks1id[$i] != ""){
					$rbooks1id[$i] = "$rbooks1id[$i],"; 
					$booksid .=$rbooks1id[$i];
				}
			}
			for($i=0;$i<4;$i++){
				if($rbooks2id[$i] != ""){
					$rbooks2id[$i] = "$rbooks2id[$i],";
					$booksid .=$rbooks2id[$i];
				}
			}
			for($i=0;$i<4;$i++){
				if($rbooks3id[$i] != ""){
					$rbooks3id[$i] = "$rbooks3id[$i],";
					$booksid .=$rbooks3id[$i];
				}
			}
			for($i=0;$i<11;$i++){
				if($tbooksid[$i] != ""){
					$tbooksid[$i] = "$tbooksid[$i],";
					$booksid .=$tbooksid[$i];
				}
			}
			if($tbooksid[11] != ""){
					$tbooksid[11] = "$tbooksid[11]";
					$booksid .=$tbooksid[11];
			}
		$otherbooks =M("books b")->where("b.book_level=$book_level and b.id not in ( $booksid) and b.book_topic not in ('我是侦探','故事经典','我在成长','我的榜样',
					'我爱自然','我爱数学','少年创客','我爱天文','我爱思考','我爱中国','我爱艺术','我爱历史','我爱地理','我爱诗文','奇幻世界') and b.id not in ($finishedBooks)")->order(" rand()")->limit(6)->select();
		for($i=0;$i<6;$i++){
			$otherbooksid[$i]=$otherbooks[$i]['id'];
		} 
		
		//将所预览的图书存入数据库
		$data['stuid'] = $id;
		$data['schid'] = $schid;
		$data['tid'] = $tid;
		$data['reid1'] = $rbooks1id[0]; 	$data['reid2'] = $rbooks1id[1];		$data['reid3'] = $rbooks1id[2];		$data['reid4'] = $rbooks1id[3];
		$data['reid5'] = $rbooks2id[0]; 	$data['reid6'] = $rbooks2id[1];		$data['reid7'] = $rbooks2id[2];		$data['reid8'] = $rbooks2id[3];
		$data['reid9'] = $rbooks3id[0]; 	$data['reid10'] = $rbooks3id[1];    $data['reid11'] = $rbooks3id[2];    $data['reid12'] = $rbooks3id[3];
		$data['toid1'] = $tbooksid[0];
		$data['toid2'] = $tbooksid[1];
		$data['toid3'] = $tbooksid[2];
		$data['toid4'] = $tbooksid[3];
		$data['toid5'] = $tbooksid[4];
		$data['toid6'] = $tbooksid[5];
		$data['toid7'] = $tbooksid[6];
		$data['toid8'] = $tbooksid[7];
		$data['toid9'] = $tbooksid[8];
		$data['toid10'] = $tbooksid[9];
		$data['toid11'] = $tbooksid[10];
		$data['toid12'] = $tbooksid[11];
		$data['toid13'] = $otherbooksid[0];
		$data['toid14'] = $otherbooksid[1];
		$data['toid15'] = $otherbooksid[2];
		$data['toid16'] = $otherbooksid[3];
		$data['toid17'] = $otherbooksid[4];
		$data['toid18'] = $otherbooksid[5];
		$data['createtime'] = date('Y-m-d H:i:s');
		$data['status'] = 0;

		$bookreport = M("bookreports")->where("stuid=$id and schid=$schid and tid=$tid")->find();
		if($bookreport == false){
			$re = M("bookreports")->add($data);		
		}else{
			$re = M("bookreports")->where("stuid=$id and schid=$schid and tid=$tid")->save($data);
		}

		$data_books =array_merge($rbooks1,$rbooks2,$rbooks3,$tbooks,$otherbooks);

 		return($data_books);
	}

	public function over(){
		
		$id = $_SESSION['uid'];
		$tid = $_SESSION['tid'];
		$schid = $_SESSION['schid'];
		$data = M("bookreports")->where("stuid=$id and schid=$schid and tid=$tid")->find();

		$finishedBooks['stuid'] = $id;
		for($j=1;$j<=12;$j++){
			$finishedBooks['bookid'] = $data["reid$j"];
			M("finishedbooks")->add($finishedBooks);
		}
		for($i=1;$i<=18;$i++){
			$finishedBooks['bookid'] = $data["toid$i"];
			M("finishedbooks")->add($finishedBooks);
		}

		$this->redirect('Index/Index/index');
	}

	public function pdfdownload(){
		$id = $_SESSION['uid'];
		$tid = $_SESSION['tid'];
		$schid = $_SESSION['schid'];
		//删除简介中的换行的参数
		$order = array("\r\n", "\n", "\r");   
		$replace = '';

		$data = M("bookreports")->where("stuid=$id and schid=$schid and tid=$tid")->find();
		//var_dump($data);die;

		$finishedBooks['stuid'] = $id;
		for($j=1;$j<=12;$j++){
			$finishedBooks['bookid'] = $data["reid$j"];
			M("finishedbooks")->add($finishedBooks);
		}
		for($i=1;$i<=18;$i++){
			$finishedBooks['bookid'] = $data["toid$i"];
			M("finishedbooks")->add($finishedBooks);
		}

		if(empty($id)||empty($tid)){
			$this->error('错误操作');
		}
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

					
		//下载的记录存储到数据库
		$bookreportsid = $reportbooks[0]["id"];
		$datas["downtime"] = date('Y-m-d H:i:s');
		$datas["status"] = 1;
		$changedate = M("bookreports")->where("id=$bookreportsid")->data($datas)->save();


		require_once("../Admin/ReportAction.class.php");
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
	/*
	 *author: GaoCheng
	 *用于客户勾选已读书籍并重新生成推荐书单
	 */
	public function ajaxFinishedbooks(){
		$uid=$_SESSION['uid'];
		if($uid==''){
			$this->redirect('Index/login');
		} 
		$bookids=I("id");
		$bookid = explode(',', $bookids);
		foreach($bookid as $bid)
		{
			$finishedBooks['bookid'] = $bid;
			$finishedBooks['stuid'] = $uid;
			$re = M("finishedbooks")->add($finishedBooks);
			if($re == false){
				//$this->ajaxReturn(array('status'=>0, 'msg'=>'对不起，操作失败！'));
				$this->ajaxReturn(array('status'=>0, 'msg'=>$bookids));
			}
		}
		//$where = "IN ('" . implode("', '", $id) . "')";
		//$res = M("student")->where("`id` " . $where)->delete();
		$this->ajaxReturn(array('status'=>1, 'msg'=>'恭喜您，操作成功！'));
	}



	
}
?>