<?php
// ----------------------------------------------------
// �������һЩȫ�����õ��ĺ���

function encode_password($pw) {
	return md5( $pw );
}

function is_login() {
	return !empty($_SESSION['u']) && is_array($_SESSION['u']);
}

// --------------------------------------------------------

function forward($url) {
	header("location:$url");
}

function go($act, $p='') {
	$url = '?act='.$act . ($p == '' ? '' : '&'.$p);
	header("location:$url");
}

function go_url($act, $p='') {
	return '?act='.$act . ($p == '' ? '' : '&'.$p);
}
?>
