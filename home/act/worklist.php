<?php
require('teacher_init.php');
$data = array();
$limit = 2;

$pn = intval(sget('pn'));
if ($pn < 1) $pn = 1;

$start = ($pn - 1) * $limit;

$sql = "SELECT * FROM `work` ORDER BY start_time DESC, finish_time LIMIT $start, $limit";
$total = intval( get_var("SELECT COUNT(*) FROM `work`") );
$total_page = ceil($total / $limit);

$data['total'] = $total;
$data['total_page'] = $total_page;
$data['cur_page'] = $pn;

$data['list'] = get_data($sql);

render($data);
