<?php
define( 'AROOT' , dirname( __FILE__ ) . DIRECTORY_SEPARATOR. 'home'. DIRECTORY_SEPARATOR  );
define( 'LIB_PATH' , dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'lib'. DIRECTORY_SEPARATOR  );

ob_start();
//-----------------------------------
//开启计时器
require(LIB_PATH. 'timer.php');
timer_start();
//获取配置项
require('config.php');
//引用全局过程
require(LIB_PATH. 'core.function.php');
require(LIB_PATH. 'global.function.php');
require(LIB_PATH. 'home.function.php');

// --------------------------

// -------------------------------

session_start();

action($GLOBALS['act']);
ob_end_flush();
?>
