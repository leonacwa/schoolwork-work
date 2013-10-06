<?php

require('teacher_init.php');

$group_id = intval(sget('group_id'));

$sql = "DELETE FROM `group` WHERE group_id = $group_id";

if (run_sql($sql)) {
	$data['success'] = "删除成功";
	success($data);
} else {
	$data['error'] = "删除失败！";
	error($data);
}

