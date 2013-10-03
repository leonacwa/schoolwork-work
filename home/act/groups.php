<?php
require('teacher_init.php');
$data = array();
$limit = 30;

$pn = intval(sget('pn'));
if ($pn < 1) $pn = 1;

$start = ($pn - 1) * $limit;

$sql = "SELECT * FROM `group` ORDER BY pinyin LIMIT $start, $limit";

$data['list'] = get_data($sql);
render($data);
