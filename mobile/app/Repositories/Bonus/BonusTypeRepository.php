<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\bonus;

class BonusTypeRepository implements \app\contracts\repository\bonus\BonusTypeRepositoryInterface
{
	public function bonusInfo($bonus_id, $bonus_sn = '')
	{
		return self::join('user_bonus', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id')->where('bonus_id', $bonus_id)->first();
	}
}

?>
