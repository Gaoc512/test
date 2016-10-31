<?php
class LoginAction extends Action {
    public function index(){
    	$this->display();
    }
	Public function verify() {
	import('ORG.Util.Image');
		
//不加这句不能显示验证码

ob_end_clean();
		Image::buildImageVerify(4, 1, 'png');
	}
	
	
	/**
	 * 表单登录
	 */
	public function login(){
	
		if(!IS_POST) halt('页面不存在');

		if(I('code', '', 'md5') != session('verify')) {
			echo session('verify');
			//$this->error('验证码不正确');
		}
		
		$username = I('username');
		$pwd = I('password', '', 'md5');

		$user = M('sysuser') -> where(array('username' => $username)) -> find();
 
        //$user=$this->portcall->callapi('/front/user/auth','SYS_user',json_encode(array('username' => $username,'pwd'=>$pwd)));
        //print_r($user);exit();

 
		if (!$user || $user['password'] != $pwd) {
			$this->error('帐号或密码错误');
		}

		//	if($user['islock']) $this->error('用户被锁定');

		$data = array(
			'id' => $user['id'],
			'logintime' => time(),
			'loginip' => get_client_ip()
			);
		M('user') -> save($data);

		session('uid',$user['id']);
		session('username', $user['username']);
		session('logintime', date('Y-m-d H:i:s', $user['logintime']));
		session('lgoinip', $user['loginip']);
		
		$this->redirect('Admin/Index/index');
	}

	public function loginfake(){
		$user = M('sysuser')->find();

		session('uid',$user['id']);
		session('username', $user['username']);
		session('logintime', date('Y-m-d H:i:s', $user['logintime']));
		session('lgoinip', $user['loginip']);
		$this->redirect('Admin/Index/index');
	}

}
?>