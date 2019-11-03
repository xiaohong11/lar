<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\cart;

class CartRepository implements \app\contracts\repository\cart\CartRepositoryInterface
{
	private $model;
	private $shopConfigRepository;
	private $userRankRepository;
	private $authService;
	private $goodsRepository;

	public function __construct(\app\repositories\shopconfig\ShopConfigRepository $shopConfigRepository, \app\repositories\user\UserRankRepository $userRankRepository, \app\services\AuthService $authService, \app\repositories\goods\GoodsRepository $goodsRepository)
	{
		$this->shopConfigRepository = $shopConfigRepository;
		$this->userRankRepository = $userRankRepository;
		$this->authService = $authService;
		$this->goodsRepository = $goodsRepository;
		$this->model = \app\models\Cart::where('rec_id', '<>', 0);
	}

	public function field($columns)
	{
		$this->model->select($columns);
		return $this;
	}

	public function find($rec_id)
	{
		$cart = $this->model->where('rec_id', $rec_id)->first();

		if ($cart === null) {
			return array();
		}

		return $cart->toArray();
	}

	public function addGoodsToCart($params)
	{
		$model = new \app\models\Cart();

		foreach ($params as $k => $v) {
			$model->$k = $v;
		}

		$res = $model->save();

		if ($res) {
			return true;
		}

		return false;
	}

	public function getAllCartGoods()
	{
		$cart = \app\models\Cart::select('rec_id', 'user_id', 'goods_id', 'goods_name', 'market_price', 'goods_price', 'goods_number', 'goods_attr')->get()->toArray();
		return $cart;
	}

	public function goodsNumInCartByUser($id)
	{
		return \app\models\Cart::where('user_id', $id)->count();
	}

	public function getGoodsInCartByUser($id)
	{
		$cart = \app\models\Cart::select('*')->where('user_id', $id)->where('rec_type', CART_GENERAL_GOODS)->orderby('rec_id', 'desc')->get()->toArray();
		$total = array();
		$goods_list = array();
		$virtual_goods_count = 0;
		$real_goods_count = 0;

		foreach ($cart as $v) {
			$total['goods_price'] += $v['goods_price'] * $v['goods_number'];
			$total['market_price'] += $v['market_price'] * $v['goods_number'];
			$v['subtotal'] = price_format($v['goods_price'] * $v['goods_number'], false);
			$v['goods_price'] = price_format($v['goods_price'], false);
			$v['market_price'] = price_format($v['market_price'], false);

			if ($v['is_real']) {
				$real_goods_count++;
			}
			else {
				$virtual_goods_count++;
			}

			$goods_list[] = $v;
		}

		$total['goods_amount'] = $total['goods_price'];
		$total['saving'] = price_format($total['market_price'] - $total['goods_price'], false);

		if (0 < $total['market_price']) {
			$total['save_rate'] = $total['market_price'] ? round((($total['market_price'] - $total['goods_price']) * 100) / $total['market_price']) . '%' : 0;
		}

		$total['goods_price'] = price_format($total['goods_price'], false);
		$total['market_price'] = price_format($total['market_price'], false);
		$total['real_goods_count'] = $real_goods_count;
		$total['virtual_goods_count'] = $virtual_goods_count;
		return array('goods_list' => $goods_list, 'total' => $total);
	}

	public function deleteAll($arr)
	{
		$cartModel = new \app\models\Cart();

		foreach ($arr as $k => $v) {
			if ((count($v) == 3) && ($v[0] == 'in')) {
				$cartModel->whereIn($v[1], $v[2]);
			}
			else if (count($v) == 2) {
				$cartModel->where($v[0], $v[1]);
			}
		}

		$cartModel->delete();
	}

	public function computeDiscountCheck($order_products)
	{
		$now = time();
		$user_rank = $this->userRankRepository->getUserRankByUid();
		$user_rank = ',' . $user_rank['rank_id'] . ',';
		$favourable_list = \app\models\FavourableActivity::where('start_time', '<=', $now)->where('end_time', '>=', $now)->whereraw('CONCAT(\',\', user_rank, \',\') LIKE \'%' . $user_rank . '%\'')->wherein('act_type', array(\app\models\FavourableActivity::FAT_DISCOUNT, \app\models\FavourableActivity::FAT_PRICE))->get()->toArray();

		if (!$favourable_list) {
			return 0;
		}

		$goods_list = $order_products;

		foreach ($goods_list as $key => $good) {
			$good_property = array();

			if ($good['goods_attr_id']) {
				$good_property = explode(',', $good['goods_attr_id']);
			}

			$goods_list[$key]['price'] = $this->goodsRepository->getFinalPrice($good['goods_id'], $good['goods_number'], true, $good_property);
			$goods_list[$key]['amount'] = $good['goods_number'];
		}

		if (!$goods_list) {
			return 0;
		}

		$discount = 0;
		$favourable_name = array();

		foreach ($favourable_list as $favourable) {
			$total_amount = 0;

			if ($favourable['act_range'] == \app\models\FavourableActivity::FAR_ALL) {
				foreach ($goods_list as $goods) {
					$total_amount += $goods['goods_price'] * $goods['goods_number'];
				}
			}
			else if ($favourable['act_range'] == \app\models\FavourableActivity::FAR_CATEGORY) {
			}
			else if ($favourable['act_range'] == \app\models\FavourableActivity::FAR_BRAND) {
				foreach ($goods_list as $goods) {
					$brand_id = $this->goodsRepository->getBrandIdByGoodsId($goods['goods_id']);

					if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $brand_id . ',') !== false) {
						$total_amount += $goods['goods_price'] * $goods['goods_number'];
					}
				}
			}
			else if ($favourable['act_range'] == \app\models\FavourableActivity::FAR_GOODS) {
				foreach ($goods_list as $goods) {
					if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
						$total_amount += $goods['goods_price'] * $goods['goods_number'];
					}
				}
			}
			else {
				continue;
			}

			if ((0 < $total_amount) && ($favourable['min_amount'] <= $total_amount) && (($total_amount <= $favourable['max_amount']) || ($favourable['max_amount'] == 0))) {
				if ($favourable['act_type'] == \app\models\FavourableActivity::FAT_DISCOUNT) {
					$discount += $total_amount * (1 - ($favourable['act_type_ext'] / 100));
				}
				else if ($favourable['act_type'] == \app\models\FavourableActivity::FAT_PRICE) {
					$discount += $favourable['act_type_ext'];
				}
			}
		}

		return $discount;
	}

	public function getGiveIntegral()
	{
		$uid = $this->authService->authorization();
		$prefix = 'dsc_';
		$allIntegral = \app\models\Cart::from('cart as c')->selectraw('SUM(' . $prefix . 'c.goods_number * IF(' . $prefix . 'g.give_integral > -1, ' . $prefix . 'g.give_integral, ' . $prefix . 'c.goods_price))')->leftjoin('goods as g', 'c.goods_id', '=', 'g.goods_id')->where('c.goods_id', '>', 0)->where('c.parent_id', 0)->where('c.rec_type', 0)->where('c.is_gift', 0)->where('c.user_id', $uid)->get()->toArray();
		$sum = 0;

		foreach ($allIntegral as $key => $value) {
			if (-1 < $value['give_integral']) {
				$sum += $value['give_integral'] * $value['goods_number'];
			}
			else {
				$sum += $value['goods_price'] * $value['goods_number'];
			}
		}

		return $sum;
	}
}

?>
