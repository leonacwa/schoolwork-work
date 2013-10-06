<?php
require('teacher_init.php');

if (empty($_POST)) {
	$data['error'] = '没有文件';
	error($data);
} else {
	$un = get_login_un();
	require('_uploadfile.php');
	$work_id = intval( spost('work_id') );
	$work = get_line("SELECT * FROM `work` WHERE work_id = $work_id AND pub_un = '$un'");
	if (empty($work)) {
		$data['error'] = "你没有权限进行这个操作!";
		error($data);
	} else {
		$ret = uploadfile($_FILES['work_file'], SITE_ROOT. 'teacher_work'. DIRECTORY_SEPARATOR. "$work_id");
		if ($ret === true) {
			$res = s($_FILES['work_file']['name']);
			$sql = "UPDATE `work` SET `res` = '$res' WHERE work_id = $work_id";
			run_sql( $sql );
			$data['success'] = "上传成功！";
			success($data);
		} else {
			$data['error'] = "上传失败!" . $ret;
			error($data);
		}
	}
}
