<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
if (!isset($_SERVER)) {
	$_SERVER = $HTTP_SERVER_VARS;
}

if (!isset($_GET)) {
	$_GET = $HTTP_GET_VARS;
}

if (!isset($_FILES)) {
	$_FILES = $HTTP_POST_FILES;
}

if (!defined('DIRECTORY_SEPARATOR')) {
	define('DIRECTORY_SEPARATOR', strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ? '\\' : '/');
}

?>
