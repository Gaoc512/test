<?php
//定义项目名称和路径
define('APP_NAME', 'App');
define('APP_PATH', './App/');
define('APP_DEBUG',TRUE);
define('APP_ABSOLUTE_PATH',dirname(__FILE__));
define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('UPLOAD', 'http://106.38.65.206:8010/Upload/picimg/');
define('AdminImg', 'http://106.38.65.206:8010/App/Tpl/Admin/Public/img/');
$appRelativePath='/'.substr(APP_ABSOLUTE_PATH,strlen(DOCUMENT_ROOT)+1);
	//if($appRelativePath=='/'){
		//$appRelativePath='';
	//}
	define('APP_RELATIVE_PATH',$appRelativePath);
// 加载框架入口文件
require( "./ThinkPHP/ThinkPHP.php");