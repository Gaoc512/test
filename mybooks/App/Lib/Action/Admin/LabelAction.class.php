<?php
class LabelAction extends CommonAction {
    public function index(){
    	import('ORG.Util.Page');// 导入分页类
		$count = M("booklabel")->count();// 查询满足要求的总记录数 $map表示查询条件
	   	$Page = new Page($count,15);// 实例化分页类 传入总记录数
	   	$show = $Page->show();// 分页显示输出
	   	$data=M("booklabel")->order("createtime desc")->limit($Page->firstRow.','.$Page->listRows)->select();
	   	$this->assign('data',$data);// 赋值分页输出
	   	$this->assign('page',$show);
	   	$this->display();
    }


	public function add(){
		if($_POST){
			$title=I("title");
			$add=array(
				'title'=>$title,
				'createtime'=>date('Y-m-d H:i:s')
			);
			$re=M("booklabel")->add($add);
			if($re==true){
				$this->success("创建成功",U('index'));
			}else{
				$this->error("创建失败");
			}
		}else{
			$this->display();
		}
	}
	
	public function edit(){
		if($_POST){
			$id=I("id");
			$edit=array(
			'title'=>I('title')
			);
			$re=M("booklabel")->where("id=$id")->save($edit);
			if($re==true){
				$this->success("修改成功",U('index'));
			}else{
				$this->error("修改失败");
			}
		}else{
			$id=I("id");
			$data=M("booklabel")->where("id=$id")->find();
			$this->assign('data',$data);
			$this->display();
		}
	}
	
	
	public function del(){
		$id=I("id");
		$re=M("booklabel")->where("id=$id")->delete();
	    if($re==true){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
	}
}
?>