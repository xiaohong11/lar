<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
define('BIND_MODULE', 'Respond');
define('BIND_CONTROLLER', 'Index');
define('BIND_ACTION', 'notify');
$_GET['code'] = basename(__FILE__, '.php');
require __DIR__ . '/../../index.php';

?>
