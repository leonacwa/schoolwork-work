<?php

//--------------------------------------------------------------------------
//调用action
function action($act) {
	$act_file = AROOT . 'act'. DIRECTORY_SEPARATOR . $act . '.php';
	if( file_exists( $act_file ) ) {
		include($act_file);
	} else {
		die("Can't  find act:$act!\n");
	}
}

//调用模版
function render($data=null, $tpl = 'default') {
	if (!$tpl) {
		$tpl= $GLOBALS['act'];
	}
	$tpl_file = AROOT . 'tpl' .DIRECTORY_SEPARATOR. $tpl . '.html';
	if( file_exists( $tpl_file ) ) {
		@extract( $data );
		require( $tpl_file);
	} else {
		die("Can't find template $tpl!\n");
	}
}
// 错误页
function error($data, $tpl='error') {
	if (!isset($data['top_title'])) {
		$data['top_title'] = "失败";
	}
	render($data, $tpl);
	die();
}
// 成功页
function success($data, $tpl='success') {
	if (!isset($data['top_title'])) {
		$data['top_title'] = "成功";
	}
	render($data, $tpl);
	die();
}

//--------------------------------------------------------------------------
// db functions
function db( $host = null , $port = null , $user = null , $password = null , $db_name = null, $db_charset = null ) {
	$config = &$GLOBALS['config'];
	if( $host == null ) $host = $config['db_host'];
	if( $port == null ) $port = $config['db_port'];
	if( $user == null ) $user = $config['db_user'];
	if( $password == null ) $password = $config['db_password'];
	if( $db_name == null ) $db_name = $config['db_name'];
	if( $db_charset == null ) $db_charset = $config['db_charset'];

	$db_key = 'DB_'.MD5( $host .'-'. $port .'-'. $user .'-'. $password .'-'. $db_name .'-'. $db_charset  );

	if ( !isset( $GLOBALS[$db_key] ) ) {
		if( !$GLOBALS[$db_key] = mysqli_connect( $host , $user , $password , $db_name, $port) ) {

			//echo 'can\'t connect to database';
			$GLOBALS['DB_CONNECT_ERROR'] = true;
			$GLOBALS['DB_CONNECT_ERROR_INFO'] = 'can\'t connect to database';
			return false;
		}

		if(@mysqli_query( $GLOBALS[$db_key] , "SET NAMES '$db_charset'" )) {
			$GLOBALS['LP_DB_CONNECT_ERROR'] = false;
			$GLOBALS['LP_DB_CONNECT_ERROR_INFO'] = '' ;
		}
	}

	return $GLOBALS[$db_key];
}

//带缓存的sql查询，默认不缓存
//传入缓存时间，单位(s)，0为永久缓存
function get_data( $sql , $db = NULL ) {
	if( $db == NULL ) $db = db();

	//$GLOBALS['SQL_LIST'][] = array(microtime(), $sql); // 跟踪SQL语句

	$GLOBALS['LAST_SQL'] = $sql;
	$data = Array();

	$result = mysqli_query($db , $sql ); 
	if( mysqli_errno($db) != 0 ) echo mysqli_error($db) .' ' . $sql;

	while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC ) ) {
		$data[] = $row;
	}

	if( mysqli_errno($db) != 0 )
		echo mysqli_error($db) .' ' . $sql;

	mysqli_free_result($result); 

	if( count( $data ) > 0 ) {
		return $data;
	} else {
		return false;
	}
}
function get_line( $sql , $db = NULL ) {
	$data = get_data( $sql , $db  );
	return @reset($data);
}
function get_var( $sql , $db = NULL ) {
	$data = get_line( $sql , $db );
	return $data[ @reset(@array_keys( $data )) ];
}
//执行非查询类的query
function run_sql($strSql) {
	return mysqli_query(db(), $strSql);
}
// 获取最后插入的ID
function last_id( $db = NULL ) {
	if( $db == NULL ) $db = db();
	return get_var( "SELECT LAST_INSERT_ID() " , $db );
}

// -----------------------------------------------------------------------------------
// 把不能构成函数名的部分去掉
function func_name($str) {
	$str = trim($str);
	$len = strlen($str);
	$ret = '';
	for ($i = 0; $i < $len; $i++) {
		if (ctype_alnum($str[$i]) || $str[$i] == '_') {
			$ret .= $str[$i];
		}
	}
	return $ret;
}

function v( $str ) {
	return isset( $_REQUEST[$str] ) ? $_REQUEST[$str] : null;
}
//
function s( $str , $db = NULL ) {
	if( $db == NULL ) $db = db();
	return  mysqli_real_escape_string( $db, $str )  ;
}

function sget($key, $db=NULL) {
	if (isset($_GET[$key])) return s($_GET[$key], $db);
	return null;
}

function spost($key, $db=NULL) {
	if (isset($_POST[$key])) return s($_POST[$key], $db);
	return null;
}

function transs(&$aList, $db = NULL) {
	if( $db == NULL ) $db = db();
	if (is_string($aList)) {
		return  mysqli_real_escape_string( $db, $aList )  ;
	}
	foreach ($aList as $key => &$value) {
		if (is_array($value)) {
			transs($value, $db);
		} else if (is_string($value)) {
			$value = mysqli_real_escape_string( $db , $value );
		}
	}
	return $aList;
}

// 将用单引号转义字符串的去掉转义
function transcribe($aList, $aIsTopLevel = true) {
	$gpcList = array();
	$isMagic = get_magic_quotes_gpc();

	foreach ($aList as $key => $value) {
		if (is_array($value)) {
			$decodedKey = ($isMagic && !$aIsTopLevel)?stripslashes($key):$key;
			$decodedValue = transcribe($value, false);
		} else {
			$decodedKey = stripslashes($key);
			$decodedValue = ($isMagic)?stripslashes($value):$value;
		}
		$gpcList[$decodedKey] = $decodedValue;
	}
	return $gpcList;
}
$_GET = transcribe( $_GET ); 
$_POST = transcribe( $_POST ); 
$_REQUEST = transcribe( $_REQUEST );

//--------------------------------------------------------------------------
// 获取和设置配置，$value为null时获取参数，否则设置参数
function c($key, $value=null) {
	if (is_null($value)) {
		if (isset($GLOBALS['config'][$key])) return $GLOBALS['config'][$key];
	} else {
		return $GLOBALS['config'][$key] = $value;
	}
}
// 获取和设置全局变量，$value为null时获取参数，否则设置参数
function g($key, $value=null) {
	if (is_null($value)) {
		if (isset($GLOBALS[$key])) return $GLOBALS[$key];
	} else {
		return $GLOBALS[$key] = $value;
	}
}
// 对$_SESSION数组进行操作
function ss($key, $value=null) {
	if (is_null($value)) {
		if (isset($_SESSION[$key])) return $_SESSION[$key];
	} else {
		return $_SESSION[$key] = $value;
	}
	return null;
}

function dump($var) {
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}
function export($var) {
	echo '<pre>';
	var_export($var);
	echo '</pre>';
}

//-------------- Working -----------------------

ini_set('date.timezone','Asia/Shanghai');

// ---- config 已经在config.php产生,这里需要增加数据库的中config表设置的config
/*
$res = get_data("SELECT * FROM config");
foreach ($res as $key => &$value) {
	$GLOBALS['config'][$value['key']] = $value['value'];
}
*/

$GLOBALS['act'] = func_name( v('act') ? v('act') : $GLOBALS['config']['default_action']);

?>
