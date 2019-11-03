<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\user;

class MemberPriceRepository implements \app\contracts\repository\user\MemberPriceRepositoryInterface
{
	public function getMemberPriceByUid($rank, $goods_id)
	{
		$price = \app\models\MemberPrice::where('user_rank', $rank)->where('goods_id', $goods_id)->pluck('user_price');

		if ($price) {
			$price = $price[0];
		}

		return $price;
	}
}

?>
