<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\services;

class GoodsService
{
	private $goodsRepository;

	public function __construct(\app\repositories\goods\GoodsRepository $goodsRepository)
	{
		$this->goodsRepository = $goodsRepository;
	}

	public function getGoodsList($categoryId = '', $page = 1)
	{
		$page = (empty($page) ? 1 : $page);
		$size = 10;
		$field = array('goods_id', 'goods_name', 'shop_price', 'goods_thumb', 'goods_number', 'market_price', 'sales_volume');
		$list = $this->goodsRepository->findBy('category', $categoryId, $page, $size, $field);
		return $list;
	}

	public function goodsDetail($id)
	{
		$result = array('goods_img' => '', 'goods_info' => '', 'goods_comment' => '', 'goods_properties' => '');
		$result['goods_comment'] = $this->goodsRepository->goodsComment($id);
		$result['goods_info'] = $this->goodsRepository->goodsInfo($id);
		$result['goods_img'] = $this->goodsRepository->goodsGallery($id);
		$result['goods_properties'] = $this->goodsRepository->goodsProperties($id);
		return $result;
	}

	public function goodsPropertiesPrice($args)
	{
		$goodsId = $args['goods_id'];
		return 1692;
	}
}


?>
