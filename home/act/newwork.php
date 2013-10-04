<?php
require('teacher_init.php');

if (empty($_POST)) {
	render();
} else {
	$title = spost('title');
	$is_show = spost('is_show');
	$start_time = strtotime(spost('start_time').':00');
	$finish_time = strtotime(spost('finish_time').':00');
	$intro = spost('intro');
	$pub_un = get_login_un();

	if (empty($title)) {
		$data['error'] = "标题不能为空";
		render( $data );
		return;
	}

	$sql_tpl = "INSERT INTO `work` (`title`, `intro`, `start_time`, `finish_time`, `pub_un`, `is_show`, `res`) VALUES ";
	$sql = sprintf($sql_tpl ."('%s', '%s', '%s', '%s', '%s', '%s', '')", $title, $intro, $start_time, $finish_time, $pub_un, $is_show);

	if (run_sql( $sql ) ) {
		$id = last_id();
		$data['success'] = "新建比赛成功！";
		$data['jump_url'] = go_url('t_work', "work_id=$id");
		success( $data );
	} else  {
		$data['error'] = "新建比赛失败！ 请仔细检查输入";
		render($data);
	}
}
