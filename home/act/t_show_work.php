<?php
require('teacher_init.php');

$work_id = intval(sget('work_id'));
$is_show = intval(sget('is_show'));

$sql = "UPDATE `work` SET is_show = $is_show WHERE `work_id` = $work_id";

if (run_sql($sql)) {
	$data['success'] = "操作成功！";
	success($data);
} else {
	$data['error'] = "操作失败！";
	error($data);
}
