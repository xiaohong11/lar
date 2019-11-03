<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\api\v2\shop\controllers;

class Shop extends \app\api\foundation\Controller
{
	/**
     * @var ShopRepository
     */
	protected $shop;
	/**
     * @var ShopTransformer
     */
	protected $shopTransformer;

	public function __construct(\app\repositories\shop\ShopRepository $shop, \app\api\v2\shop\transformer\ShopTransformer $shopTransformer)
	{
		parent::__construct();
		$this->shop = $shop;
		$this->shopTransformer = $shopTransformer;
	}

	public function actionGet(array $args)
	{
		$pattern = array('id' => 'require');
		$this->validate($args, $pattern);
		$list = $this->shop->get($args['id']);
		return $this->apiReturn($list);
	}
}

?>
