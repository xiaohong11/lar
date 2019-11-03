<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\user;

class AccountRepository implements \app\contracts\repository\user\AccountRepositoryInterface
{
	static public function logAccountChange($user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = 99, $uid)
	{
		$flag = 0;

		if ($member = \app\models\Users::where('user_id', $uid)->first()) {
			$member->user_money += $user_money;
			$member->frozen_money += $frozen_money;
			$member->rank_points += $rank_points;
			$member->pay_points += $pay_points;
			$flag = $member->save();
		}

		if ($flag) {
			$model = new \app\models\AccountLog();
			$model->user_id = $uid;
			$model->pay_points = $pay_points;
			$model->change_desc = $change_desc;
			$model->user_money = $user_money;
			$model->rank_points = $rank_points;
			$model->frozen_money = $frozen_money;
			$model->change_type = $change_type;
			$model->change_time = time();

			if ($model->save()) {
				return true;
			}
		}

		return false;
	}
}

?>
