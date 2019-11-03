<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class OrderReturn extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'order_return';
	protected $primaryKey = 'ret_id';
	public $timestamps = false;
	protected $fillable = array('return_sn', 'goods_id', 'user_id', 'rec_id', 'order_id', 'order_sn', 'credentials', 'maintain', 'back', 'goods_attr', 'exchange', 'return_type', 'attr_val', 'cause_id', 'apply_time', 'return_time', 'should_return', 'actual_return', 'return_shipping_fee', 'return_brief', 'remark', 'country', 'province', 'city', 'district', 'street', 'addressee', 'phone', 'address', 'zipcode', 'is_check', 'return_status', 'refound_status', 'back_shipping_name', 'back_other_shipping', 'back_invoice_no', 'out_shipping_name', 'out_invoice_no', 'agree_apply', 'chargeoff_status');
	protected $guarded = array();
}

?>
