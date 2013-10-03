<?php
$GLOBALS['config'] = array(
	'default_action' => 'index',

	'db_host' => '127.0.0.1',
	'db_port' => 3306,
	'db_user' => 'root',
	'db_password' => '123456',
	'db_name' => 'work',
	'db_charset' => 'utf8',

	'contest_list_size' => 20,
	// 显示用户列表时每页用户数量
	'user_list_size' => 20,

	//正则表达式
	'username_preg' => '/^[a-zA-Z0-9_]{4,32}$/',
	'email_preg' => '/^[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z0-9]{1,20}$/',
	'phone_preg' => '/^\d{3,20}$/',
	'stuid_preg' => '/^\d{10}$/',

	// 用户类型
	'user_type_unknown' => 0,
	'user_type_admin' => 1,
	'user_type_teacher' => 2,
	'user_type_student' => 3,

	//性别的配置
	'gender_male' => 1,
	'gender_female' => 2,

	// 管理员访问权限
	'access_ok' => 0,
	'access_deny' => -1,
	'access_expire' => -2,


	'site_name' => '学生作业管理系统',

);

?>
