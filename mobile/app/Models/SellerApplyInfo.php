<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SellerApplyInfo extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seller_apply_info';
	protected $primaryKey = 'apply_id';
	public $timestamps = false;
	protected $fillable = array('ru_id', 'grade_id', 'apply_sn', 'pay_status', 'apply_status', 'total_amount', 'payable_amount', 'refund_price', 'back_price', 'fee_num', 'pay_fee', 'entry_criteria', 'add_time', 'is_confirm', 'pay_time', 'pay_id', 'is_paid', 'confirm_time', 'reply_seller', 'valid');
	protected $guarded = array();
}

?>
