<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\user;

class UserRankRepository implements \app\contracts\repository\user\UserRankRepositoryInterface
{
	private $authService;
	private $memberPriceRepository;

	public function __construct(\app\services\AuthService $authService, MemberPriceRepository $memberPriceRepository)
	{
		$this->authService = $authService;
		$this->memberPriceRepository = $memberPriceRepository;
	}

	public function getUserRankByUid()
	{
		$uid = $this->authService->authorization();

		if (empty($uid)) {
			$data = null;
		}
		else {
			$user = \app\models\Users::where(array('user_id' => $uid))->first();

			if (!$user) {
				$data = null;
			}
			else {
				$user_rank = \app\models\UserRank::where('special_rank', 0)->where('min_points', '<=', $user->rank_points)->where('max_points', '>', $user->rank_points)->first();
				$data['rank_id'] = $user_rank->rank_id;
				$data['discount'] = $user_rank->discount * 0.01;
			}
		}

		return $data;
	}

	public function getMemberRankPriceByGid($goods_id)
	{
		$user_rank = $this->getUserRankByUid();
		$shop_price = \app\models\Goods::where('goods_id', $goods_id)->pluck('shop_price');
		$shop_price = $shop_price[0];

		if ($user_rank) {
			if ($price = $this->memberPriceRepository->getMemberPriceByUid($user_rank['rank_id'], $goods_id)) {
				return $price;
			}

			if ($user_rank['discount']) {
				$member_price = $shop_price * $user_rank['discount'];
			}
			else {
				$member_price = $shop_price;
			}

			return $member_price;
		}
		else {
			return $shop_price;
		}
	}
}

?>
