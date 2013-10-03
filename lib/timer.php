<?php
$page_start_time;
function timer_start() {
	global $page_start_time;
	list($usec, $sec) = explode(' ', microtime());
	$page_start_time = ((float)$usec + (float)$sec);
}
function timer_spent() {
	global $page_start_time;
	list($usec, $sec) = explode(' ', microtime());
	return ((float)$usec + (float)$sec - $page_start_time);
}
?>
