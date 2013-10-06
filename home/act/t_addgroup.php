<?php

require('teacher_init.php');

$name = s(spost('name'));
$pinyin = s(spost('pinyin'));

$sql = "INSERT INTO `group` (`name`, `pinyin`) VALUES('$name', '$pinyin')";

if (run_sql($sql)) {
	$data['success'] = "增加成功";
	success($data);
} else {
	$data['error'] = "增加失败！";
	error($data);
}

