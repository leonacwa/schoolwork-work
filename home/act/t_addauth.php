<?php

require('teacher_init.php');

$work_id = intval(sget('work_id'));
$group_id = intval(sget('group_id'));
$un = s(get_login_un());

$work = get_line("SELECT * FROM `work` WHERE work_id = $work_id AND pub_un = '$un'");

if (is_array($work)) {
	$sql = "INSERT INTO `work_auth` (`work_id`, `group_id`, `pub_un`) VALUES($work_id, $group_id, '$un')";
	if (run_sql($sql)) {
		$data['success'] = "增加成功";
		success($data);
	} else {
		$data['error'] = "增加失败！";
		error($data);
	}

} else {
	$data['error'] = "找不到这个作业！";
	error($data);
}
