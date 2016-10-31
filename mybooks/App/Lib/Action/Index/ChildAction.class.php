<?php
class ChildAction extends CommonAction {

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
	
	public function child(){
	$data=array(
		'1'=>array('title'=>'小精灵','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/1.png"),
		'2'=>array('title'=>'小朋友','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/2.png"),
		'3'=>array('title'=>'小小科学家','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/3.png"),
		'4'=>array('title'=>'艺术家','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/4.png"),
		'5'=>array('title'=>'诗人','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/5.png"),
		'6'=>array('title'=>'数学家','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/6.png"),
		);	
	$array=$_SESSION["result"]; 
		$picture=array(
			  '1'=>$data[$array[0]]['picurl'],
			  '2'=>$data[$array[1]]['picurl'],
			  '3'=>$data[$array[2]]['picurl'],
			  '4'=>$data[$array[3]]['picurl'],
			  '5'=>$data[$array[4]]['picurl'],
			  '6'=>$data[$array[5]]['picurl'],
			);
			$this->assign('picture',$picture);
		//	print_r($picture);
			$this->display();
	}
	
		//低年级模板
	public function island(){
		if($_POST){
		    $uid=$_SESSION['uid'];
		    $tid=$_SESSION['tid'];
		    $count=M("answer")->where("sid=$uid and tid=$tid")->count();
		    $key1=I("key1");
		    $key2=I("key2");
		    $key3=I("key3");
		    if($key1==""||$key2==""||$key3==""){
		    	$this->error("小朋友，你的三把钥匙没有选全哟");
		    }
		    if($count==0){
		    	$adddata=array(
		    	'key1'=>I("key1"),
		    	'key2'=>I("key2"),
		    	'key3'=>I("key3"),
		    	'sid'=>$uid,
		    	'tid'=>$tid
		    	);
		    	M("answer")->add($adddata);
		    }else{
		    	$adddata=array(
		    	'key1'=>I("key1"),
		    	'key2'=>I("key2"),
		    	'key3'=>I("key3"),
		    	
		    	);
		    	M("answer")->where("sid=$uid and tid=$tid")->save($adddata);
		    }
		}
		//随机取出6个岛
		$data=array(
		'1'=>array('title'=>'小精灵','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/1.png",'touxiang'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/fairy.png"),
		'2'=>array('title'=>'小朋友','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/2.png",'touxiang'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/childs.png"),
		'3'=>array('title'=>'小小科学家','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/3.png",'touxiang'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/scientist.png"),
		'4'=>array('title'=>'艺术家','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/4.png",'touxiang'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/art.png"),
		'5'=>array('title'=>'诗人','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/5.png",'touxiang'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/poet.png"),
		'6'=>array('title'=>'数学家','picurl'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/6.png",'touxiang'=>C('TMPL_PARSE_STRING.__PUBLIC__')."/img/mathma.png"),
		);
		$page=I("p");
		if(empty($page)){
		
		$page=0;
		}
		$array=$_SESSION["result"]; 
		$val=$array[$page];
		switch ($page){
			case 0:
				$num="一";
				break;
		    case 1:
				$num="二";
				break;
		    case 2:
				$num="三";
				break;
		    case 3:
				$num="四";
				break;
			case 4:
				$num="五";
				break;
			case 5:
				$num="六";
				break;
		}
		$this->assign('num',$num);
		$this->assign('p',$page+1);
		if($page==6){
			$picture=array(
			  '1'=>$data[$array[0]]['picurl'],
			  '2'=>$data[$array[1]]['picurl'],
			  '3'=>$data[$array[2]]['picurl'],
			  '4'=>$data[$array[3]]['picurl'],
			  '5'=>$data[$array[4]]['picurl'],
			  '6'=>$data[$array[5]]['picurl'],
			);
			$touxiang=array(
			  '1'=>$data[$array[0]]['touxiang'],
			  '2'=>$data[$array[1]]['touxiang'],
			  '3'=>$data[$array[2]]['touxiang'],
			  '4'=>$data[$array[3]]['touxiang'],
			  '5'=>$data[$array[4]]['touxiang'],
			  '6'=>$data[$array[5]]['touxiang'],
			);
			$value=array(
			 '1'=>$array[0],
			  '2'=>$array[1],
			  '3'=>$array[2],
			  '4'=>$array[3],
			  '5'=>$array[4],
			  '6'=>$array[5],
			);
			$this->assign('picture',$picture);
				$this->assign('touxiang',$touxiang);
			//	print_r($picture);
			$this->assign('value',$value);
			$this->display("over");
		}else{
		$this->display("island$val");
		}
		
	}
	public function land4(){
		
		$page=I("p");
		$array=$_SESSION["result"]; 
	    $x=I('x');
	    
	
		if($x==3){
		
			$val=$array[$page];
			
			$type=$val;
	    	$this->assign('type',$type);
	    }
		switch ($page-1){
			case 0:
				$num="一";
				break;
		    case 1:
				$num="二";
				break;
		    case 2:
				$num="三";
				break;
		    case 3:
				$num="四";
				break;
			case 4:
				$num="五";
				break;
			case 5:
				$num="六";
				break;
		}
		$this->assign('num',$num);
		$this->assign('p',$page);
		$this->display("island4-$x");
	}
	public function land6(){
		
		$page=I("p");
		$array=$_SESSION["result"]; 
	    $x=I('x');
	    
	
		if($x==3){
		
			$val=$array[$page];
			
			$type=$val;
	    	$this->assign('type',$type);
	    }
		switch ($page-1){
			case 0:
				$num="一";
				break;
		    case 1:
				$num="二";
				break;
		    case 2:
				$num="三";
				break;
		    case 3:
				$num="四";
				break;
			case 4:
				$num="五";
				break;
			case 5:
				$num="六";
				break;
		}
		$this->assign('num',$num);
		$this->assign('p',$page);
		$this->display("island6-$x");
	}
	public function land1(){
		
		$page=I("p");
		$array=$_SESSION["result"]; 
	    $x=I('x');
	    
	
		if($x==3){
		
			$val=$array[$page];
			
			$type=$val;
	    	$this->assign('type',$type);
	    }
		switch ($page-1){
			case 0:
				$num="一";
				break;
		    case 1:
				$num="二";
				break;
		    case 2:
				$num="三";
				break;
		    case 3:
				$num="四";
				break;
			case 4:
				$num="五";
				break;
			case 5:
				$num="六";
				break;
		}
		$this->assign('num',$num);
		$this->assign('p',$page);
		$this->display("island1-$x");
	}
	public function land2(){
		
		$page=I("p");
		$array=$_SESSION["result"]; 
	    $x=I('x');
	    
	
		if($x==3){
		
			$val=$array[$page];
			
			$type=$val;
	    	$this->assign('type',$type);
	    }
		switch ($page-1){
			case 0:
				$num="一";
				break;
		    case 1:
				$num="二";
				break;
		    case 2:
				$num="三";
				break;
		    case 3:
				$num="四";
				break;
			case 4:
				$num="五";
				break;
			case 5:
				$num="六";
				break;
		}
		$this->assign('num',$num);
		$this->assign('p',$page);
		$this->display("island2-$x");
	}
	public function land3(){
		
		$page=I("p");
		$array=$_SESSION["result"]; 
	    $x=I('x');
	    
	
		if($x==6){
		
			$val=$array[$page];
			
			$type=$val;
	    	$this->assign('type',$type);
	    }
		switch ($page-1){
			case 0:
				$num="一";
				break;
		    case 1:
				$num="二";
				break;
		    case 2:
				$num="三";
				break;
		    case 3:
				$num="四";
				break;
			case 4:
				$num="五";
				break;
			case 5:
				$num="六";
				break;
		}
		$this->assign('num',$num);
		$this->assign('p',$page);
		$this->display("island3-$x");
	}
	
	public function land5(){
		
		$page=I("p");
		$array=$_SESSION["result"]; 
	    $x=I('x');
	    
	
		if($x==3){
		
			$val=$array[$page];
			
			$type=$val;
	    	$this->assign('type',$type);
	    }
		switch ($page-1){
			case 0:
				$num="一";
				break;
		    case 1:
				$num="二";
				break;
		    case 2:
				$num="三";
				break;
		    case 3:
				$num="四";
				break;
			case 4:
				$num="五";
				break;
			case 5:
				$num="六";
				break;
		}
		$this->assign('num',$num);
		$this->assign('p',$page);
		$this->display("island5-$x");
	}


	public function finish(){
		$uid = $_SESSION['uid'];
		$tid = $_SESSION['tid'];
		$schid = $_SESSION['schid'];

		$word1 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;现在你看到的是我们为你推荐的书单。请你看一看这些书中有没有你已读过的，如果有请你勾选出来，并点击页面最下方的“重新生成”，最后请点击“下载”下载您的书单，希望它能带你畅游阅读天地。";
		$word2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;现在你看到的是我们为你推荐的书单。请你看一看这些书中有没有你已读过的，如果有请你勾选出来，并点击页面最下方的“重新生成”，最后请点击“完成”，之后我们会通过其它方式将这份书单送到你身边，希望它能带你畅游阅读天地。";
		$status = M('test_school')->where("tid=$tid and schid=$schid")->getfield('status');
		$src = $status ? "/App/Tpl/Index/Public/img/xia.png" : "/App/Tpl/Index/Public/img/wancheng.png";
		$href = $status ? U('Senior/pdfdownload') : U('Senior/over');
		$word = $status ? $word1 : $word2;

		if($_POST){
			if($uid==''){
				$this->redirect('Index/login');
			}
			$land1=I("land1");
	    	$land2=I("land2");
	    	$land3=I("land3");
	    	$land4=I("land4");
	    	$land5=I("land5");
	    	$land6=I("land6");
	    	if($land1=="" ||$land2==""||$land3==""||$land4==""||$land5==""||$land6==""){
	    		$this->error("亲爱的小朋友，小岛不能落下哟");
	    	}
	    	
		    $count=M("answer")->where("sid=$uid and tid=$tid and key1!=0 and key2!=0 and key3!=0")->count();  
		    if($count==0){
		    	$adddata=array(
			    	'land1'=>I("land1"),
			    	'land2'=>I("land2"),
			    	'land3'=>I("land3"),
			    	'land4'=>I("land4"),
			    	'land5'=>I("land5"),
			    	'land6'=>I("land6"),
			    	'sid'=>$uid,
			    	'createtime'=>date('Y-m-d H:i:s')
			    	);
		    	$re=M("answer")->add($adddata);
		    }else{
		    	$adddata=array(
			    	'land1'=>I("land1"),
			    	'land2'=>I("land2"),
			    	'land3'=>I("land3"),
			    	'land4'=>I("land4"),
			    	'land5'=>I("land5"),
			    	'land6'=>I("land6"),
			    	'createtime'=>date('Y-m-d H:i:s')
			    	);
		    	$re=M("answer")->where("sid=$uid")->save($adddata);
		    }
		    if($re==true){
		    	$bookslist = $this->report_generate();
		    	foreach($bookslist as $key=>$value){
		    		if(!$this->url_exists(UPLOAD.$value['book_picimg'])){
		    			$bookslist[$key]['book_picimg'] = "fm.png";
		    		}
		    	}
		    }else{
		    	$this->error("作答数据存储错误");
		    }
		}else{
			$bookslist = $this->report_generate();
			foreach($bookslist as $key=>$value){
	    		if(!$this->url_exists(UPLOAD.$value['book_picimg'])){
	    			$bookslist[$key]['book_picimg'] = "fm.png";
	    		}
	    	}
		}
		$this->assign('data',$bookslist);
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

		$booktype=array(
			'1'=>array('id'=>1,'key'=>'童话'),
			'2'=>array('id'=>2,'key'=>'成长'),
			'4'=>array('id'=>6,'key'=>'艺术'),
			'5'=>array('id'=>7,'key'=>'诗歌'),
			'6'=>array('id'=>8,'key'=>'数学'),);
		$keytype=array(
			'1'=>array('id'=>3,'key'=>'地球'),
			'2'=>array('id'=>4,'key'=>'动物'),
			'3'=>array('id'=>5,'key'=>'植物'));
		$type1=M("answer")->where("sid=$id")->getfield('land1');
		$type2=M("answer")->where("sid=$id")->getfield('land2');
		$type3=M("answer")->where("sid=$id")->getfield('land3');
		$type4=M("answer")->where("sid=$id")->getfield('key1');
		$types=M("answer")->where("sid=$id")->find();
		if($type1!=3 && $type2!=3 && $type3!=3){
			$landid1=$booktype[$type1]['id'];
			$landid2=$booktype[$type2]['id'];
			$landid3=$booktype[$type3]['id'];
		}else{
			if($type1==3){
				$landid1=$keytype[$type4]['id'];	
				$landid2=$booktype[$type2]['id'];
				$landid3=$booktype[$type3]['id'];
			}else if($type2==3){
				$landid2=$keytype[$type4]['id'];	
				$landid1=$booktype[$type1]['id'];
				$landid3=$booktype[$type3]['id'];
			}else if($type3==3){
				$landid3=$keytype[$type4]['id'];	
				$landid1=$booktype[$type1]['id'];
				$landid2=$booktype[$type2]['id'];
			}
		}
		$wenzi1=M("booktype")->where("id=$landid1")->find();
		$wenzi2=M("booktype")->where("id=$landid2")->find();
		$wenzi3=M("booktype")->where("id=$landid3")->find();

		$wdata=array(
			'sid'=>$id,
			'tid'=>$tid,
			'landid1'=>$landid1,
			'landid2'=>$landid2,
			'landid3'=>$landid3,);
		$recommendbook_log = M('recommendbook_log')->where("sid=$id and tid=$tid")->find();
		if($recommendbook_log ==  false){
			M("recommendbook_log")->add($wdata);		
		}


		//这块有问题   针对低年级书籍没有level=3以上的   4·5·6年级这块需要处理
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

		$rbooks1=M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")
			->where("m.id=t.id and t.bid=b.id and b.book_level=$book_level and t.tag_name='$wenzi1[name]' and b.id not in ($finishedBooks)")
			->order(" rand()")
			->limit(4)
			->select();
		$rbooks2=M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")
			->where("m.id=t.id and t.bid=b.id and b.book_level=$book_level and t.tag_name='$wenzi2[name]' and b.id not in ($finishedBooks)")
			->order(" rand()")
			->limit(4)
			->select();
		$rbooks3=M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")
			->where("m.id=t.id and t.bid=b.id and b.book_level=$book_level and t.tag_name='$wenzi3[name]' and b.id not in ($finishedBooks)")
			->order(" rand()")
			->limit(4)
			->select();
		for($i=0;$i<4;$i++){
			$rbooks1id[$i]=$rbooks1[$i]['bid'];
		}
		for($i=0;$i<4;$i++){
			$rbooks2id[$i]=$rbooks2[$i]['bid'];
		}
		for($i=0;$i<4;$i++){
			$rbooks3id[$i]=$rbooks3[$i]['bid'];
		}
				

		//拓展图书10本
		if($wenzi1[name] == "地球与科学"){
			$wenzi1[name] = "地球科学";
		}else if($wenzi1[name] == "故事世界"){
			$wenzi1[name] = "童话世界";
		}
		if($wenzi2[name] == "地球与科学"){
			$wenzi2[name] = "地球科学";
		}else if($wenzi2[name] == "故事世界"){
			$wenzi2[name] = "童话世界";
		}
		if($wenzi3[name] == "地球与科学"){
			$wenzi3[name] = "地球科学";
		}else if($wenzi3[name] == "故事世界"){
			$wenzi3[name] = "童话世界";
		}
		$booktopic=M("booktype")
			->where("id<=8 and name not in ('$wenzi1[name]','$wenzi2[name]','$wenzi3[name]' )")
			->select();
		$tbooks = array();
		for($i=0;$i<5;$i++){
			$topicname=$booktopic[$i]['name'];
			if($topicname == "童话世界"){
				$topicname = "故事世界";
			}else if($topicname == "地球科学"){
				$topicname = "地球与科学";
			}
			$tbook[$i]=M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")
				->where("m.id=t.id and t.bid=b.id and b.book_level=$book_level and t.tag_name='$topicname' and b.id not in ($finishedBooks)")
				->order(" rand()")
				->limit(2)
				->select();
			$tbooks = array_merge($tbooks,$tbook[$i]);
			$num = 2*$i;
			$tbooksid[$num]=$tbook[$i][0]['bid'];
			$tbooksid[$num+1]=$tbook[$i][1]['bid'];
			//$this->assign('tbooks'.$i,$tbooks[$i]);
		}


		//不在列的图书8本
		for($i=0;$i<4;$i++){
			if($rbooks1id[$i] != ""){
				$rbooks1id[$i] = "$rbooks1id[$i],";
				$bookid .=$rbooks1id[$i];
			}
		}
		for($i=0;$i<4;$i++){
			if($rbooks2id[$i] != ""){
				$rbooks2id[$i] = "$rbooks2id[$i],";
				$bookid .=$rbooks2id[$i];
			}
		}
		for($i=0;$i<4;$i++){
			if($rbooks3id[$i] != ""){
				$rbooks3id[$i] = "$rbooks3id[$i],";
				$bookid .=$rbooks3id[$i];
			}
		}
		for($i=0;$i<9;$i++){
			if($tbooksid[$i] != ""){
				$tbooksid[$i] = "$tbooksid[$i],";
				$bookid .=$tbooksid[$i];
			}
		}
		if($tbooksid[9] != ""){
			$tbooksid[9] = "$tbooksid[9]";
			$bookid .=$tbooksid[9];
		}
		$otherbooks=M("books b,tags t,(select min(id) as id,bid from tags group by bid) m")
			->where("m.id=t.id and t.bid=b.id and b.book_level=$book_level and t.tag_name not in ('成长世界','艺术世界','数学世界','诗歌世界','动物世界','植物世界','地球与科学','故事世界','童话故事','地球科学') and
					b.id not in ($bookid) and b.id not in ($finishedBooks)")
			->order(" rand() ")
			->limit(8)
			->select();
				
		for($i=0;$i<8;$i++){
			$otherbooksid[$i]=$otherbooks[$i]['bid'];
		}
		//将所预览的图书存入数据库
	//	$idmax = M("bookreports")->order("id desc")->limit(1)->select();
		$idmax = M("bookreports")->getField("max(id)");
		$data['id'] = $idmax+1;
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
		$data['toid11'] = $otherbooksid[0];
		$data['toid12'] = $otherbooksid[1];
		$data['toid13'] = $otherbooksid[2];
		$data['toid14'] = $otherbooksid[3];
		$data['toid15'] = $otherbooksid[4];
		$data['toid16'] = $otherbooksid[5];
		$data['toid17'] = $otherbooksid[6];
		$data['toid18'] = $otherbooksid[7];
		$data['createtime'] = date('Y-m-d H:i:s');
		$data['status'] = 0;
		
		$bookreport = M("bookreports")->where("stuid=$id and schid=$schid and tid=$tid")->find();
		if($bookreport == false){
			$re = M("bookreports")->add($data);		
		}else{
			$re = M("bookreports")->where("stuid=$id and schid=$schid and tid=$tid")->save($data);
		}

		if($re === false){
			$this->error("兴趣书单存储出现错误");
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