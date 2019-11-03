<?php
//Դ��������:ecshop2012���� δ�������ֹ���� һ������ֹͣ�κη���
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
