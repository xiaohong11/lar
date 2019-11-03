<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\custom\site\controllers;

class Send extends \app\http\site\controllers\Index
{
	public function actionTest()
	{
		$message = array('code' => '1234', 'product' => 'sitename');
		$res = send_sms('18801828888', 'sms_signin', $message);

		if ($res !== true) {
			exit($res);
		}

		$res = send_mail('xxx', 'wanglin@ecmoban.com', 'title', 'content');

		if ($res !== true) {
			exit($res);
		}
	}
}

?>
