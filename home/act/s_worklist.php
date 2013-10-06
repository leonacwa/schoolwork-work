<?php
require('student_init.php');

$data = array();
$limit = 10;

$pn = intval(sget('pn'));
if ($pn < 1) $pn = 1;

$start = ($pn - 1) * $limit;

$group_id = intval( $_SESSION['u']['group_id'] );

$sql = "SELECT * FROM work WHERE is_show = 1 AND work_id IN (SELECT work_id FROM work_auth WHERE group_id = $group_id) ORDER BY start_time DESC, finish_time LIMIT $start, $limit";

$total = intval( get_var("SELECT COUNT(*) FROM `work` WHERE is_show = 1 AND work_id IN (SELECT work_id FROM work_auth WHERE group_id = $group_id)") );
$total_page = ceil($total / $limit);

$data['total'] = $total;
$data['total_page'] = $total_page;
$data['cur_page'] = $pn;


$data['list'] = get_data($sql);
render($data);

