<?php
require('student_init.php');

$work_id = intval(sget('work_id'));
$group_id = intval( $_SESSION['u']['group_id'] );

$auth = get_line("SELECT * FROM `work_auth` WHERE work_id = $work_id AND group_id = $group_id");


if (is_array($auth)) {
	$work = get_line("SELECT * FROM `work` WHERE work_id = $work_id AND is_show = 1");


	if ($work) {
		$sql_gp = "SELECT `work_auth`.work_id AS work_id, `work_auth`.group_id AS group_id, `work_auth`.pub_un AS pub_un, `group`.name AS name FROM `work_auth` INNER JOIN `group` ON `work_auth`.work_id = $work_id AND `work_auth`.group_id = `group`.group_id";

		$auth_gp = get_data($sql_gp);
		if (empty($auth_gp)) $auth_gp = array();

		$data['auth_gp'] = $auth_gp;

		$data['work'] = $work;
		render($data);
	} else {
		$data['error'] = "找不到这个作业！";
		error($data);
	}
} else {
	$data['error'] = "你无权查看！";
	error($data);
}
