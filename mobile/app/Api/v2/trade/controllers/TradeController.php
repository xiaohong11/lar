<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\trade;

class TradeController extends \app\api\foundation\Controller
{
	protected $trade;
	protected $tradeTransformer;

	public function __construct(\app\repositories\trade\TradeRepository $trade, transformer\TradeTransformer $tradeTransformer)
	{
		parent::__construct();
		$this->trade = $trade;
		$this->tradeTransformer = $tradeTransformer;
	}

	public function actionGet()
	{
	}
}

?>
