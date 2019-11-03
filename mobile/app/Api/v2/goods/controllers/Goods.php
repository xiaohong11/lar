<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\goods\controllers;

class Goods extends \app\api\foundation\Controller
{
	/** @var  $goods */
	protected $goods;
	/** @var  $goodsTransport */
	protected $goodsTransport;

	public function __construct(\app\repositories\goods\GoodsRepository $goods, \app\models\GoodsTransport $goodsTransport)
	{
		parent::__construct();
		$this->goods = $goods;
		$this->goodsTransport = $goodsTransport;
	}

	public function actionList()
	{
	}

	public function actionDetail()
	{
	}

	public function actionSku()
	{
	}

	public function actionFittings()
	{
	}
}

?>
