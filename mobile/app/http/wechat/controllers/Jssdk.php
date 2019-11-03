<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace app\http\wechat\controllers;

class Jssdk extends \app\http\base\controllers\Frontend
{
	public function actionIndex()
	{
		$url = addslashes($_POST['url']);

		if ($url != '') {
			$wxConf = $this->getConfig();
			$this->wechat = new \Touch\Wechat($wxConf);
			$sdk = $this->wechat->getJsSign($url);
			$data = array('status' => '200', 'data' => $sdk);
		}
		else {
			$data = array('status' => '100', 'message' => '缺少参数');
		}

		exit(json_encode($data));
	}

	private function getConfig()
	{
		return dao('wechat')->field('id, token, appid, appsecret, encodingaeskey')->where(array('status' => 1, 'default_wx' => 1))->find();
	}
}

?>
