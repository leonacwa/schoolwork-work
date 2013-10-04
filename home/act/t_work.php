<?php
require('teacher_init.php');

$work_id = intval(sget('work_id'));
$work = get_line("SELECT * FROM `work` WHERE work_id = $work_id");

if (is_array($work)) {
	$data['work'] = $work;
	render($data);
} else {
	$data['error'] = "找不到这个作业！";
	error($data);
}
