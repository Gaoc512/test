<?php
return array(
	//'配置项'=>'配置值'
	//开启应用分组
	'APP_GROUP_LIST' => 'Index,Admin',
	'DEFAULT_GROUP' => 'Index',
   
	//数据库连接参数
	/*
	'DB_HOST' => '123.57.23.91',
	'DB_USER' => 'tdbook',
	'DB_PWD' => 'touchdelight',
	'DB_NAME' => 'books',
	 'DB_PREFIX' => '',
	 'DB_PORT'=>'3307',
	 */
 	 'DB_HOST' => 'localhost',
 	'DB_USER' => 'root',
 	'DB_PWD' => '',
 	 'DB_NAME' => 'mybooks_test',
 	 'DB_PREFIX' => '',
	 'DB_PORT'=>'3306',
	//接下来配置主从数据库
     'DB_DEPLOY_TYPE'=>1,//开启分布式数据库
     'DB_RW_SEPARATE'=>false,//读写分离，默认第一台服务器为写入服务器，其它的只读取不写入

	//点语法默认解析
	'TMPL_VAR_IDENTIFY' => 'array',

	//模板路径
//	'TMPL_FILE_DEPR' => '_',
	'HOST'=>'http://106.38.65.206:8010',
	//默认过滤函数
	'DEFAULT_FILTER' => 'htmlspecialchars',
	'LOG_RECORD' => false,
	'UPLOAD' => __ROOT__
);
?>