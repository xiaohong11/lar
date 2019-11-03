<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\services;

class FlowService
{
	const CART_GENERAL_GOODS = 0;
	const SDT_SHIP = 0;
	const SDT_PLACE = 1;

	private $cartRepository;
	private $addressRepository;
	private $paymentRepository;
	private $shippingRepository;
	private $shopConfigRepository;
	private $goodsRepository;
	private $productRepository;
	private $authService;
	private $orderRepository;
	private $orderGoodsRepository;
	private $accountRepository;
	private $payLogRepository;

	public function __construct(\app\repositories\cart\CartRepository $cartRepository, \app\repositories\user\AddressRepository $addressRepository, \app\repositories\payment\PaymentRepository $paymentRepository, \app\repositories\shipping\ShippingRepository $shippingRepository, \app\repositories\shopconfig\ShopConfigRepository $shopConfigRepository, \app\repositories\goods\GoodsRepository $goodsRepository, \app\repositories\product\ProductRepository $productRepository, AuthService $authService, \app\repositories\order\OrderRepository $orderRepository, \app\repositories\order\OrderGoodsRepository $orderGoodsRepository, \app\repositories\user\AccountRepository $accountRepository, \app\repositories\payment\PayLogRepository $payLogRepository)
	{
		$this->cartRepository = $cartRepository;
		$this->addressRepository = $addressRepository;
		$this->paymentRepository = $paymentRepository;
		$this->shippingRepository = $shippingRepository;
		$this->shopConfigRepository = $shopConfigRepository;
		$this->goodsRepository = $goodsRepository;
		$this->productRepository = $productRepository;
		$this->authService = $authService;
		$this->orderRepository = $orderRepository;
		$this->orderGoodsRepository = $orderGoodsRepository;
		$this->accountRepository = $accountRepository;
		$this->payLogRepository = $payLogRepository;
	}

	public function flowInfo()
	{
		$result = array();
		$result['cart_goods_list'] = $this->cartRepository->getAllCartGoods();
		$result['address_list'] = $this->addressRepository->addressListByUserId($userId);
		$result['shipping_list'] = $this->shippingRepository->shippingList();
		$result['payment_list'] = $this->paymentRepository->paymentList();
		return $result;
	}

	public function submitOrder($args)
	{
		$userId = $this->authService->authorization();

		if (empty($userId)) {
			$userId = 1;
		}

		$flow_type = self::CART_GENERAL_GOODS;
		$goodsNum = $this->cartRepository->goodsNumInCartByUser($userId);
		if (($this->shopConfigRepository->getShopConfigByCode('use_storage') == 1) && ($this->shopConfigRepository->getShopConfigByCode('stock_dec_time') == SDT_PLACE)) {
			$cart_goods = $this->cartRepository->getGoodsInCartByUser($userId);
			$_cart_goods_stock = array();

			foreach ($cart_goods['goods_list'] as $value) {
				$_cart_goods_stock[$value['rec_id']] = $value['goods_number'];
			}

			if (!$this->flow_cart_stock($_cart_goods_stock)) {
				return array('error' => 1, 'msg' => '库存不足');
			}

			unset($cart_goods_stock);
			unset($_cart_goods_stock);
		}

		$consignee = $args['consignee'];
		$consignee_info = $this->addressRepository->find($consignee);
		$order = array('shipping_id' => intval($args['shipping']), 'pay_id' => intval(0), 'surplus' => isset($args['surplus']) ? floatval($args['surplus']) : 0, 'integral' => isset($score) ? intval($score) : 0, 'inv_type' => '', 'inv_payee' => '', 'inv_content' => '', 'postscript' => trim($args['']), 'how_oos' => '', 'user_id' => $userId, 'add_time' => time(), 'order_status' => \app\models\OrderInfo::OS_UNCONFIRMED, 'shipping_status' => \app\models\OrderInfo::SS_UNSHIPPED, 'pay_status' => \app\models\OrderInfo::PS_UNPAYED, 'agency_id' => 0);
		$order['extension_code'] = '';
		$order['extension_id'] = 0;

		if (!isset($cart_goods)) {
			$cart_goods = $this->cartRepository->getGoodsInCartByUser($userId);
		}

		$cartGoods = $cart_goods['goods_list'];
		$cart_good_ids = array();

		foreach ($cartGoods as $k => $v) {
			array_push($cart_good_ids, $v['rec_id']);
		}

		if (empty($cart_goods)) {
			return array('error' => 1, 'msg' => '购物车没有商品');
		}

		$order['consignee'] = $consignee_info->consignee;
		$order['country'] = $consignee_info->country;
		$order['province'] = $consignee_info->province;
		$order['city'] = $consignee_info->city;
		$order['mobile'] = $consignee_info->mobile;
		$order['tel'] = $consignee_info->tel;
		$order['zipcode'] = $consignee_info->zipcode;
		$order['district'] = $consignee_info->district;
		$order['address'] = $consignee_info->address;

		foreach ($cartGoods as $val) {
			if ($val['is_real']) {
				$is_real_good = 1;
			}
		}

		if (isset($is_real_good)) {
			$shipping_is_real = $this->shippingRepository->find($order['shipping_id']);

			if (!$shipping_is_real) {
				return array('error' => 1, 'msg' => '配送方式不正确');
			}
		}

		$total = $this->orderRepository->order_fee($order, $cart_goods, $consignee_info, $cart_good_ids, $order['shipping_id'], $consignee);

		if (!empty($order['bonus_id'])) {
			$bonus = BonusType::bonus_info($order['bonus_id']);
			$total['bonus'] = $bonus['type_money'];
		}

		$order['bonus'] = isset($bonus) ? $bonus['type_money'] : '';
		$order['goods_amount'] = $total['goods_price'];
		$order['discount'] = $total['discount'];
		$order['surplus'] = $total['surplus'];
		$order['tax'] = $total['tax'];

		if (0 < $order['shipping_id']) {
			$shipping = $this->shippingRepository->find($order['shipping_id']);
			$order['shipping_name'] = addslashes($shipping['shipping_name']);
		}

		$order['shipping_fee'] = $total['shipping_fee'];
		$order['insure_fee'] = 0;

		if (0 < $order['pay_id']) {
			$order['pay_name'] = '微信支付';
		}

		$order['pay_name'] = '微信支付';
		$order['pay_fee'] = $total['pay_fee'];
		$order['cod_fee'] = $total['cod_fee'];
		$order['order_amount'] = number_format($total['amount'], 2, '.', '');

		if ($order['order_amount'] <= 0) {
			$order['order_status'] = \app\models\OrderInfo::OS_CONFIRMED;
			$order['confirm_time'] = time();
			$order['pay_status'] = \app\models\OrderInfo::PS_PAYED;
			$order['pay_time'] = time();
			$order['order_amount'] = 0;
		}

		$order['integral_money'] = $total['integral_money'];
		$order['integral'] = $total['integral'];
		$order['parent_id'] = 0;
		$order['order_sn'] = $this->getOrderSn();
		unset($order['timestamps']);
		unset($order['perPage']);
		unset($order['incrementing']);
		unset($order['dateFormat']);
		unset($order['morphClass']);
		unset($order['exists']);
		unset($order['wasRecentlyCreated']);
		unset($order['cod_fee']);
		$order['bonus'] = !empty($order['bonus']) ? $order['bonus'] : (!empty($order['bonus_id']) ? $order['bonus_id'] : 0);
		$new_order_id = $this->orderRepository->insertGetId($order);
		$order['order_id'] = $new_order_id;
		$this->orderGoodsRepository->insertOrderGoods($cartGoods, $order['order_id']);
		if ((0 < $order['user_id']) && (0 < $order['integral'])) {
			$this->accountRepository->logAccountChange(0, 0, 0, $order['integral'] * -1, trans('message.score.pay'), $order['order_sn'], $userId);
		}

		if (($this->shopConfigRepository->getShopConfigByCode('use_storage') == '1') && ($this->shopConfigRepository->getShopConfigByCode('stock_dec_time') == self::SDT_PLACE)) {
			$this->orderRepository->changeOrderGoodsStorage($order['order_id'], true, self::SDT_PLACE);
		}

		$this->clear_cart_ids($cart_good_ids, $flow_type);
		$order['log_id'] = $this->payLogRepository->insert_pay_log($new_order_id, $order['order_amount'], PAY_ORDER);
		$order_id = $order['order_id'];
		return $order_id;
	}

	public function flow_cart_stock($arr)
	{
		foreach ($arr as $key => $val) {
			$val = intval(make_semiangle($val));
			if (($val <= 0) || !is_numeric($key)) {
				continue;
			}

			$goods = $this->cartRepository->field(array('goods_id', 'goods_attr_id', 'extension_code'))->find($key);
			$row = $this->goodsRepository->cartGoods($key);
			if ((0 < intval($this->shopConfigRepository->getShopConfigByCode('use_storage'))) && ($goods['extension_code'] != 'package_buy')) {
				if ($row['goods_number'] < $val) {
					return false;
				}

				$row['product_id'] = trim($row['product_id']);

				if (!empty($row['product_id'])) {
					$product_number = $this->productRepository->findBy(array('goods_id' => $goods['goods_id'], 'product_id' => $row['product_id']))->column('product_number');

					if ($product_number < $val) {
						return false;
					}
				}
			}
		}

		return true;
	}

	public function getOrderSn()
	{
		mt_srand((double) microtime() * 1000000);
		return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
	}

	private function clear_cart_ids($arr, $type = self::CART_GENERAL_GOODS)
	{
		$uid = $this->authService->authorization();

		if (is_array($arr)) {
			$arr = '(' . implode(',', $arr) . ')';
		}

		$this->cartRepository->deleteAll(array(
	array('in', 'rec_id', $arr),
	array('rec_type', $type),
	array('user_id', $uid)
	));
	}
}


?>
