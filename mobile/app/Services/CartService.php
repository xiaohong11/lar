<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\services;

class CartService
{
	private $cartRepository;
	private $goodsRepository;
	private $goodsTransformer;
	private $authService;

	public function __construct(\app\repositories\cart\CartRepository $cartRepository, \app\repositories\goods\GoodsRepository $goodsRepository, \app\api\v2\wx\transformer\GoodsTransformer $goodsTransformer, AuthService $authService)
	{
		$this->cartRepository = $cartRepository;
		$this->goodsRepository = $goodsRepository;
		$this->goodsTransformer = $goodsTransformer;
		$this->authService = $authService;
	}

	public function getCart()
	{
		$cart = $this->getCartGoods();
		$result = array();

		foreach ($cart['goods_list'] as $v) {
			$result['cart_list'][] = array('rec_id' => $v['rec_id'], 'user_id' => $v['user_id'], 'goods_id' => $v['goods_id'], 'goods_name' => $v['goods_name'], 'market_price' => $v['market_price'], 'goods_price' => $v['goods_price'], 'goods_number' => $v['goods_number'], 'goods_attr' => $v['goods_attr'], 'goods_attr_id' => $v['goods_attr_id'], 'goods_thumb' => $v['goods_thumb']);
		}

		$result['total_price'] = $cart['total']['goods_price'];
		$result['best_goods'] = $this->getBestGoods();
		return $result;
	}

	private function getCartGoods()
	{
		$userId = $this->authService->authorization();
		$list = $this->cartRepository->getGoodsInCartByUser($userId);
		return $list;
	}

	private function getBestGoods()
	{
		$list = $this->goodsRepository->findByType('best');
		$bestGoods = $this->goodsTransformer->transformCollection($list);
		return $bestGoods;
	}

	public function addGoodsToCart($params)
	{
		$goods = $this->goodsRepository->find($params['id']);

		if ($goods['is_on_sale'] != 1) {
			return '商品已下架';
		}

		$goodsAttr = (empty($params['goods_attr']) ? '' : $params['goods_attr']);
		$product = $this->goodsRepository->getProductByGoods($params['id'], $goodsAttr);
		$arguments = array('goods_id' => $params['id'], 'user_id' => $params['uid'], 'goods_sn' => $goods['goods_sn'], 'product_id' => empty($product['id']) ? '' : $product['id'], 'group_id' => '', 'goods_name' => $goods['goods_name'], 'market_price' => $goods['market_price'], 'goods_price' => $goods['shop_price'], 'goods_number' => $params['num'], 'goods_attr' => $params['goods_attr'], 'is_real' => $goods['is_real'], 'extension_code' => empty($params['extension_code']) ? '' : $params['extension_code'], 'parent_id' => $params['num'], 'rec_type' => CART_GENERAL_GOODS, 'is_gift' => $params['num'], 'is_shipping' => $goods['is_shipping'], 'can_handsel' => '', 'model_attr' => $goods['model_attr'], 'goods_attr_id' => '', 'ru_id' => $goods['user_id'], 'shopping_fee' => '', 'warehouse_id' => '', 'area_id' => '', 'add_time' => time(), 'stages_qishu' => '', 'store_id' => '', 'freight' => '', 'tid' => '', 'shipping_fee' => '', 'store_mobile' => '', 'take_time' => '', 'is_checked' => '');
		return $this->cartRepository->addGoodsToCart($arguments);
	}
}


?>
