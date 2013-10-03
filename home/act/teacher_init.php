<?php
if (is_login() == false) {
	go('login');
}

if ($_SESSION['u']['type'] != c('user_type_teacher')) {
	error(array('error' => '你不是教师，无权进行这项操作！'));
}

