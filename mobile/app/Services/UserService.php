<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\services;

class UserService
{
	private $orderRepository;
	private $goodsRepository;
	private $userGoodsTransformer;

	public function __construct(\app\repositories\order\OrderRepository $orderRepository, \app\repositories\goods\GoodsRepository $goodsRepository, \app\api\v2\wx\transformer\UserGoodsTransformer $userGoodsTransformer)
	{
		$this->orderRepository = $orderRepository;
		$this->goodsRepository = $goodsRepository;
		$this->userGoodsTransformer = $userGoodsTransformer;
	}

	public function userCenter(array $args)
	{
		$user_id = $args['id'];
		$result['order'] = $this->orderRepository->getOrderByUserId($user_id);
		$bestGoods = $this->goodsRepository->findByType('best');
		$result['best_goods'] = $this->userGoodsTransformer->transformCollection($bestGoods);
		return $result;
	}

	public function orderList($args)
	{
		$orderList = $this->orderRepository->getOrderByUserId($args['uid'], $args['status']);

		foreach ($orderList as $k => $v) {
			$orderList[$k]['add_time'] = date('Y-m-d H:i', $v['add_time']);
			$orderList[$k]['order_status'] = $this->orderStatus($v['order_status']);
			$orderList[$k]['pay_status'] = $this->payStatus($v['pay_status']);
			$orderList[$k]['shipping_status'] = $this->shipStatus($v['shipping_status']);
			$dataTotalNumber = 0;

			foreach ($v['goods'] as $gk => $gv) {
				$dataTotalNumber += $gv['goods_number'];
				unset($orderList[$k]['goods'][$gk]['goods']);
			}

			$orderList[$k]['goods'] = array_slice($orderList[$k]['goods'], 0, 3);
			$orderList[$k]['total_number'] = $dataTotalNumber;
			$orderList[$k]['total_amount'] = price_format($v['money_paid'] + $v['order_amount'], false);
		}

		return $orderList;
	}

	private function orderStatus($num)
	{
		$array = array('未确认', '已确认', '已取消', '无效', '退货', '已分单', '部分分单');
		return $array[$num];
	}

	private function payStatus($num)
	{
		$array = array('未付款', '付款中', '已付款');
		return $array[$num];
	}

	private function shipStatus($num)
	{
		$array = array('未发货', '已发货', '已收货', '备货中', '已发货(部分商品)', '发货中(处理分单)', '已发货(部分商品)');
		return $array[$num];
	}
}


?>
