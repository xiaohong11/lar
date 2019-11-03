<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\index\controllers;

class Guide extends \app\api\foundation\Controller
{
	private $testAllApis;

	public function __construct(\app\api\foundation\TestAllApis $testAllApis)
	{
		parent::__construct();
		$this->testAllApis = $testAllApis;
	}

	public function actionIndex()
	{
	}

	public function actionTest()
	{
		$this->testAllApis->addApis(array('method' => 'ecapi.brand.list2'));
		$res = $this->testAllApis->test();
		return $this->apiReturn($res);
	}
}

?>
