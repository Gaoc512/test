<?php
class TestAction extends CommonAction{
	public function index(){
		import('ORG.Util.Page');// 导入分页类
		$count = M("test")->where($sql)->count();// 查询满足要求的总记录数 $map表示查询条件
		$p=I('p',1);
	   	$page = new Page($count,15);// 实例化分页类 传入总记录数
	   	$show = $page->show();// 分页显示输出
	   	
	    $data=M("test")->where($sql)->order('createtime desc')->limit($page->firstRow.','.$page->listRows)->select();
	    
	    //echo M("schools")->getlastsql();
	    $this->assign('data',$data);
	    $this->assign('page',$show);
	    $this->assign('p',$p);
	    $this->display();
	}

	public function add(){
		if($_POST){
			import("ORG.Util.Pinyin");
			$py = new PinYin();

			if(M('test')->where("name='".$data['name']."'")->find()){
				$this->error("该学校已经录入");
			}

			$data['name'] = I('testname');
			$data['testpy'] = $py->getAllPY(I('testname'));
			$data['testfirstpy'] = $py->getFirstPY(I('testname'));
			$data['createtime']=date("Y-m-d H:i:s");
			$data['content'] = I('content');

			$re=M("test")->add($data);
			if($re==true){
	  			 $this->success('新增成功！',U('index'));
	  		}else{
	  			$this->error("新增失败");
	  		}
    	}else{
    		$this->display();
    	}
	}

	public function deltest(){
		$id=I("id");
		if(empty($id)){
			$this->error("错误操作");
		}else{
			$re=M("test")->where("id=$id")->delete();
			if($re==true){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
		}
	}

	public function edit(){
		$id = I('id');
		if(!empty($id)){
			$data=M("test")->where("id=$id")->find();//var_dump($data);die;

			$this->assign('data',$data);
			$this->assign('p',$p);
			$this->display();		
		}else{
			$this->error("未收到学校id信息");
		}
	}

	public function save(){
		$adddata=$_POST;
  		$id=$_GET['id'];

  		import("ORG.Util.Pinyin");
		$py = new PinYin();
		$adddata['testpy'] = $py->getAllPY($adddata['testname']);
		$adddata['testfirstpy'] = $py->getFirstPY($adddata['testname']);

		$re = M('test')->where('id='.$id)->save($adddata);
  		if($re==true){
  			$this->success("修改成功",U('index'));
  		}else{
  			$this->error("修改失败");
  		}	
	}

	public function editschool(){
		import('ORG.Util.Page');// 导入分页类
		$id = $_GET['id'];
		$schids = M('test_school')->where("tid=".$id)->getfield('schid',true);
		$schids = implode(',',$schids);
		if($schids == null){
			$schids = '0';
		}

		//测试内学校数据
		if($_POST['search_in']){
			$item = $_POST['search_in'];
			$school_in_test = M('school')
				->where("(schoolpy like '%$item%' or schoolfirstpy like '%$item%' or schoolname like '%$item%') and id in (".$schids.")")
				->order("createtime desc")
				->select();
			$count_in = M('school')
				->where("(schoolpy like '%$item%' or schoolfirstpy like '%$item%' or schoolname like '%$item%') and id in (".$schids.")")
				->count();
		}else{
			$school_in_test = M('school')->where("id in (".$schids.")")->order("createtime desc")->select();
			$count_in = M('school')->where("id in (".$schids.")")->count();
		}
		foreach($school_in_test as $key=>$value){
			$school_in_test["$key"]['starttime'] = M('test_school')->where("tid=".$id." and schid=".$value['id'])->getField('starttime');
			$school_in_test["$key"]['endtime'] = M('test_school')->where("tid=".$id." and schid=".$value['id'])->getField('endtime');
			$school_in_test["$key"]['download'] = M('test_school')->where("tid=".$id." and schid=".$value['id'])->getField('status') ? '是' : '否' ;
			$school_in_test["$key"]['test_school_id'] = M('test_school')->where("tid=".$id." and schid=".$value['id'])->getField('id');

		}
		//var_dump($school_in_test);die;
		$p_in = I('p_in',1);
		$page_in = new Page($count_in,15);
		$show_in = $page_in->show();
		$this->assign('data_in',$school_in_test);
		$this->assign('show_in',$show_in);
		$this->assign('p_in',$p_in);

		//测试外学校数据	
		if($_POST['search_out']){
			$item = $_POST['search_out'];
			$school_out_test = M('school')
				->where("(schoolpy like '%$item%' or schoolfirstpy like '%$item%' or schoolname like '%$item%') and id not in (".$schids.")")
				->order("createtime desc")
				->select();
			$count_out = M('school')
				->where("(schoolpy like '%$item%' or schoolfirstpy like '%$item%' or schoolname like '%$item%') and id not in (".$schids.")")
				->count();
		}else{
			$school_out_test = M('school')->where("id not in (".$schids.")")->order("createtime desc")->select();
			$count_out = M('school')->where("id not in (".$schids.")")->count();			
		}
		$p_out = I('p_out',1);
		$page_out = new Page($count_out,15);
		$show_out = $page_out->show();	
		$this->assign('data_out',$school_out_test);
		$this->assign('show_out',$show_out);
		$this->assign('p_out',$p_out);

		$this->assign('id',$id);

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

	public function testtime(){
		$tid = $_GET['tid'];
		$schid = $_GET['schid'];
		$data['starttime'] = I('starttime');
		$data['endtime'] = I('endtime');

		$school = M('test_school')->where("schid=$schid")->select();
		foreach($school as $key=>$value){
			if( (strtotime($data['starttime'])>=strtotime($value['starttime']) and strtotime($data['starttime'])<strtotime($value['endtime'])) or
				(strtotime($data['endtime'])>strtotime($value['starttime']) and strtotime($data['endtime'])<=strtotime($value['endtime']))  or 
				(strtotime($data['starttime'])<=strtotime($value['starttime']) and strtotime($data['endtime'])>=strtotime($value['endtime'])) ){
					M('test_school')->where("tid=$tid and schid=$schid")->delete();
					$this->error("时间段于其它测试重复",U('Test/editschool',array('id'=>$tid)));
			}
		}
		
		if(strtotime($data['starttime']) > strtotime($data['endtime'])){
			$this->error("操作错误：请保证测试结束时间晚于测试开始时间");
		}
		
		$re = M('test_school')->where("tid=".$tid." and schid=".$schid)->save($data);
		if(!$re){
			$this->error("test_school表更新失败");
		}else{
			$this->success('操作成功',U('Test/editschool',array('id'=>$tid)));
		}
	}

	/*
	 *author: GaoCheng
	 *用于客户勾选已读书籍并重新生成推荐书单
	 */
	public function ajaxAddschool(){
		$tid = I('id');
		$schids=I("schids");
		$schids = explode(',', $schids);
		foreach($schids as $sid)
		{
			$data['tid'] = $tid;
			$data['schid'] = $sid;
			$re = M("test_school")->add($data);
			if($re == false){
				//$this->ajaxReturn(array('status'=>0, 'msg'=>'对不起，操作失败！'));
				$this->ajaxReturn(array('status'=>0, 'msg'=>$tid.'失败'));
			}
		}
		//$where = "IN ('" . implode("', '", $id) . "')";
		//$res = M("student")->where("`id` " . $where)->delete();
		$this->ajaxReturn(array('status'=>1, 'msg'=>$tid.'成功'));
	}

	public function ajaxDelschool(){
		$tid = I('id');
		$schids=I("schids");
		$schids = explode(',', $schids);
		foreach($schids as $sid)
		{
			$re = M("test_school")->where("tid='$tid' and schid='$sid'")->delete();
			if($re == false){
				//$this->ajaxReturn(array('status'=>0, 'msg'=>'对不起，操作失败！'));
				$this->ajaxReturn(array('status'=>0, 'msg'=>$schids));
			}
		}
		//$where = "IN ('" . implode("', '", $id) . "')";
		//$res = M("student")->where("`id` " . $where)->delete();
		$this->ajaxReturn(array('status'=>1, 'msg'=>'恭喜您，操作成功！'));
	}
}
?>