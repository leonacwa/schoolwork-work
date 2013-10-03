<?php
if (is_login() == false) {
	go('login');
}

if ($_SESSION['u']['type'] != c('user_type_student')) {
	error(array('error' => '你不是学生，无权进行这项操作！'));
}

