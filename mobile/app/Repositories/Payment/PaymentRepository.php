<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace app\repositories\payment;

class PaymentRepository implements \app\contracts\repository\payment\PaymentRepositoryInterface
{
	public function paymentList()
	{
		$payment = \app\models\Payment::select('pay_id', 'pay_code', 'pay_name', 'pay_fee', 'pay_desc', 'pay_config', 'is_cod')->where('enabled', 1)->get()->toArray();
		return $payment;
	}
}

?>
