<?php
//zend by 旺旺ecshop2011所有  禁止倒卖 一经发现停止任何服务
namespace App\Models;

class SellerAccountLog extends \Illuminate\Database\Eloquent\Model
{
	protected $table = 'seller_account_log';
	protected $primaryKey = 'log_id';
	public $timestamps = false;
	protected $fillable = array('admin_id', 'real_id', 'ru_id', 'order_id', 'amount', 'frozen_money', 'certificate_img', 'deposit_mode', 'log_type', 'apply_sn', 'pay_id', 'pay_time', 'admin_note', 'add_time', 'seller_note', 'is_paid');
	protected $guarded = array();
}

?>
