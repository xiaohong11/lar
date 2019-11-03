<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\shipping;

class ShippingRepository implements \app\contracts\repository\shipping\ShippingRepositoryInterface
{
	public function shippingList()
	{
		$shippingList = \app\models\Shipping::select('*')->get()->toArray();
		return $shippingList;
	}

	public function find($id)
	{
		$shipping = \app\models\Shipping::select('*')->where('shipping_id', $id)->where('enabled', 1)->first();

		if ($shipping === null) {
			return array();
		}

		return $shipping->toArray();
	}

	public function total_shipping_fee($address, $products, $shipping_id)
	{
		$uid = Token::authorization();
		$prefix = Yii::$app->db->tablePrefix;
		$weight = 0;
		$amount = 0;
		$number = 0;
		$IsShippingFree = true;

		if (isset($products)) {
			foreach ($products as $product) {
				$goods_weight = Goods::find()->select(array('goods_weight'))->where(array('goods_id' => $product['goods_id']))->column();
				$goods_weight = (0 < count($goods_weight) ? $goods_weight[0] : 0);

				if ($goods_weight) {
					$weight += $goods_weight * $product['goods_number'];
				}

				$amount += Goods::get_final_price($product['goods_id'], $product['goods_number']);
				$number += $product['goods_number'];

				if (!intval($product['is_shipping'])) {
					$IsShippingFree = false;
				}
			}
		}

		if ($IsShippingFree) {
			return 0;
		}

		if (!empty($address)) {
			$region_id_list = UserAddress::getRegionIdList($address);
		}

		$model = \app\models\Shipping::find()->select(array($prefix . 'shipping_area.configure', $prefix . 'shipping.shipping_code'))->leftJoin($prefix . 'shipping_area', $prefix . 'shipping_area.shipping_id = ' . $prefix . 'shipping.shipping_id')->leftJoin($prefix . 'area_region', $prefix . 'area_region.shipping_area_id = ' . $prefix . 'shipping_area.shipping_area_id')->andWhere(array($prefix . 'shipping.enabled' => 1))->andWhere(array($prefix . 'shipping.shipping_id' => $shipping_id));

		if (!empty($region_id_list)) {
			$model->andWhere(array('in', $prefix . 'area_region.region_id', $region_id_list));
		}

		$result = $model->asArray()->one();

		if (!empty($result['configure'])) {
			$configure = self::getConfigure($result['configure']);
			$fee = self::calculate($configure, $result['shipping_code'], $weight, $amount, $number);
			return Goods::price_format($fee, false);
		}

		return false;
	}
}

?>
