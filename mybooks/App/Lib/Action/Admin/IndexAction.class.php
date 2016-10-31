<?php
/**
* 后台首页
*/
class IndexAction extends CommonAction
{
	
	public function index()	{
     $Username=$_SESSION['username'];
    	//echo $_SESSION['username'];
    	$this->assign('username',$Username);
        $this->display();
	}


	public function logout() {
		session_unset();
		session_destroy();
		
		$this -> redirect('Admin/Login/index');

	}
	
	public function main(){
		$this->display();
	}
}
?>