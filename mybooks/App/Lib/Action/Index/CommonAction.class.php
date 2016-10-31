<?php
class CommonAction extends Action {
     public function _initialize(){
     	$uid=$_SESSION['uid'];
     	if(empty($uid)){
     		$this->redirect('Index/login');
     	}
     }
	
}
?>