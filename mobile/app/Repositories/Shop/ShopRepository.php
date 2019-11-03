<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\shop;

class ShopRepository implements \app\contracts\repository\shop\ShopRepositoryInterface
{
	public function get($id)
	{
		$list = \app\models\SellerShopinfo::select('ru_id', 'shop_name', 'shop_logo')->with(array('MerchantsShopInformation'))->where('id', $id)->get()->toArray();

		if (empty($list)) {
			$list = array();
			return $list;
		}

		foreach ($list as $k => $v) {
			$list[$k]['brandName'] = $v['merchants_shop_information']['shoprz_brandName'];
			unset($list[$k]['merchants_shop_information']);
		}

		return $list;
	}

	public function getPositions($tc_type = 'banner', $num = 3)
	{
		$time = time();
		$res = \app\models\TouchAd::select('ad_id', 'touch_ad.position_id', 'media_type', 'ad_link', 'ad_code', 'ad_name')->with(array('position'))->join('touch_ad_position', 'touch_ad_position.position_id', '=', 'touch_ad.position_id')->where('start_time', '<=', $time)->where('end_time', '>=', $time)->where('enabled', 1)->where('touch_ad_position.tc_type', $tc_type)->orderby('ad_id', 'desc')->limit($num)->get()->toArray();
		$res = array_map(function($v) {
			if (!empty($v['position'])) {
				$temp = array_merge($v, $v['position']);
				unset($temp['position']);
				return $temp;
			}
		}, $res);
		return $res;
	}
}

?>
