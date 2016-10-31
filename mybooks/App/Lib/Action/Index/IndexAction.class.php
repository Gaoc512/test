<?php
class IndexAction extends Action {
	

	public function index(){
	
		header("Content-type:text/html;charset=utf-8");
		
		if($_POST){
			$stu_code=I("stu_code");
			$stu_pwd=I("stu_pwd");
			$student = M("student")->where("stu_code='$stu_code' and stu_pwd='$stu_pwd'")->find();
			$schid = $student['sch_id'];
			if($schid == null){				
				echo "<script>alert('该账号不存在或密码错误,请检查编号或密码');</script>";
				exit;
			}
			$test_school = M('test_school')->where("schid=$schid")->select();

			foreach($test_school as $key=>$value){
				$bookreport = M('bookreports')->where("schid='$schid' and tid='$value[tid]' and stuid='$student[id]'")->find();
				if($bookreport != false){
					continue;
				}else if(strtotime($value['endtime'])<time() || strtotime($value['starttime'])>time()){
					/*
					echo "<script>alert('该账号目前不能参加测试。请仔细阅读“致家长的一封信”，特别是测试时间部分，请在指定时间范围内登录系统测试。');</script>";
					exit();	
					*/
					continue;
				}else{
					session('uid',$student['id']);
					session('tid',$value['tid']);
					session('schid',$schid);
					if($student['grade']=='一年级' || $student['grade']=='二年级' || $student['grade']=='三年级'){
						$array = array(1,2,3,4,5,6);
					 	shuffle($array);
						$_SESSION["result"]=$array; 			
						$this->redirect('Child/child');//显示小学生
					}else if($student['grade']=='四年级' || $student['grade']=='五年级' || $student['grade']=='六年级'){
						$this->redirect('Senior/high');//显示小学生
					}else{
						echo "<script>alert('grade error');</script>";
						exit();
					}
				}
			}
			echo "<script>alert('该账号暂不能测试。');</script>";
			exit();	
		}else{
			//session_destroy();
			$this->display();
		}
	}
	
	
	
	
	
}

?>