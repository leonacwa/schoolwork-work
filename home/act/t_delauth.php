<?php

require('teacher_init.php');

$work_id = intval(sget('work_id'));
$group_id = intval(sget('group_id'));
$un = s(get_login_un());

$work = get_line("SELECT * FROM `work` WHERE work_id = $work_id AND pub_un = '$un'");

if (is_array($work)) {
	$sql = "DELETE FROM `work_auth` WHERE work_id = $work_id AND group_id = $group_id AND pub_un='$un'";
	if (run_sql($sql)) {
		$data['success'] = "删除成功";
		success($data);
	} else {
		$data['error'] = "删除失败！";
		error($data);
	}

} else {
	$data['error'] = "找不到这个作业！";
	error($data);
}
