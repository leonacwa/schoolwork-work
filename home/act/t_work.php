<?php
require('teacher_init.php');

$work_id = intval(sget('work_id'));
$un = s(get_login_un());

$work = get_line("SELECT * FROM `work` WHERE work_id = $work_id AND pub_un = '$un'");

if (is_array($work)) {
	$sql_gp = "SELECT `work_auth`.work_id AS work_id, `work_auth`.group_id AS group_id, `work_auth`.pub_un AS pub_un, `group`.name AS name FROM `work_auth` INNER JOIN `group` ON `work_auth`.work_id = $work_id AND pub_un = '$un' AND `work_auth`.group_id = `group`.group_id";

	$auth_gp = get_data($sql_gp);
	if (empty($auth_gp)) $auth_gp = array();

	$all_gp = get_data("SELECT * FROM `group`");
	if (empty($all_gp)) $all_gp = array();

	$data['auth_gp'] = $auth_gp;
	$data['all_gp'] = $all_gp;
	$data['work'] = $work;
	render($data);
} else {
	$data['error'] = "找不到这个作业！";
	error($data);
}
