<?php
require('teacher_init.php');
$data = array();
$limit = 10;

$pn = intval(sget('pn'));
if ($pn < 1) $pn = 1;

$start = ($pn - 1) * $limit;

$sql = "SELECT * FROM `group` ORDER BY pinyin LIMIT $start, $limit";
$total = intval( get_var("SELECT COUNT(*) FROM `group`") );
$total_page = ceil( $total / $limit );

$data['total'] = $total;
$data['cur_page'] = $pn;
$data['total_page'] = $total_page;

$data['list'] = get_data($sql);
render($data);
