<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\services;

class IndexService
{
	private $goodsRepository;
	private $shopRepository;
	private $root_url;

	public function __construct(\app\repositories\goods\GoodsRepository $goodsRepository, \app\repositories\shop\ShopRepository $shopRepository)
	{
		$this->goodsRepository = $goodsRepository;
		$this->shopRepository = $shopRepository;
		$this->root_url = dirname(__URL__) . '/';
	}

	public function bestGoodsList()
	{
		$arr = array('goods_id', 'goods_name', 'shop_price', 'goods_thumb', 'goods_link', 'goods_number', 'market_price', 'sales_volume');
		$goodsList = $this->goodsRepository->findByType('best');
		$data = array_map(function($v) use($arr) {
			foreach ($v as $ck => $cv) {
				if (!in_array($ck, $arr)) {
					unset($v[$ck]);
				}
			}

			$v['goods_thumb'] = dirname($this->root_url) . $v['goods_thumb'];
			$v['goods_sales'] = $v['sales_volume'];
			$v['goods_stock'] = $v['goods_number'];
			unset($v['goods_number']);
			unset($v['sales_volume']);
			return $v;
		}, $goodsList);
		return $data;
	}

	public function getBanners()
	{
		$res = $this->shopRepository->getPositions('banner', 3);
		$ads = array();

		foreach ($res as $row) {
			if (!empty($row['position_id'])) {
				$src = ((strpos($row['ad_code'], 'http://') === false) && (strpos($row['ad_code'], 'https://') === false) ? 'data/afficheimg/' . $row['ad_code'] : $row['ad_code']);
				$ads[] = array('pic' => $this->root_url . $src, 'banner_id' => $row['ad_id']);
			}
		}

		return $ads;
	}

	public function getAdsense()
	{
		$adsense = $this->shopRepository->getPositions('', 3);
		$ads = array();

		foreach ($adsense as $row) {
			if (!empty($row['position_id'])) {
				$src = ((strpos($row['ad_code'], 'http://') === false) && (strpos($row['ad_code'], 'https://') === false) ? 'data/afficheimg/' . $row['ad_code'] : $row['ad_code']);
				$ads[] = array('pic' => $this->root_url . $src, 'adsense_id' => $row['ad_id']);
			}
		}

		return $ads;
	}
}


?>
