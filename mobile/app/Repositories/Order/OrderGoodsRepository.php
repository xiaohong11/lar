<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\order;

class OrderGoodsRepository implements \app\contracts\repository\order\OrderGoodsRepositoryInterface
{
	public function insertOrderGoods($goods, $orderId)
	{
		foreach ($goods as $v) {
			$orderGoods = new \app\models\OrderGoods();
			$orderGoods->order_id = $orderId;
			$orderGoods->goods_id = $v['goods_id'];
			$orderGoods->goods_name = $v['goods_name'];
			$orderGoods->goods_sn = $v['goods_sn'];
			$orderGoods->product_id = $v['product_id'];
			$orderGoods->goods_number = $v['goods_number'];
			$orderGoods->market_price = $v['market_price'];
			$orderGoods->goods_price = $v['goods_price'];
			$orderGoods->goods_attr = $v['goods_attr'];
			$orderGoods->is_real = $v['is_real'];
			$orderGoods->extension_code = $v['extension_code'];
			$orderGoods->parent_id = $v['parent_id'];
			$orderGoods->is_gift = $v['is_gift'];
			$orderGoods->goods_attr_id = $v['goods_attr_id'];
			$orderGoods->save();
		}
	}
}

?>
