<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\payment;

class PayLogRepository implements \app\contracts\repository\payment\PayLogRepositoryInterface
{
	public function insert_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0)
	{
		$payLog = new \app\models\PayLog();
		$payLog->order_id = $id;
		$payLog->order_amount = $amount;
		$payLog->order_type = $type;
		$payLog->is_paid = $is_paid;
		$payLog->save();
		return $payLog->log_id;
	}
}

?>
