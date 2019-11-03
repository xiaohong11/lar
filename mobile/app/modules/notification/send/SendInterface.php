<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\modules\notification\send;

interface SendInterface
{
	public function __construct($config);

	public function push($to, $title, $content, $data = array());

	public function getError();
}


?>
