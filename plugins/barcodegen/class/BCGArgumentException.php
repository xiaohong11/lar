<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
class BCGArgumentException extends Exception
{
	protected $param;

	public function __construct($message, $param)
	{
		$this->param = $param;
		parent::__construct($message, 20000);
	}
}

?>
