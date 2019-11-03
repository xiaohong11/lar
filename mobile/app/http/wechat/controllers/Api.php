<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace app\http\wechat\controllers;

class Api extends \app\http\base\controllers\Frontend
{
	public $user_id = 0;
	public $code = '';
	public $pushData = '';
	public $url = '';

	public function __construct()
	{
		parent::__construct();
		$this->user_id = I('get.user_id', 0, 'intval');
		$this->code = I('get.code', '', 'trim');
		$this->pushData = I('get.pushData', '', 'trim');
		$this->url = I('get.url', '');
		$this->url = $this->url ? base64_decode(urldecode($this->url)) : '';
	}

	public function actionIndex()
	{
		$user_id = $this->user_id;
		$code = $this->code;
		$this->pushData = stripslashes(urldecode($this->pushData));
		$pushData = unserialize($this->pushData);
		$url = $this->url;
		push_template($code, $pushData, $url, $user_id);
	}
}

?>
