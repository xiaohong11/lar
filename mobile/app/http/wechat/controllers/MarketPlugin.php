<?php
//源码由旺旺:ecshop2012所有 未经允许禁止倒卖 一经发现停止任何服务
namespace app\http\wechat\controllers;

abstract class MarketPlugin extends \app\http\base\controllers\Foundation
{
	protected $_data = array();

	abstract protected function returnData($fromusername, $info);

	abstract protected function updatePoint($fromusername, $info);

	abstract protected function executeAction();

	public function market_display($tpl = '', $config = array())
	{
		$this->_data['config'] = $config;
		$this->assign($this->_data);
		$tpl = 'app/modules/wechatmarket/' . $this->marketing_type . '/views/' . $tpl . C('TMPL_TEMPLATE_SUFFIX');
		$this->template_content = $this->fetch(ROOT_PATH . $tpl);
		$this->assign('template_content', $this->template_content);
		$this->display('wechat@market.layout');
	}

	public function __get($name)
	{
		return isset($this->_data[$name]) ? $this->_data[$name] : null;
	}

	public function __set($name, $value)
	{
		$this->_data[$name] = $value;
	}
}

?>
