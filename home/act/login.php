<?php

$data = array();
$data['top_title'] = "登录";

if (is_login()) {
	if (c('user_type_teacher') == $u['type']) {
		go('teacher');
	} else if (c('user_type_student') == $u['type']) {
		go('student');
	}
}

if (empty($_POST)) {
	render($data, 'login');
} else {
	try {
		$un = spost('un');
		$pw = $_POST['pw'];
		$data['un'] = $un;

		if (is_null($un) or $un == '' or is_null($pw) or $pw == '') {
			throw new Exception('用户名和密码不能为空！');
		}
		$pw = encode_password( $pw );
		$u = get_line("SELECT * FROM user WHERE un = '$un' AND pw = '$pw'");
		if (empty($u)) {
			throw new Exception('用户名或者密码错误，请仔细核对！');
		}
		unset( $u['pw'] );
		$_SESSION['u'] = $u;
		if (c('user_type_teacher') == $u['type']) {
			go('teacher');
		} else if (c('user_type_student') == $u['type']) {
			go('student');
		} else {
			throw new Exception('user Type Error!');
		}
	} catch (Exception $e) {
		$data['error'] = $e->getMessage();
		render($data, 'login');
	}
}
?>
