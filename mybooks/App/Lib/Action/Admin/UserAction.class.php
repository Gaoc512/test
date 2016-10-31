<?php
class UserAction extends CommonAction {
	public function index(){
		$userid=session('uid');
		$userdata=M("Sysuser")->where("id=$userid")->find();
		$this->assign('userdata',$userdata);
		$this->display();
	}
	
	
	public function updatepwd(){
	     $userid=session('uid');
	     $oldpwd = I('oldpwd', '', 'md5');
	     $newpwd=I('newpwd1','','md5');
	     $checkuser=M('sysuser')->where("id=$userid and password='$oldpwd'")->find();
	     if(!empty($checkuser)){
	     	$editpwd=array(
	     		'password'=>$newpwd
	     	);
	     	$edituser=M("sysuser")->where("id=$userid")->save($editpwd);
	     	if($edituser==true){
	     		$this->success('您的密码有修改，请妥善保管');
	     	}else{
	     		$this->error('系统故障，稍等会儿再试试');
	     	}
	     }else{
	     	$this->error('您输入的原始密码有误，请确保原始密码正确');
	     }
    }
}
?>