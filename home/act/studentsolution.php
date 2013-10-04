<?php
require('teacher_init.php');
$data = array();
$limit = 30;

$pn = intval(sget('pn'));
$work_id = intval(sget('work_id'));

if ($pn < 1) $pn = 1;

$start = ($pn - 1) * $limit;

$work = get_line("SELECT * FROM `work` WHERE work_id = $work_id");

if (is_array($work)) {

	$data['work'] = $work;
	$sql = "SELECT * FROM solution WHERE work_id = $work_id ORDER BY submit_time DESC, work_id DESC LIMIT $start, $limit";
	$data['list'] = get_data($sql);

	$total = intval( get_var( "SELECT COUNT(*) FROM solution WHERE work_id = $work_id ") );

	$data['work_id'] = $work_id;

} else {

	$sql = "SELECT * FROM solution ORDER BY submit_time DESC, work_id DESC LIMIT $start, $limit";
	$total = intval( get_var( "SELECT COUNT(*) FROM solution ") );

	$data['list'] = get_data($sql);
}

$data['pn'] = $pn;

$data['total'] = $total;
$data['total_page'] = ceil($total / $limit);

render($data);
