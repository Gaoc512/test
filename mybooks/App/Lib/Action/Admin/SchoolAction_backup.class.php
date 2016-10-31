<?php
class SchoolsAction extends CommonAction {
    public function index(){
    	import('ORG.Util.Page');// 导入分页类
	$count = M("schools")->where($sql)->count();// 查询满足要求的总记录数 $map表示查询条件
	//$p=I('p',1);
   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
   	$show = $Page->show();// 分页显示输出
   	
    $data=M("schools")->where($sql)->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    
    //echo M("schools")->getlastsql();
    $this->assign('data',$data);
    $this->assign('page',$show);
    //$this->assign('p',$p);
    $this->display();
    }
	
    public function add(){
    	if($_POST){
    		//print_r($_POST);
    		$data=$_POST;
    		$data['createtime']=date("Y-m-d H:i:s");
    		$re=M("schools")->add($data);
    		if($re==true){
      			 $this->success('新增成功！',U('index'));
      		}else{
      			$this->error("新增失败");
      		}
    	}else{
    		$this->display();
    	}
    }
    
    
    //编辑
	public function edit(){
		if($_POST){
			$adddata=$_POST;
      		$id=I('id');
      		$p=I('p');
//      		echo "当前页面为：".$p;
      		$province=I('cmbProvince');
      		$cmbCity=I('cmbCity');
      		$cmbArea=I('cmbArea');
      		$school=I('schoolname');
      		$schAddress=array(
      			'province'=>$province,
      			'city'=>$cmbCity,
      			'area'=>$cmbArea,
      			'schoolname'=>$school
      		);
      		$res=M("schools")->where("id=$id")->save($adddata);
      		
      		//学校跟数据库进行比对，如果数据存存在该学校，则该步骤不进行，如果该学校不存在则进行
      		$checkschool=M("school")->where("province='$province' and city='$cmbCity' and area='$cmbArea' and schoolname='$school' ")->count();
      		if($checkschool == 0){
      			$re=M("school")->add($schAddress);
	      		if($res==true and $re==true){
	      			 $this->success('修改成功！',U('index',array('p'=>$p)));
	      		}else{
	      			$this->error("修改失败");
	      		}
      		}else{
	      		if($res==true){
	      			 $this->success('修改成功！',U('index',array('p'=>$p)));
	      		}else{
	      			$this->error("修改失败");
	      		}
      		}
      		
      		
      		
		}else{
			$id=I("id");
			$p=I('p');
//			echo "当前页面为：".$p;
			if(!empty($id)){
			$data=M("schools")->where("id=$id")->find();
		
		  $this->assign('data',$data);
		  $this->assign('p',$p);
		  $this->display();		
			}
		}
	}
    
	public function delschool(){
		$id=I("id");
		if(empty($id)){
			$this->error("错误操作");
		}else{
			$re=M("schools")->where("id=$id")->delete();
			if($re==true){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
		}
	}
	
	
	public function stulist(){
		$id=I("id");
		if(empty($id)){
			$this->error("错误操作");
		}else{
		import('ORG.Util.Page');// 导入分页类
	$count = M("student")->where("tid=$id")->count();// 查询满足要求的总记录数 $map表示查询条件
   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
   	$show = $Page->show();// 分页显示输出
    $data=M("student")->where("tid=$id")->order('createtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
    $counts=M("student")->where("(stu_code is NULL and stu_pwd is NULL) or (stu_code='' and stu_pwd='') ")->count();
   // echo M("student")->getlastsql();
    $this->assign('counts',$counts);
    $this->assign('data',$data);
    $this->assign('page',$show);// 赋值分页输出
    $this->assign('tid',$id);
    $this->display();
	}
	}
    
	public function leadin(){
		$id=I('id');
		 $this->assign('tid',$id);
		$this->display();
	}
	
	public function impUser(){
	       header("Content-type:text/html;charset=utf-8");
	       $tid=I("tid");
           if (!empty($_FILES)) {
               import('ORG.Net.UploadFile');
                $config=array(
                    'allowExts'=>array('xlsx','xls'),
                    'savePath'=>'./Upload/stuExcel/',
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
                    //echo $highestRow;
                    $bizhi=0;
                    for($i=2;$i<=$highestRow;$i++)
                    {   
                       $data['username']= $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue(); 
                       $data['school']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                       $data['grade']= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
                       $data['class'] = $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
                        $data['birthday'] = $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
                        $data['sex']= $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
                        $code= $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
                        $data['stu_code']=$code;
                        $pwd= $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
                         $data['stu_pwd']=$pwd;
                        $data['tid']=$tid;                     
                        $data['createtime']=date("Y-m-d H:i:s");  
                         $num=M('student')->where("stu_code='$code'")->count();
                         if($num==0){
                         	  $bid=M('student')->add($data);
                         }else{
                         $bizhi=1;
                         $this->error("从第".$i."行出现账号重复现象",U('stulist',array('id'=>$tid))); 
                         break;
                         	
                         	//
                         	//exit();
                         }                               
                      
                       
                    } 
                    if($bizhi==0){
                   $this->success('导入成功！',U('stulist',array('id'=>$tid)));
                    }
            }else
                {
                    $this->error("请选择上传的文件");
                }     
             
        }
        
        
	//生成密码
	public function scpwd(){
		if($_POST){
		$id=I("id");
		$prefix=I("prefix");
		$pdata=M("prefix")->where("prefix='$prefix'")->find();
		$sql="update student set stu_code=CONCAT('hewgy_',id), stu_pwd=FLOOR(100000 + (RAND() * 999999)) where (stu_code is NULL and stu_pwd is NULL) or (stu_code='' and stu_pwd='')";
		//echo $sql;
		$model=new Model();
		$re=$model->query($sql);
		$adds=array(
		'tid'=>$id,
		'prefix'=>$prefix
		);
		if(empty($pdata)){
		
		M("prefix")->add($adds);
		}
		//if($re==true){
			$this->success("生成密码成功",U('stulist',array('id'=>$id)));
//		}else{
//			$this->error("生成密码失败");
//		}
		}else{
		$id=I("id");
		$this->assign("id",$id);	
		$this->display();
		}
		
	}
	
	//重置密码
	public function resetPwd(){
		$id=I("id");
		$sql="update student set stu_pwd=FLOOR(100000 + (RAND() * 999999)) where id=$id";
		$model=new Model();
		$re=$model->query($sql);
		//print_r($re);
		//if($re==true){
			$this->success("重置密码成功");
//		}else{
//			//$this->error("重置密码失败");
//		}
	}
	
	
	public function del(){
		$id=I("id");
		$re=M("student")->where("id=$id")->delete();
		if($re==true){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}
	
	public function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName =$xlsTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
       
        $objPHPExcel = new PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
       // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }
	
	
	
	//导出
	 function expUser(){//导出Excel
	 	$tid=I('id');
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
        $xlsModel = M('student');
    
        $xlsData  = $xlsModel->where("tid=$tid")->Field('username,school,grade,class,birthday,sex,stu_code,stu_pwd')->select();
//        foreach ($xlsData as $k => $v)
//        {
//            $xlsData[$k]['sex']=$v['sex']==1?'男':'女';
//        }
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
         
    }
    
    //编辑学生信息
    public function editstudent(){
    	if($_POST){
    		$id=I("id");
    		$data=$_POST;
    		$re=M("student")->where("id=$id")->save($data);
    		if($re==true){
    		   $this->success("修改成功",U('stulist'));	
    		}else{
    	     $this->error("修改失败");	
    		}
    	
    	}else{
    	$id=I("id");
    	if(!empty($id)){
		$data=M("student")->where("id=$id")->find();
		$this->assign('data',$data);
		$this->display();
    	}
    	}
    }
    
    //题库管理
    public  function question(){
    import('ORG.Util.Page');// 导入分页类
	$count = M("subject")->where($sql)->count();// 查询满足要求的总记录数 $map表示查询条件
   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
   	$show = $Page->show();// 分页显示输出
    $data=M("subject")->where($sql)->order('createtime desc,id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
    //echo M("books")->getlastsql();
    $this->assign('data',$data);
    $this->assign('page',$show);// 赋值分页输出
    $this->display();
    }
    
    public  function editquestion(){
    	if($_POST){
    			$id=I("id");
			$edit=array(
			'title'=>I('title'),
			'typename'=>I('typename')
			);
			$re=M("subject")->where("id=$id")->save($edit);
			if($re==true){
				$this->success("修改成功",U('question'));
			}else{
				$this->error("修改失败");
			}
    	}else{
    		$id=I("id");
    		$data=M("subject")->where("id=$id")->find();
			//关键词
			$keywords=M("booktopic")->field('title')->select();
			//echo M("booktype")->getlastsql();
		//	print_r($keywords);
			$this->assign('keywords',$keywords);
    		$this->assign('data',$data);
    		 $this->display();
    	}
    }
    
    public function delquestion(){
		$id=I("id");
		$re=M("subject")->where("id=$id")->delete();
	    if($re==true){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
	}
	
	
	public function ajaxDel(){
		$ids=I("id");
		$id = explode(',', $ids);
		$where = "IN ('" . implode("', '", $id) . "')";
		$res = M("student")->where("`id` " . $where)->delete();
		if($res==true){
			$this->ajaxReturn(array('status'=>1, 'msg'=>'恭喜您，操作成功！'));
		}else{
			$this->ajaxReturn(array('status'=>0, 'msg'=>'对不起，操作失败！'));
		}
	}
	

}
?>